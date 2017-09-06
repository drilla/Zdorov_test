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
            $result[$role->name] = self::getRoleName($role);
        }

        return $result;
    }

    public static function getStatusDropDownItems() : array {
        return [
            models\User::STATUS_ACTIVE     =>  self::status(models\User::STATUS_ACTIVE),
            models\User::STATUS_NOT_ACTIVE =>  self::status(models\User::STATUS_NOT_ACTIVE),
        ];
    }

    public static function getRoleName(UserRole $role) : string {
        switch ($role->name) {
            case models\User::ROLE_ADMIN : return 'Администратор';
            case models\User::ROLE_MANAGER : return 'Менеджер';
            default : return 'неизвестно';
        }
    }

    /**
     * @param string $status USER::STATUSES
     * @return string человекопонятный статус
     */
    public static function status(string $status) : string {
        switch ($status) {
            case models\User::STATUS_ACTIVE: return 'активен';
            case models\User::STATUS_NOT_ACTIVE: return 'заблокирован';
            default : return 'неизвестно';
        }
    }
}