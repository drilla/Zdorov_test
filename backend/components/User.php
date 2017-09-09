<?php
namespace backend\components;

/**
 * Расширение для стандартного компонетна
 *
 * @method \backend\models\User | null getIdentity()
 */
class User extends \yii\web\User
{
    const ROLE_ADMIN   = 'admin';
    const ROLE_MANAGER = 'manager';

    const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_MANAGER,
    ];

    public function is(string $roleName) :bool {
        if ($this->getIdentity()) {
           return $this->getIdentity()->is($roleName);
        }

        return false;
    }

    public function isAdmin() : bool {return $this->is(self::ROLE_ADMIN);}
    public function isManager() : bool {return $this->is(self::ROLE_MANAGER);}
    public function isGuest() : bool {return $this->getIsGuest();}

    public function can($permissionName, $params = [], $allowCaching = true) {

        if (in_array($permissionName, self::ROLES)) {
            return $this->is($permissionName);
        }

        return parent::can($permissionName, $params, $allowCaching);
    }

}