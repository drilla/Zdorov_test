<?php

use backend\views\helpers;

/**
 * @var \common\models\Order[]  $orders
 * @var $this \yii\web\View
 */

$this->title = 'Заявки'

?>
<div class="row">
    <div class="col-lg-10">
        <h1 class="h2"><?= $this->title ?></h1>
    </div>
    <div class="col-lg-2">
        <a class="btn btn-info" href="<?= \yii\helpers\Url::toRoute('order/export')?>">Экспорт</a>
    </div>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Номер</th>
            <th>Создана</th>
            <th>Клиент</th>
            <th>Телефон клиента</th>
            <th>Товар</th>
            <th>Статус</th>
            <th>Цена</th>
            <th>Комментарий</th>
            <th>Изменения</th>
        </tr>
    </thead>
    <tbody class="table-hover">
    <?php foreach ($orders as $order) : ?>
        <tr
            data-url="<?= \yii\helpers\Url::toRoute('order/state-change')?>"
            data-order-id="<?= $order->id ?>">
            <td><?= $order->id ?></td>
            <td><?= helpers\Order::createDate($order) ?></td>
            <td><?= $order->client_name ?></td>
            <td><?= $order->client_phone ?></td>
            <td><?= $order->getProduct()->name ?></td>
            <td><?= \yii\bootstrap\Html::dropDownList(
                    'state',
                    $order->status,
                    helpers\Order::statusListItems(),
                    ['class' => 'js-active-dropdown']) ?>
            </td>
            <td><?= helpers\Product::priceRub($order->getProduct()) ?></td>
            <td><?= $order->client_comment ?></td>
            <td>
                <a class="" href="<?= \yii\helpers\Url::toRoute(['order-history/list', 'order_id' => $order->id]) ?>">Изменения</a>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>