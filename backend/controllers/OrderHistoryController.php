<?php

namespace backend\controllers;

use backend\models\Order\HistoryRecord;
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
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'list' => ['get'],
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

        return $this->render('list', ['records' => $historyRecords]);
    }
}