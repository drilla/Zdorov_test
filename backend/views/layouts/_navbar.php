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
if ($user->getIsGuest()) {
    $menuItems[] = ['label' => 'Вход', 'url' => [Url::toRoute('login')]];
}
if ($user->can(Rbac::PERM_REQUEST_LIST)) {
    $menuItems[] = ['label' => 'Заявки', 'url' => [Url::toRoute('request/list')]];
}

if ($user->can(Rbac::PERM_USER_LIST)) {
    $menuItems[] = ['label' => 'Пользователи', 'url' => [Url::toRoute('user/list')]];
}

if ($user->can(Rbac::PERM_SITE_LOGOUT)) {
    $menuItems[] = '<li>'
        . Html::beginForm([Url::toRoute('site/logout')], 'post')
        . Html::submitButton(
            'Выйти (' . $user->identity->username . ')',
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
