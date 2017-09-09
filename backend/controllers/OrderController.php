<?php

namespace backend\controllers;

use common\rbac\Rbac;
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
                    ['actions' => ['list'], 'allow' => true, 'roles' => [Rbac::PERM_ORDER_LIST]],
                    ['actions' => ['stateChange'], 'allow' => true, 'roles' => [Rbac::PERM_ORDER_STATE_CHANGE]],
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

    public function actionList() {}

    public function actionStateChange() {}
}