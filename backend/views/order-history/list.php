<?php
/**
 * история изменений заявок
 *
 * @var \backend\models\Order\HistoryRecord[] $records
 * @var int                                   $orderId
 * @var  \yii\web\View                        $this
 */
use yii\helpers\Url;

$this->title = 'История изменений заявок';

$deleteUrl = Url::toRoute(['order-history/clear', 'order_id' => $orderId]);

?>
<div class="row">
    <div class="col-lg-10">
        <h1 class="h2"><?= $this->title ?></h1>
    </div>
    <div class="col-lg-2">
        <span class="btn btn-danger js-btn-delete" data-url="<?= $deleteUrl ?>">Очистить историю</span>
    </div>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Продукт</th>
            <th>Кто изменил</th>
            <th>Дата</th>
            <th>Было</th>
            <th>Стало</th>
        </tr>
    </thead>
    <tbody class="table-hover">
        <?php foreach ($records as $record) : ?>
            <?php $recordHelper = new \backend\views\helpers\HistoryRecord($record)?>
            <tr>
                <td><?= $recordHelper->product() ?></td>
                <td><?= $recordHelper->whoDidIt() ?></td>
                <td><?= $recordHelper->createDate() ?></td>
                <td><?= $recordHelper->oldValues() ?></td>
                <td><?= $recordHelper->newValues() ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
