<?php
namespace frontend\models;
/**
 * Форма заявки на товар
 */
class ProductRequestForm extends ProductRequest
{
    public function attributeLabels() {
        return [
            self::COL_PRODUCT_ID => 'Товар',
            self::COL_CLIENT_NAME => 'Имя',
            self::COL_CLIENT_PHONE => 'Телефон',
            self::COL_CLIENT_COMMENT => 'Комметарий к заявке',
            self::COL_STATUS => 'Статус',
        ];
    }
}