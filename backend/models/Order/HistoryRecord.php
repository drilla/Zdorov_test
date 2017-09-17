<?php

namespace backend\models\Order;

use backend;
use common\models\Order;
use common\models\Product;
use yii\db\ActiveRecord;

/**
 * запись в истории изнменения order
 * одна запись для одного изменения
 *
 * в данных по пользователю и продукту прописаны также имена/названия,
 * чтобы не терять историю в случае удаления сущностей
 *
 * @property int    $id
 * @property int    $order_id
 * @property int    $user_id
 * @property int    $created_at
 * @property string $old_values
 * @property string $new_values
 */
class HistoryRecord extends ActiveRecord
{
    const COL_USER_ID    = 'user_id';
    const COL_ORDER_ID   = 'order_id';
    const COL_OLD_VALUES = 'old_values';
    const COL_NEW_VALUES = 'new_values';
    const COL_CREATED_AT = 'created_at';

    const SCENARIO_CREATE = 'create';

    public static function tableName() {
        return 'order_history';
    }

    public function rules() {
        return [
            [
                [
                self::COL_OLD_VALUES,
                self::COL_NEW_VALUES,
                self::COL_ORDER_ID], 'required'],
            [[self::COL_OLD_VALUES, self::COL_NEW_VALUES ], 'string', 'max' => 512],
            [[self::COL_USER_ID, self::COL_ORDER_ID], 'number', 'integerOnly' => true],
        ];
    }

    /**
     * @param backend\models\User $user      кто внес изменения. null - клиент
     * @param array               $oldValues ключ - имя измененного поля, значение - СТАРОЕ значение поля
     * @param array               $newValues ключ - имя измененного поля, значение - НОВОЕ значение поля
     * @return HistoryRecord
     */
    public static function create(
        backend\models\User $user = null,
        Order $order,
        array $oldValues,
        array $newValues
    ) : self {
        $record = new self();

        $record->order_id = $order->id;
        $record->_setUser($user);
        $record->_setOldValues($oldValues);
        $record->_setNewValues($newValues);

        return $record;
    }

    /**
     * @return static[]
     */
    public static function findByOrder(int $order_id, int $limit = null) : array {
        return self::find()->where([self::COL_ORDER_ID => $order_id])->limit($limit)->all();
    }

    public function getOrder() : Order {
        return Order::findOne(['id' => $this->order_id]);
    }

    /**
     * @return backend\models\User | null
     */
    public function getUser() {
        if ($this->user_id) {
            return backend\models\User::findById($this->user_id);
        } else {
            return null;
        }
    }

    private function _setUser(backend\models\User $user = null) {
        $this->user_id = $user ? $user->getId()  : null;
    }

    private function _setNewValues(array $newValues) {
        $this->new_values = self::_attrsToString($newValues);
    }

    private function _setOldValues(array $oldValues) {
        $this->old_values = $oldValues ? self::_attrsToString($oldValues) : '(Новая заявка)';
    }

    /**
     * Вернет строковое представление для массива аттрибутов [name => value]
     */
    private static function _attrsToString(array $attrs) : string {
        $strings = [];
        foreach ($attrs as $name => $value) {
            $strings[] = $name . ':' . $value;
        }

        return join(';', $strings);
    }
}