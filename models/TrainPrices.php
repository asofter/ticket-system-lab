<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class TrainPrices extends ActiveRecord
{
    public function getFromTrainStation() {
        return $this->hasOne(TrainStations::className(), ['id' => 'from_train_station_id']);
    }

    public function getToTrainStation() {
        return $this->hasOne(TrainStations::className(), ['id' => 'to_train_station_id']);
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
            [['from_train_station_id', 'to_train_station_id'], 'integer'],
            ['price', 'integer', 'min' => 1]
        ];
    }
}