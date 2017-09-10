<?php

namespace frontend\views\helpers;

class Product
{
    public static function dropDownListItems() : array {
        $products = \common\models\Product::findActive();

        $result = [];
        foreach ($products as $product) {
            $result[$product->id] = $product->name;
        }

        return $result;
    }
}