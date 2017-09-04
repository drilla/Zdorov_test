<?php
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\rbac\Role;
use yii\web\IdentityInterface;

/**
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * - @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_NOT_ACTIVE = 'not_active';
    const STATUS_ACTIVE     = 'active';

    const ROLE_MANAGER = 'manager';
    const ROLE_ADMIN   = 'admin';

    const COL_USERNAME      = 'username';
    const COL_PASSWORD_HASH = 'password_hash';
    const COL_AUTH_KEY      = 'auth_key';
    const COL_STATUS        = 'status';
    const COL_CREATED_AT    = 'created_at';
    const COL_UPDATED_AT    = 'updated_at';


    public static function tableName() {return 'user';}

    public function rules() {
        return [
            [self::COL_STATUS, 'default', 'value' => self::STATUS_ACTIVE],
            [[self::COL_USERNAME, self::COL_PASSWORD_HASH], 'required'],
            [[self::COL_USERNAME, self::COL_PASSWORD_HASH], 'string', 'max' => 255],
            [self::COL_STATUS, 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_NOT_ACTIVE]],
        ];
    }

    /** @return self*/
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername(string $username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public function getId() {
        return $this->getPrimaryKey();
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function getRole() : Role {
        $roles =  Yii::$app->authManager->getRolesByUser($this->getId());
        if (count($roles) !== 1) throw new \DomainException('only one role allowed, roles = ' . (string) count($roles));
        return array_pop($roles);
    }
}
