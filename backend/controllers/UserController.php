<?php

namespace backend\controllers;

use backend\models\User;
use backend\models\UserForm;
use common\rbac\Rbac;
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserController extends Controller
{
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['actions' => ['list'], 'allow' => true, 'roles' => ['@']],
                    ['actions' => [
                        'list',
                        'edit',
                        'save',
                        'validate',
                        'delete',
                    ],
                     'allow' => true,
                     'roles' => [\backend\components\User::ROLE_ADMIN]],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list'     => ['get'],
                    'edit'     => ['get'],
                    'delete'   => ['post'],
                    'save'     => ['post'],
                    'validate' => ['post'],
                ],
            ],
        ];
    }

    public function actionList() {
        $users = User::find()->all();

        return $this->render('list', ['users' => $users]);
    }

    public function actionEdit(int $id) {
        $user = User::findIdentity($id);

        if (!$user) throw new NotFoundHttpException('Пользователь не найден');

        $form = \backend\models\UserForm::create($user);

        return $this->render('edit', ['userForm' => $form]);
    }

    public function actionValidate() {
        $request = \Yii::$app->request;
        /**
         * провалидируем форму, если она пришла аяксом и отправим ответ
         */
        if (!$request->getIsAjax()) throw new BadRequestHttpException();

        $userForm = new UserForm();
        $userForm->load($request->post());

        \Yii::$app->response->format = Response::FORMAT_JSON;

        return ActiveForm::validate($userForm);
    }

    public function actionSave() {
        $request = \Yii::$app->request;

        $userForm = new UserForm();
        $userForm->load($request->post());

        /**
         * Форма должна быть проавлидирована, если это не так значит возможно данные формы изменились.
         */
        if (!$userForm->validate()) {
            throw new BadRequestHttpException('Переданы неправильные данные формы.');
        }

        $user = User::findIdentity($userForm->user_id);

        if (!$user) throw new NotFoundHttpException('Пользователь не найден');

        /**
         * сохраняем только если данные изменились
         */
        if (
            $user->username !== $userForm->username ||
            $user->status !== $userForm->status ||
            $user->email !== $userForm->email

        ) {
            $user->username = $userForm->username;
            $user->status   = $userForm->status;
            $user->email    = $userForm->email;
            $user->save(true);
        }

        /**
         * если были изменения в роли - применяем их
         */
        $currentRole = $user->getRole();
        if ($userForm->role && $currentRole->name !== $userForm->role) {
            $authManager = \Yii::$app->getAuthManager();

            //удаляем все роли у пользователя
            $authManager->revokeAll($user->getId());

            //добавляем новую роль
            $role = $authManager->getRole($userForm->role);
            $authManager->assign($role, $user->getId());
        }

        return $this->redirect('list');
    }

    public function actionDelete(int $id) {
        if (!\Yii::$app->request->isAjax) throw new BadRequestHttpException();

        $user = User::findIdentity($id);

        if (!$user) throw new NotFoundHttpException('Пользователь не найден');

       $user->delete();

        return $this->asJson(['redirect' => Url::toRoute('user/list')]);
    }
}