<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class TrainSchedule extends ActiveRecord
{
    public function getTrainStation() {
        return $this->hasOne(TrainStations::className(), ['id' => 'train_station_id']);
    }

    public function attributeLabels() {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['train_station_id'], 'integer'],
            ['time', 'string']
        ];
    }
}