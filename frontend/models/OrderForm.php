<?php
namespace frontend\models;

use yii\base\Model;

class OrderForm extends Model
{
    public $product_id;
    public $client_name;
    public $client_phone;
    public $client_comment;

    public function rules() {
        return [
            [['product_id', 'client_phone', 'client_name'], 'required'],
            ['client_phone', 'string', 'max' => 64],
            ['client_name', 'string', 'max' => 256],
            ['client_comment', 'string', 'max' => 1000],
        ];
    }
}