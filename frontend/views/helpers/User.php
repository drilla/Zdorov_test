<?php
namespace frontend\views\helpers;

use backend\models;
use yii\rbac\Role as UserRole;

class User
{
    public static function getRoleDropDownItems() : array {
       $roles = \Yii::$app->getAuthManager()->getRoles();

        $result = [];
        foreach ($roles as $role) {
            $result[$role->name] = self::getName($role);
        }

        return $result;
    }

    public static function getStatusDropDownItems() : array {
        return [
            models\User::STATUS_ACTIVE     => 'активен',
            models\User::STATUS_NOT_ACTIVE => 'заблокирован'
        ];
    }

    private static function getName(UserRole $role) : string {
        switch ($role->name) {
            case models\User::ROLE_ADMIN : return 'Администратор';
            case models\User::ROLE_MANAGER : return 'Менеджер';
            default : return 'неизвестно';
        }
    }

}