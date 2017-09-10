<?php

namespace backend\views\helpers;

use \common\models;

class Product
{
    public static function status(models\Product $product) : string {
        switch ($product->status) {
            case models\Product::STATUS_ACTIVE : return 'активен';
            case models\Product::STATUS_NOT_ACTIVE : return 'не активен';
            default :
                throw new \Exception('state not known - ' . ($product->status));
        }
    }

    public static function priceRub(models\Product $product) : string {
        return $product->price . ' руб.';
    }
}