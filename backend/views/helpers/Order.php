<?php

namespace backend\views\helpers;

use \common\models;

class Order
{
    const STATUSES_TEXT = [
        models\Order::STATUS_NEW      => 'Новая',
        models\Order::STATUS_ACCEPTED => 'Принята',
        models\Order::STATUS_REJECTED => 'Отказана',
        models\Order::STATUS_DISCARD  => 'Отменена клиентом',
    ];

    public static function createDate(models\Order $order) : string {
        return \Yii::$app->getFormatter()->asDatetime($order->created_at, 'short');
    }

    public static function status(models\Order $order) : string {
        return self::getStatusText($order->status);
    }

    public static function getStatusText(string $status) : string {
        if (array_key_exists($status, self::STATUSES_TEXT)) {
            return self::STATUSES_TEXT[$status];
        } else {
            return '-';
        }
    }

    public static function statusListItems() : array {
        return self::STATUSES_TEXT;
    }
}