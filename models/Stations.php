<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Stations extends ActiveRecord
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
            ['name', 'string']
        ];
    }
}