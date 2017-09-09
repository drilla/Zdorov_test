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

        //Сбрасываем RBAC
        $auth->removeAll();

        //Удаляем всех пользователей
        User::deleteAll();

        // Создадим роли
        $roleAdmin   = $auth->createRole(\backend\components\User::ROLE_ADMIN);
        $roleManager = $auth->createRole(\backend\components\User::ROLE_MANAGER);

        $auth->add($roleAdmin);
        $auth->add($roleManager);

        /**
         * добавляем в базу фиксированный набор пользователей. По заданию, не предусмотрено добавление пользователей
         * Пароль одинаковый, для простоты провекри работы - qwerty
         */

        //админы
        $auth->assign($roleAdmin, $this->_createUser('admin', 'qwerty')->getId());
        $auth->assign($roleAdmin, $this->_createUser('chief', 'qwerty')->getId());

        //менеджеры
        $auth->assign($roleManager, $this->_createUser('employee')->getId());
        $auth->assign($roleManager, $this->_createUser('manager')->getId());
        $auth->assign($roleManager, $this->_createUser('redactor')->getId());
        $auth->assign($roleManager, $this->_createUser('handyman')->getId());
    }

    protected function _createUser($name, $password = 'qwerty', $email = null) : User {

        $email = $email ?? $name . '@example.com';
        $user           = new User();
        $user->username = $name;
        $user->email    = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->save();

        return $user;
    }
}