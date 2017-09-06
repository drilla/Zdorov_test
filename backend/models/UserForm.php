<?php
namespace backend\models;

use yii\base\Model;

class UserForm extends Model
{
    public $user_id;
    public $username;
    public $status;
    public $role;
    public $created_at;
    public $updated_at;

    public static function create(User $user) : self {
        $form             = new self();
        $form->user_id    = $user->getId();
        $form->username   = $user->username;
        $form->status     = $user->status;
        $form->role       = $user->getRole()->name;
        $form->created_at = $user->created_at;
        $form->updated_at = $user->updated_at;

        return $form;
    }

    public function rules() {
        return [
            [['user_id', 'username', 'role', 'status'], 'required'],
            ['user_id', 'integer'],
            ['status', 'in', 'range' => User::STATUSES],
            ['role', 'in', 'range' => User::ROLES],
        ];
    }
}