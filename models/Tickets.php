<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Tickets extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function getTrain() {
        return $this->hasOne(Trains::className(), ['id' => 'train_id']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
            [
                [
                    'user_id', 'train_id', 'from_station_id',
                    'to_station_id', 'created_at', 'updated_at'
                ], 'integer'
            ],
            ['date', 'string']
        ];
    }
}