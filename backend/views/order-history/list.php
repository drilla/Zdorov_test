<?php
/**
 * история изменений заявок
 *
 * @var \backend\models\Order\HistoryRecord[] $records
 * @var  \yii\web\View                        $this
 */
$this->title = 'История изменений заявок'
?>
<div class="row">
    <div class="col-lg-10">
        <h1 class="h2"><?= $this->title ?></h1>
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
