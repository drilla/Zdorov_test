<?php

namespace backend\views\helpers;

use \common\models;

class Order
{
    public static function createDate(models\Order $order) : string {
        return \Yii::$app->getFormatter()->asDatetime($order->created_at, 'short');
    }

    public static function status(models\Order $order) : string {
        switch ($order->status) {
            case models\Order::STATUS_NEW : return 'Новая';
            case models\Order::STATUS_ACCEPTED : return 'Принята';
            case models\Order::STATUS_REJECTED : return 'Отказана';
            case models\Order::STATUS_DISCARD : return 'Отменена клиентом';
            default : return '-';
        }
    }
}