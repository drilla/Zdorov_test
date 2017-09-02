<?php
/**
 * Страница, показываемая после успешного добавления формы
 */
?>

<div class="container">
    <div class="center-block">
        <div class="h1 cen">Спасибо!</div>
        <div class="h3">Новая заявка успешно добавлена!</div>
        <a class="btn btn-success" href="<?=  \yii\helpers\Url::toRoute('/')?>">Добавить еще одну</a>
    </div>
</div>
