<?php
/**
 * панель навигации
 */

use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;

NavBar::begin([
    'brandLabel' => 'Мини-CRM система',
    'brandUrl'   => Yii::$app->homeUrl,
    'options'    => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

/** @var \backend\components\User $user */
$user = Yii::$app->user;
$menuItems = [];

$menuItems[] = ['label' => 'На главную', 'url' => [Url::home()]];
$menuItems[] = ['label' => 'Подать заявку', 'url' => '//' . Url::to(Yii::$app->params['frontendHost'])];

if ($user->isGuest()) {
    $menuItems[] = ['label' => 'Вход', 'url' => Url::toRoute('login')];
}

if ($user->isManager() || $user->isAdmin()) {
    $menuItems[] = ['label' => 'Заявки', 'url' => Url::toRoute('order/list')];
    $menuItems[] = ['label' => 'Пользователи', 'url' => Url::toRoute('user/list')];
    $menuItems[] = ['label' => 'Товары', 'url' => Url::toRoute('product/list')];

}

if (!$user->isGuest()) {
    /** @var \backend\models\User $identity */
    $identity = $user->getIdentity();
    $role =  \backend\views\helpers\User::getRoleName($identity->getRole());
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
