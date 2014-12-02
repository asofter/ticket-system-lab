<?php
namespace app\models;

use yii\base\Model;

class FindForm extends Model {
    public $date;
    public $from_station;
    public $to_station;
    public $from_station_string;
    public $to_station_string;

    public function rules()
    {
        return [
            [['from_station', 'to_station'], 'integer'],
            ['date', 'date', 'format' => 'Y-m-d'],
            ['from_station', 'compare', 'compareAttribute' => 'to_station', 'operator' => '!='],
            [['from_station_string', 'to_station_string'], 'string']
        ];
    }
}