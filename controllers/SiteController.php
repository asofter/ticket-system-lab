<?php

namespace app\controllers;

use app\components\TrainHelper;
use app\models\FindForm;
use app\models\PrepareForm;
use app\models\Stations;
use app\models\Tickets;
use app\models\TrainPrices;
use app\models\Trains;
use app\models\TrainSchedule;
use app\models\TrainStations;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\Response;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [

                ],
            ]
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionValidateSearch() {
        if(!Yii::$app->getRequest()->isAjax || !Yii::$app->getRequest()->isPost) {
            throw new HttpException(403);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = ['success' => 1];

        $form = new FindForm();
        if($form->load($_POST) && $form->validate()) {
           if(strtotime($form->date) < time()) {
               $result['error'] = "Дата не може бути раніше, ніж сьогодні.";
               $result['success'] = 0;
           }
        } else {
            $result['success'] = 0;
            $result['error'] = "Валідація не пройдена.";
        }

        return $result;
    }

    public function actionGetStations($term) {
        if(!Yii::$app->getRequest()->isAjax) {
            throw new HttpException(403);
        }

        $stations = TrainHelper::getStations($term);

        $data = [];
        foreach($stations as $station) {
            $data[] = [
                'label' => $station['name'],
                'id' => $station['id'],
            ];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;

        return $data;
    }

    public function actionIndex()
    {
        $form = new FindForm();
        if($form->load($_POST) && $form->validate()) {
            return $this->redirect(['/search', 'date' => $form->date, 'from_station' => $form->from_station, 'to_station' => $form->to_station]);
        }

        $this->layout = 'landing';
        return $this->render('index', ['searchForm' => $form]);
    }

    public function actionSearch($date, $from_station, $to_station) {
        // Get from station information (name)
        $fromStation = Stations::findOne($from_station);
        if(!$fromStation) {
            throw new HttpException(404);
        }

        // Get to station information (name)
        $toStation = Stations::findOne($to_station);
        if(!$toStation) {
            throw new HttpException(404);
        }

        // Get all available trains on direction
        $trainsFrom = TrainStations::find()->andWhere(['station_id' => $fromStation['id']])->groupBy(['train_id'])->asArray()->all();
        $trainsTo = TrainStations::find()->andWhere(['station_id' => $toStation['id']])->groupBy(['train_id'])->asArray()->all();
        $trainsFromByIds = ArrayHelper::map($trainsFrom, 'id', 'train_id');
        $trainsToByIds = ArrayHelper::map($trainsTo, 'id', 'train_id');
        $trainsIds = array_intersect(ArrayHelper::map($trainsFrom, 'id', 'train_id'), ArrayHelper::map($trainsTo, 'id', 'train_id'));
        $trains = Trains::find()->andWhere(['id' => $trainsIds])->all();

        // Get schedules
        $trainSchedules = TrainSchedule::find()->andWhere(['train_station_id' => ArrayHelper::merge(ArrayHelper::map($trainsFrom, 'id', 'id'), ArrayHelper::map($trainsTo, 'id', 'id'))])->asArray()->all();
        $trainSchedules = ArrayHelper::map($trainSchedules, 'train_station_id', 'time');
        $schedules = [];
        foreach($trainsFrom as $trainFrom) {
            $schedules[$trainFrom['train_id']]['from'] = $trainSchedules[$trainFrom['id']];
        }
        foreach($trainsTo as $trainTo) {;
            $schedules[$trainTo['train_id']]['to'] = $trainSchedules[$trainTo['id']];
        }

        // Get paid tickets count
        $ticketsCount = [];
        foreach($trains as $train) {
            $allTicketsCount = Tickets::find()->andWhere(['train_id' => $train['id'], 'status' => Tickets::STATUS_PAID, 'date' => $date, 'from_station_id' => $fromStation['id'], 'to_station_id' => $toStation['id']])->count();
            $ticketsCount[$train['id']] = $allTicketsCount;
        }

        // Get prices
        $allPrices = TrainPrices::find()->andWhere(['from_train_station_id' => ArrayHelper::map($trainsFrom, 'id', 'id'), 'to_train_station_id' => ArrayHelper::map($trainsTo, 'id', 'id')])->asArray()->all();
        $prices = [];
        foreach($allPrices as $price) {
            $prices[$trainsFromByIds[$price['from_train_station_id']]] = $price['price'];
        }

        return $this->render('search', [
            'fromStation' => $fromStation,
            'toStation' => $toStation,
            'date' => $date,
            'trains' => $trains,
            'schedules' => $schedules,
            'ticketsCount' => $ticketsCount,
            'prices' => $prices
        ]);
    }

    public function actionPrepare($date, $from_station, $to_station, $train_id) {
        if(!Yii::$app->getRequest()->isAjax) {
            throw new HttpException(403);
        }
        // Get from station information (name)
        $fromStation = Stations::findOne($from_station);
        if(!$fromStation) {
            throw new HttpException(404);
        }

        // Get to station information (name)
        $toStation = Stations::findOne($to_station);
        if(!$toStation) {
            throw new HttpException(404);
        }

        $form = new PrepareForm();
        $form->date = $date;
        $form->from_station = $from_station;
        $form->to_station = $to_station;
        $form->train_id = $train_id;

        return $this->renderAjax('prepare', [
            'prepareForm' => $form,
            'date' => $date,
            'fromStation' => $fromStation,
            'toStation' => $toStation
        ]);
    }

    public function actionBuy() {
        if(!Yii::$app->getRequest()->isPost) {
            throw new HttpException(403);
        }

        $form = new PrepareForm();
        if($form->load($_POST) && $form->validate()) {
            $user = User::findOne(['email' => $form->email]);
            if(!$user) {
                $user = new User();
                $user->setPassword(Yii::$app->getSecurity()->generateRandomString(6));
                $user->generateAuthKey();
                $user->email = $form->email;
                $user->first_name = $form->first_name;
                $user->last_name = $form->last_name;
                $user->save();
            }
            $ticket = new Tickets();
            $ticket->date = $form->date;
            $ticket->from_station_id = $form->from_station;
            $ticket->to_station_id = $form->to_station;
            $ticket->train_id = $form->train_id;
            $ticket->pay_method = $form->pay_method;
            $ticket->user_id = $user->id;
            $ticket->status = Tickets::STATUS_PAID;
            if($ticket->save()) {
                return $this->redirect(['/thanks', 'id' => $ticket->id]);
            } else {
                Yii::$app->session->setFlash('error', "Ви допустили помилку і система не може обробити запит. Спробуйте ще раз.");
                return $this->goBack();
            }
        }

        // TODO: show prices
        // TODO: reserve place for user
    }

    public function actionThanks($id) {
        $ticket = Tickets::findOne($id);
        if(!$ticket) {
            throw new HttpException(404);
        }

        return $this->render('thanks', ['ticket' => $ticket]);
    }

    public function actionGetTicket($id) {
        return $this->runAction('thanks', ['id' => $id]);
    }

    public function actionPrintTicket($id) {
        $ticket = Tickets::findOne($id);
        if(!$ticket) {
            throw new HttpException(404);
        }

        $ticket = $this->renderPartial('ticket', ['ticket' => $ticket]);

        $mpdf = new \mPDF('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10);
        $mpdf->charset_in = 'utf-8';
        $mpdf->WriteHTML($ticket);
        $mpdf->Output("ticket" . date("Y-m-d") . ".pdf", 'I');
    }
}
