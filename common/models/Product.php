<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Товар
 *
 * @property string name
 * @property float  price
 * @property int    status (self::STATUS_*)
 */
class Product extends ActiveRecord
{
    const COL_NAME   = 'name';
    const COL_PRICE  = 'price';
    const COL_STATUS = 'status';

    const STATUS_ACTIVE     = 'active';
    const STATUS_NOT_ACTIVE = 'not_active';

    public function rules() {
        return [
            [[self::COL_NAME, self::COL_PRICE, self::COL_STATUS], 'required'],
            [self::COL_NAME, 'string', 'max' => 256],
            [self::COL_PRICE, 'double', 'min' => 0],
            [self::COL_STATUS, 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_NOT_ACTIVE]],
        ];
    }

    public static function tableName() { return 'product'; }

    /** @return self | null */
    public static function findById(int $id) {
        return self::find()->where(['id' => $id])->one();
    }
}