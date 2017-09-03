<?php

namespace backend\controllers;

use backend\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
        public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['list'],
                        'allow' => true,
                        'roles' => ['@'],//только авторизованные
                    ],
                    [
                        'actions' => ['edit', 'save', 'add', 'delete'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'edit'   => ['get'],
                    'delete' => ['post'],
                    'save'   => ['post'],
                    'add'    => ['post'],
                ],
            ],
        ];
    }

    public function actionList() {
        $users = User::find()->limit(1000)->all();

        return $this->render('list', ['users' => $users]);
    }

    public function actionEdit(int $id) {
        $user = User::findIdentity($id);

        if (!$user) throw new NotFoundHttpException('Пользователь не найден');

        return $this->render('edit', ['user' => $user]);
    }

    public function actionDelete(int $id) {

        if (!\Yii::$app->request->isAjax) throw new BadRequestHttpException();

        $user = User::findIdentity($id);

        if (!$user) throw new NotFoundHttpException('Пользователь не найден');

        return $this->asJson(['redirect' => Url::toRoute('user/list')]);
    }
}