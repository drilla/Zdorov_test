<?php

namespace common\models;

use yii\db\ActiveRecord;

/** Товар */
class Product extends ActiveRecord
{
    /** @return self | null*/
    public static function findById(int $id) : Product
    {
        return self::find()->where(['id' => $id])->one();
    }
}