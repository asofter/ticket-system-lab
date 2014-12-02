<?php
namespace app\models;

use yii\base\Model;

class PrepareForm extends Model {
    public $date;
    public $from_station;
    public $to_station;
    public $train_id;
    public $first_name;
    public $last_name;
    public $email;
    public $pay_method;

    public static $payMethods = [
        self::CASH_METHOD => 'Готівка',
        self::VISA_MASTERCARD_METHOD => 'Visa/Mastercard'
    ];
    const CASH_METHOD = 1;
    const VISA_MASTERCARD_METHOD = 2;

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'pay_method', 'email'], 'required'],
            [['from_station', 'to_station', 'train_id'], 'integer'],
            ['date', 'date', 'format' => 'Y-m-d'],
            ['from_station', 'compare', 'compareAttribute' => 'to_station', 'operator' => '!='],
            ['email', 'email'],
            [['first_name', 'last_name'], 'string'],
            ['pay_method', 'in', 'range' => array_keys(self::$payMethods)]
        ];
    }
}