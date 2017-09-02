<?php

namespace frontend\models;

use common\models\Product;
use yii\db\ActiveRecord;


/**
 * Заявка на товар
 *
 * @property int    product_id
 * @property string client_name
 * @property string client_phone
 * @property string client_comment
 * @property string status
 * @property int    created_at
 */
class ProductRequest extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';

    const STATUS_NEW      = 'new';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';
    const STATUS_DISCARD  = 'discarded';

    const COL_PRODUCT_ID     = 'product_id';
    const COL_CLIENT_NAME    = 'client_name';
    const COL_CLIENT_PHONE   = 'client_phone';
    const COL_CLIENT_COMMENT = 'client_comment';
    const COL_STATUS         = 'status';

    const COL_CREATED_AT = 'created_at';
    const STATUSES       = [
        self::STATUS_NEW,
        self::STATUS_ACCEPTED,
        self::STATUS_REJECTED,
        self::STATUS_DISCARD,
    ];

    /** @var Product */
    protected $product = null;

    public static function tableName() {return 'product_request';}

    public static function createNew(array $config = []) : self {
        $productRequest = new productRequest($config);
        $productRequest->scenario = self::SCENARIO_CREATE;
        $productRequest->status   = self::STATUS_NEW;

        return $productRequest;
    }

    public function rules() {
        return [
            [[ProductRequest::COL_PRODUCT_ID, ProductRequest::COL_CLIENT_NAME, ProductRequest::COL_CLIENT_PHONE], 'required'],
            [ProductRequest::COL_CLIENT_PHONE, 'string', 'max' => 64],
            [ProductRequest::COL_CLIENT_NAME, 'string', 'max' => 256],
            [ProductRequest::COL_CLIENT_COMMENT, 'string', 'max' => 1000],
            [ProductRequest::COL_STATUS, 'in', 'range' => ProductRequest::STATUSES, 'on' => ProductRequest::SCENARIO_DEFAULT],
            [ProductRequest::COL_STATUS, 'default', 'value' => ProductRequest::STATUS_NEW, 'on' => ProductRequest::SCENARIO_CREATE],
        ];
    }

    public function attributeLabels() {
        return [
            ProductRequest::COL_PRODUCT_ID => 'Товар',
            ProductRequest::COL_CLIENT_NAME => 'Имя',
            ProductRequest::COL_CLIENT_PHONE => 'Телефон',
            ProductRequest::COL_CLIENT_COMMENT => 'Комметарий к заявке',
            ProductRequest::COL_STATUS => 'Статус',
        ];
    }

    public function getProduct() {
        return Product::findById($this->product_id);
    }
}