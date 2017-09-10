<?php

namespace common\models;

use frontend\models\OrderForm;
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
class Order extends ActiveRecord
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

    public static function tableName() {return 'order';}

    public static function createByForm(OrderForm $form) : self {
        $order           = new Order();
        $order->scenario = self::SCENARIO_CREATE;

        $order->product_id     = $form->product_id;
        $order->client_name    = $form->client_name;
        $order->client_phone   = $form->client_phone;
        $order->client_comment = $form->client_comment;

        if (!$order->validate()) {
            throw new \DomainException(join(", \n", $order->getErrors()));
        }

        return $order;
    }

    public function rules() {
        return [
            [[Order::COL_PRODUCT_ID, Order::COL_CLIENT_NAME, Order::COL_CLIENT_PHONE], 'required'],
            [Order::COL_CLIENT_PHONE, 'string', 'max' => 64],
            [Order::COL_CLIENT_NAME, 'string', 'max' => 256],
            [Order::COL_CLIENT_COMMENT, 'string', 'max' => 1000],
            [Order::COL_STATUS, 'in', 'range' => Order::STATUSES, 'on' => Order::SCENARIO_DEFAULT],
            [Order::COL_STATUS, 'default', 'value' => Order::STATUS_NEW, 'on' => Order::SCENARIO_CREATE],
        ];
    }

    public function attributeLabels() {
        return [
            Order::COL_PRODUCT_ID     => 'Товар',
            Order::COL_CLIENT_NAME    => 'Имя',
            Order::COL_CLIENT_PHONE   => 'Телефон',
            Order::COL_CLIENT_COMMENT => 'Комметарий к заявке',
            Order::COL_STATUS         => 'Статус',
        ];
    }

    public function getProduct() : Product {
        $product = Product::findById($this->product_id);

        if (!$product) {
            //у нас не запланирована ситуация удаления продукта - по заданию
            throw new \DomainException('product not found!');
        }

        return $product;
    }
}