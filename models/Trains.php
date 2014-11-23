<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Trains extends ActiveRecord
{
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
            [['places_count', 'cars_count'], 'integer', 'min' => 1],
            ['train_number', 'string']
        ];
    }
}