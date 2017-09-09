<?php

namespace console\controllers;

use backend\models\User;
use common\rbac\Rbac;
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

        //создаем разрешения
        foreach (Rbac::PERMISSIONS as $permission) {
            $auth->add($auth->createPermission($permission));
        }

        // Создадим роли
        $roleAdmin   = $auth->createRole(Rbac::ROLE_ADMIN);
        $roleManager = $auth->createRole(Rbac::ROLE_MANAGER);

        $auth->add($roleAdmin);
        $auth->add($roleManager);
        $auth->addChild($roleAdmin, $roleManager);

        //назначем ролям разрешения
        $auth->addChild($roleManager, $auth->getPermission(Rbac::PERM_SITE_INDEX));
        $auth->addChild($roleManager, $auth->getPermission(Rbac::PERM_SITE_LOGOUT));
        $auth->addChild($roleManager, $auth->getPermission(Rbac::PERM_USER_LIST));
        $auth->addChild($roleManager, $auth->getPermission(Rbac::PERM_REQUEST_LIST));
        $auth->addChild($roleManager, $auth->getPermission(Rbac::PERM_REQUEST_STATE_CHANGE));

        $auth->addChild($roleAdmin, $auth->getPermission(Rbac::PERM_USER_EDIT));
        $auth->addChild($roleAdmin, $auth->getPermission(Rbac::PERM_USER_VALIDATE));
        $auth->addChild($roleAdmin, $auth->getPermission(Rbac::PERM_USER_SAVE));
        $auth->addChild($roleAdmin, $auth->getPermission(Rbac::PERM_USER_DELETE));


        /**
         * добавляем в базу фиксированный набор пользователей. По заданию, не предусмотрено добавление пользователей
         * Пароль одинаковый, для простоты провекри работы
         */

        //админы
        $auth->assign($roleAdmin, $this->_createUser('admin', 'qwerty')->getId());
        $auth->assign($roleAdmin, $this->_createUser('chief', 'qwerty')->getId());

        //менеджеры
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