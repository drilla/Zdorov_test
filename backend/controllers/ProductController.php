<?php
namespace backend\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ProductController extends Controller
{

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['actions' => ['list', 'edit', 'state-change'], 'allow' => true, 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'state-change' => ['post'],
                ],
            ],
        ];
    }

    public function actionList() {

    }

    public function actionEdit(int $id) {

    }

    public function actionStateChange(string $state) {

    }

}