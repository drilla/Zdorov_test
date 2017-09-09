<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $usernameOrEmail;
    public $password;
    public $rememberMe = true;

    private $_user;

    public function rules() {
        return [
            // username and password are both required
            [['usernameOrEmail', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function login() : bool {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username or email]]
     *
     * @return User|null
     */
    protected function getUser() {
        if (!$this->_user) {
            $this->_user = User::findByUsername($this->usernameOrEmail);
        }

        if (!$this->_user) {
            $this->_user = User::findByEmail($this->usernameOrEmail);
        }

        return $this->_user;
    }
}
