<?php

namespace frontend\models;

use common\models\Product;
use yii\db\ActiveRecord;
use yii\validators\RangeValidator;
use yii\validators\RequiredValidator;
use yii\validators\SafeValidator;
use yii\validators\StringValidator;

/**
 * Заявка на товар
 *
 * @property int    product_id
 * @property string client_name
 * @property string client_phone
 * @property string client_comment
 * @property string status
 * @property int    create_timestamp
 */
class ProductRequest extends ActiveRecord
{
    const STATUS_NEW      = 'new';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';
    const STATUS_DISCARD  = 'discarded';

    const COL_PRODUCT_ID     = 'product_id';
    const COL_CLIENT_NAME    = 'client_name';
    const COL_CLIENT_PHONE   = 'client_phone';
    const COL_CLIENT_COMMENT = 'client_comment';
    const COL_STATUS         = 'status';
    const COL_CREATE_TS      = 'create_timestamp';

    const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_ACCEPTED,
        self::STATUS_REJECTED,
        self::STATUS_DISCARD,
    ];

    /** @var Product */
    protected $product = null;

    public function rules() {
        return [
            [[self::COL_PRODUCT_ID, self::COL_CLIENT_NAME, self::COL_CLIENT_PHONE], RequiredValidator::class],
            [self::COL_CLIENT_PHONE, StringValidator::class, ['length' => 64]],
            [self::COL_CLIENT_NAME, StringValidator::class, ['length' => 256]],
            [self::COL_CLIENT_COMMENT, StringValidator::class, ['length' => 1000]],
            [self::COL_CLIENT_COMMENT, RangeValidator::class, ['range' => self::STATUSES]],
        ];
    }

    public function scenarios() {
        return parent::scenarios(); // TODO: Change the autogenerated stub
    }

    public function getProduct() {
        return Product::findById($this->product_id);
    }



}