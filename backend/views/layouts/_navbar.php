<?php
/**
 * панель навигации
 */

use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use \common\rbac\Rbac;

NavBar::begin([
    'brandLabel' => 'Мини-CRM система',
    'brandUrl'   => Yii::$app->homeUrl,
    'options'    => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

$user = Yii::$app->user;
$menuItems = [];

if ($user->can(Rbac::PERM_SITE_INDEX)) {
    $menuItems[] = ['label' => 'На главную', 'url' => [Url::home()]];
}


$menuItems[] = ['label' => 'Подать заявку', 'url' => '//' . Url::to(Yii::$app->params['frontendHost'])];

if ($user->getIsGuest()) {
    $menuItems[] = ['label' => 'Вход', 'url' => Url::toRoute('login')];
}
if ($user->can(Rbac::PERM_ORDER_LIST)) {
    $menuItems[] = ['label' => 'Заявки', 'url' => Url::toRoute('order/list')];
}

if ($user->can(Rbac::PERM_USER_LIST)) {
    $menuItems[] = ['label' => 'Пользователи', 'url' => Url::toRoute('user/list')];
}

if ($user->can(Rbac::PERM_SITE_LOGOUT)) {
    /** @var \backend\models\User $identity */
    $identity = $user->getIdentity();
    $role =  \frontend\views\helpers\User::getRoleName($identity->getRole());
    $menuItems[] = '<li>'
        . Html::beginForm([Url::toRoute('site/logout')], 'post')
        . Html::submitButton(
            'Выйти (' .$role .':' . $identity->username . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
?>
