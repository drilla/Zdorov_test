<?php
namespace frontend\models;
use yii\base\Model;

/**
 * Форма заявки на товар
 */
class ProductRequestForm extends Model
{
    public $product_id;
    public $client_name;
    public $client_phone;
    public $client_comment;

    public function rules() {
        return [
            [[ProductRequest::COL_PRODUCT_ID, ProductRequest::COL_CLIENT_NAME, ProductRequest::COL_CLIENT_PHONE], 'required'],
            [ProductRequest::COL_CLIENT_PHONE, 'string', 'max' => 64],
            [ProductRequest::COL_CLIENT_NAME, 'string', 'max' => 256],
            [ProductRequest::COL_CLIENT_COMMENT, 'string', 'max' => 1000],
            [ProductRequest::COL_STATUS, 'in', 'range' => ProductRequest::STATUSES, 'on' => ProductRequest::SCENARIO_DEFAULT],
            [ProductRequest::COL_STATUS, 'unsafe', 'on' => ProductRequest::SCENARIO_CREATE],
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
}