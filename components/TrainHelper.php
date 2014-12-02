<?php
namespace app\components;

use app\models\Stations;
use app\models\Tickets;
use app\models\Trains;
use app\models\TrainSchedule;
use app\models\TrainStations;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class TrainHelper extends Component {

    public static function getStations($term = null) {
        $stations = Stations::find();
        if(!is_null($term) && !empty($term)) {
            $stations->andWhere("name LIKE '%".$term."%'");
        }
        $stations = $stations->orderBy(['name' => SORT_ASC])->asArray()->all();

        return $stations;
    }

    public static function getTicketNumbers($trainsIds, $date, $fromStationId, $toStationId) {
        $ticketsCount = [];
        foreach($trainsIds as $trainId) {
            $allTicketsCount = Tickets::find()->andWhere(['train_id' => $trainId, 'date' => $date, 'from_station_id' => $fromStationId, 'to_station_id' => $toStationId])->count();
            $ticketsCount[$trainId] = $allTicketsCount;
        }

        return $ticketsCount;
    }

    public static function getTrainsForStations($fromStationId, $toStationId) {
        $trainsFrom = TrainStations::find()->andWhere(['station_id' => $fromStationId])->groupBy(['train_id'])->asArray()->all();
        $trainsTo = TrainStations::find()->andWhere(['station_id' => $toStationId])->groupBy(['train_id'])->asArray()->all();
        $trainsIds = array_intersect(ArrayHelper::map($trainsFrom, 'id', 'train_id'), ArrayHelper::map($trainsTo, 'id', 'train_id'));
        $trains = Trains::find()->andWhere(['id' => $trainsIds])->all();

        return $trains;
    }
}