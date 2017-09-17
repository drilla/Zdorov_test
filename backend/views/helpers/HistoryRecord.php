<?php

namespace backend\views\helpers;

use backend\models;


class HistoryRecord
{
    /** @var models\Order\HistoryRecord  */
    private $_record;

    public function __construct(models\Order\HistoryRecord $record) {
        $this->_record = $record;
    }

    public function product() : string {
        return $this->_record->getOrder()->getProduct()->name;
    }

    /**
     * кто вносил изменения
     * Либо один из менеджеров, либо клиент создал заявку
     */
    public function whoDidIt() : string {
        $user = $this->_record->getUser();

        return $user ? $user->username : 'Клиент: '. $this->_record->getOrder()->client_name;
    }

    public function createDate() : string {
        return \Yii::$app->getFormatter()->asDatetime($this->_record->created_at, 'short');
    }

    public function oldValues() : string {
        return $this->_record->old_values;
    }

    public function newValues() : string {
        return $this->_record->new_values;
    }
}