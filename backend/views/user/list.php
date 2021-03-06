<?php
/**
 * список пользователей
 * @var \backend\models\User[] $users
 */

use yii\bootstrap\Modal;
use \yii\helpers\Url;
use \backend\views\helpers;

$this->title = 'Список пользователей'
?>
<div class="row">
    <div class="col-lg-10">
        <h1 class="h2"><?= $this->title ?></h1>
    </div>
    <div class="col-lg-2">
        <a class="btn btn-primary pull-right" href="<?=Url::toRoute('user/add')?>">
            <span class="glyphicon glyphicon-plus"></span>
            <span>Добавить</span>
        </a>
    </div>
</div>
<table class="table">
    <thead>
    <tr>
        <th>Имя</th>
        <th>Статус</th>
        <th>Роль</th>
        <th>Создан</th>
        <th>Обновлен</th>
        <?php if (Yii::$app->user->isAdmin()) : ?>
            <th>Управление</th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody class="table-hover">
    <?php foreach ($users as $user) : ?>
        <tr>
            <td><?= $user->username ?>

                <?php if ($user->email) : ?>
                    <br/>(<?= $user->email ?>)
                <?php endif;?>
            </td>
            <td><?= helpers\User::status($user->status) ?></td>
            <td><?= helpers\User::getRoleName($user->getRole()) ?></td>
            <td><?= $user->created_at ?></td>
            <td><?= $user->updated_at ?></td>
            <?php if (Yii::$app->user->isAdmin()) : ?>
                <td>

                    <a class="btn btn-success" title="Редактировать" href="<?=Url::toRoute(['user/edit', 'id' => $user->getId()]) ?>">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                    <div class="btn btn-danger js-btn-delete"
                         title="Удалить"
                         data-url="<?=Url::toRoute(['user/delete', 'id' => $user->getId()]) ?>"
                         data-message="Вы действительно хотите удалить пользователя?"
                         data-toggle="modal"
                         data-target="#modal-confirm"
                    >
                        <span class="glyphicon glyphicon-remove"></span>
                    </div>

                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?=
Modal::widget([
    'id'=>'modal-confirm',

    'size' => Modal::SIZE_SMALL,
    'footer' => '<div>
                     <div class="btn btn-danger js-confirm-btn" title="Удалить">
                        <span class="glyphicon glyphicon-ok"></span>
                     </div>
                     <div class="btn btn-info" data-dismiss="modal" title="Отмена">
                        <span class="glyphicon glyphicon-ban-circle"></span>
                     </div>
                 </div>',
]);
?>