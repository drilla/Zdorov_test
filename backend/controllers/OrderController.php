<?php

namespace backend\controllers;

use common\models\Order;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Заявки на товар
 */
class OrderController extends Controller
{
    const KEY_RESULT     = 'result';
    const RESULT_SUCCESS = 1;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['actions' => ['list', 'state-change'], 'allow' => true, 'roles' => ['@']],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'stateChange' => ['post'],
                    'list'        => ['get'],
                ],
            ],
        ];
    }

    public function actionList() {
        return $this->render('list',  ['orders' => Order::find()->all()]);
    }

    /**
     * Вернет результат в форме данных JSON
     *  self::KEY_RESULT => SUCCESS/ERROR
     *  self::KEY_MESSAGE => 'hello!' - опционально
     * todo
     */
    public function actionStateChange() {

        $orderId = \Yii::$app->request->post('orderId', null);
        $newState = \Yii::$app->request->post('newState', null);
        /** @var Order | null $order */
        $order = Order::findOne(['id' => $orderId]);
        if (!$order) {
            throw new \Exception('заказ не найден!');
        }

        if ($order->status === $newState) {
            /* Никак не реагируем */
            return $this->asJson([]);
        }

        $order->status = $newState;

        if (!$order->save(true, [Order::COL_STATUS])) {
            throw new \Exception($order->getErrors());
        }

        return $this->asJson([self::KEY_RESULT => self::RESULT_SUCCESS]);
    }
}