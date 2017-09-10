<?php

use backend\views\helpers;
use yii\bootstrap\Html;

/**
 * @var \common\models\Product[]  $products
 * @var $this \yii\web\View
 */

$this->title = 'Товары'

?>
<div class="row">
    <div class="col-lg-10">
        <h1 class="h2"><?= $this->title ?></h1>
    </div>
</div>

<table class="table">
    <thead>
    <tr>
        <th>Название</th>
        <th>Цена</th>
        <th>Статус</th>
        <?php if (Yii::$app->user->isAdmin()) : ?>
            <th>Управление</th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody class="table-hover">
    <?php foreach ($products as $product) : ?>
        <tr class="<?=$product->isActive() ?: 'bg-warning'?>">
            <td><?= $product->name ?>
            </td>
            <td><?= helpers\Product::priceRub($product) ?></td>
            <td><?= helpers\Product::status($product) ?></td>
            <?php if (!Yii::$app->user->isGuest()) : ?>
                <td>
                    <?=Html::beginForm([\yii\helpers\Url::toRoute(['product/toggle-state', 'id' => $product->id])], 'post')?>
                        <?php if ($product->isActive()) : ?>
                            <button class="btn btn-warning" type="submit">Деактивировать</button>
                        <?php else :?>
                            <button class="btn btn-success" type="submit">Активировать</button>
                        <?php endif; ?>
                    <?= Html::endForm(); ?>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
