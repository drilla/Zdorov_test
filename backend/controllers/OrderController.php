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
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['actions' => ['list', 'stateChange'], 'allow' => true, 'roles' => ['@']],
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

    public function actionStateChange() {}
}