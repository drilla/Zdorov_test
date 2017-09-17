<?php

namespace frontend\models;

use common\models\Order;
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

    /**
     * создаем Заявку на основе данных формы
     */
    public function createOrder() : Order {

        if (!$this->validate()) {
            throw new \DomainException (join(", \n", $this->getErrors()));
        }

        $order           = new Order();
        $order->scenario = Order::SCENARIO_CREATE;

        $order->product_id     = $this->product_id;
        $order->client_name    = $this->client_name;
        $order->client_phone   = $this->client_phone;
        $order->client_comment = $this->client_comment;

        if (!$order->validate()) {
            throw new \DomainException(join(", \n", $order->getErrors()));
        }

        return $order;
    }
}