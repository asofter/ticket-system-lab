<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class TrainStations extends ActiveRecord
{
    public function getTrain() {
        return $this->hasOne(Trains::className(), ['id' => 'train_id']);
    }

    public function getStation() {
        return $this->hasOne(TrainStations::className(), ['id' => 'station_id']);
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
            [['train_id', 'station_id'], 'integer']
        ];
    }
}