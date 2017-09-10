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
        <tr>
            <td><?= $order->id ?></td>
            <td><?= helpers\Order::createDate($order) ?></td>
            <td><?= $order->client_name ?></td>
            <td><?= $order->client_phone ?></td>
            <td><?= $order->getProduct()->name ?></td>
            <td><?= helpers\Order::status($order) ?></td>
            <td><?= helpers\Product::priceRub($order->getProduct()) ?></td>
            <td><?= $order->client_comment ?></td>
            <td>Изменения</td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>