<?php
/**
 * создаем необходимые роли в системе
 */

namespace console\controllers;

use backend\models\User;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * достаточно выполнить один раз при инициализации проекта
     */
    public function actionInit() {
        $auth = \Yii::$app->authManager;

        //На всякий случай удаляем старые данные из БД...
        $auth->removeAll();

        // Создадим роли админа и редактора новостей
        $admin  = $auth->createRole(User::ROLE_ADMIN);
        $manager = $auth->createRole(User::ROLE_MANAGER);

        // запишем их в БД
        $auth->add($admin);
        $auth->add($manager);
    }
}