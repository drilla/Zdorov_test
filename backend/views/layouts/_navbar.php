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
$menuItems = [
    ['label' => 'На главную', 'url' => [Url::home()]],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Вход', 'url' => [Url::toRoute('login')]];
} else {
    $menuItems[] = ['label' => 'Пользователи', 'url' => [Url::toRoute('user/list')]];
    $menuItems[] = '<li>'
        . Html::beginForm([Url::toRoute('site/logout')], 'post')
        . Html::submitButton(
            'Выйти (' . Yii::$app->user->identity->username . ')',
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
