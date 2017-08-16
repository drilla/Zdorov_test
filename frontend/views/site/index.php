<?php

/* @var $this yii\web\View */

use frontend\models\ProductRequest;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

//$form = \frontend\models\ProductRequestForm::createNew();
$model = new \frontend\models\ProductRequest();
$this->title = 'Новая заявка';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <h1>
                    Новая заявка на товар
                </h1>
                <?php $form = ActiveForm::begin([
                    'id' => 'product-request-form',
                    'action' => 'create-product-request',
                ]); ?>

                <?= $form->field($model, ProductRequest::COL_PRODUCT_ID)->dropDownList([1, 2, 3], ['autofocus' => true]) ?>

                <?= $form->field($model, ProductRequest::COL_CLIENT_NAME)->textInput() ?>
                <?= $form->field($model, ProductRequest::COL_CLIENT_PHONE)->textInput() ?>
                <?= $form->field($model, ProductRequest::COL_CLIENT_COMMENT)->textarea(['rows' => 5]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
