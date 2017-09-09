<?php
/**
 * редактирование пользователя
 * @var \backend\models\UserForm $userForm
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'Редактирование пользователя'
?>

<div>
    <h1 class="h2"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'user-edit-form',
                'layout' => 'horizontal',
                'action' => \yii\helpers\Url::toRoute('user/save'),
                'validationUrl' => \yii\helpers\Url::toRoute('user/validate'),
                'enableAjaxValidation' => true,
                'enableClientValidation' => true
            ]); ?>

            <?= $form->field($userForm, 'user_id')->hiddenInput()->label(false) ?>
            <?= $form->field($userForm, 'username')->textInput(['autofocus' => true])->label('Пользователь') ?>
            <?= $form->field($userForm, 'email')->textInput(['autofocus' => true])->label('Почта') ?>
            <?= $form->field($userForm, 'role')->dropDownList(\frontend\views\helpers\User::getRoleDropDownItems())->label('Тип') ?>
            <?= $form->field($userForm, 'status')->dropDownList(\frontend\views\helpers\User::getStatusDropDownItems())->label('Статус') ?>
            <?= $form->field($userForm, 'created_at')->label('Создан')->staticControl() ?>
            <?= $form->field($userForm, 'updated_at')->label('Изменен')->staticControl() ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'save-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>