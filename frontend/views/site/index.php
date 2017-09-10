<?php

/**
 * @var $this yii\web\View
 */

use frontend\models\OrderForm;
use frontend\views\helpers\Product;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$model = new OrderForm();
$this->title = 'Новая заявка';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-4">
                    <h1>
                        Новая заявка на товар
                    </h1>
            </div>
            <div class="col-lg-12">
                <hr>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'product-request-form',
                    'layout'                 => 'horizontal',
                         'fieldConfig' => [
                         'horizontalCssClasses' => [
                             'label'   => 'col-lg-3',
                             'offset'  => 'col-lg-offset-3',
                             'wrapper' => 'col-lg-6'
                         ],
                     ],
                    'action'                 => \yii\helpers\Url::toRoute('create'),
                    'enableClientValidation' => true,
                    'enableAjaxValidation'   => true,
                    'validationUrl'          => \yii\helpers\Url::toRoute('create'),
                ]); ?>

                    <?= $form->field($model, 'product_id')
                        ->dropDownList(Product::dropDownListItems(), ['autofocus' => true])->label('Продукт') ?>
                    <?= $form->field($model, 'client_name')->textInput()->label('Ваше имя') ?>
                    <?= $form->field($model, 'client_phone')->textInput()->label('Телефон') ?>
                    <?= $form->field($model, 'client_comment')->textarea(['rows' => 5])->label('Комментарий') ?>

                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-3">
                            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary pull-right']) ?>
                        </div>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
