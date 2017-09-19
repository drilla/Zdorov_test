<?php

namespace backend\controllers;

use backend\components\User;
use backend\models\Order\HistoryRecord;
use common\models\Order;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class OrderHistoryController extends Controller
{
    const SHOW_RECORDS = 50;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['actions' => ['list'], 'allow' => true, 'roles' => ['@']],
                    ['actions' => ['clear'], 'allow' => true, 'roles' => [User::ROLE_ADMIN]],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'list' => ['get'],
                    'clear' => ['post'],
                ],
            ],
        ];
    }

    public function actionList(int $order_id = null) {
        if ($order_id) {
            $historyRecords = HistoryRecord::findByOrder($order_id, self::SHOW_RECORDS);
        } else {
            $historyRecords = HistoryRecord::find()->limit(self::SHOW_RECORDS)->all();
        }

        return $this->render('list', ['records' => $historyRecords, 'orderId' => $order_id]);
    }

    /**
     * @param int|null $order_id null - удалить всю историю заказов
     * @throws \Exception
     */
    public function actionClear() {
        $order_id = (int) \Yii::$app->request->getQueryParam('order_id', null);

        if ($order_id) {
            HistoryRecord::deleteAll([HistoryRecord::COL_ORDER_ID => $order_id]);
        } else {
            HistoryRecord::deleteAll();
        }
    }
}