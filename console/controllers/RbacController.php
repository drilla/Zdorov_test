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

        // Создадим роли админа и редактора новостей
        $roleAdmin   = $auth->createRole(User::ROLE_ADMIN);
        $roleManager = $auth->createRole(User::ROLE_MANAGER);

        $auth->add($roleAdmin);
        $auth->add($roleManager);
        $auth->addChild($roleManager, $roleAdmin);


        /**
         * добавляем в базу фиксированный набор пользователей. По заданию, не предусмотрено добавление пользователей
         * Пароль одинаковый, для простоты провекри работы
         */

        $auth->assign($roleAdmin, $this->_createUser('admin', 'qwerty')->getId());
        $auth->assign($roleAdmin, $this->_createUser('chief', 'qwerty')->getId());
        $auth->assign($roleManager, $this->_createUser('employee', 'qwerty')->getId());
        $auth->assign($roleManager, $this->_createUser('manager', 'qwerty')->getId());
        $auth->assign($roleManager, $this->_createUser('redactor', 'qwerty')->getId());
        $auth->assign($roleManager, $this->_createUser('handyman', 'qwerty')->getId());
    }

    protected function _createUser($name, $password) : User {
        $user           = new User();
        $user->username = $name;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->save();

        return $user;
    }
}