<?php

namespace console\controllers;

use backend\models\User;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * достаточно выполнить один раз при инициализации проекта
     *
     * создаем необходимые роли в системе
     */
    public function actionInit() {
        $auth = \Yii::$app->authManager;

        //На всякий случай удаляем старые данные из БД...
        $auth->removeAll();

        // Создадим роли админа и редактора новостей
        $roleAdmin   = $auth->createRole(User::ROLE_ADMIN);
        $roleManager = $auth->createRole(User::ROLE_MANAGER);

        // запишем их в БД
        $auth->add($roleAdmin);
        $auth->add($roleManager);

        $initialAdmin = $this->_addAdmin();

        //прописываем ему роль
        $auth->assign($roleAdmin, $initialAdmin->getId());
    }

    /**
     * добавляем одного простейшего админа в базу.
     * admin : admin
     */
    public function _addAdmin() : User{
        //
        $admin           = new User();
        $admin->username = 'admin';
        $admin->setPassword('admin');
        $admin->generateAuthKey();

        $admin->save();

        return $admin;
    }
}