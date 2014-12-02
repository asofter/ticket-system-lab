<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\PrepareForm;
?>

<div class="row">
    <div class="col-lg-8">
        <div class="well well-sm">
            <?php $form = ActiveForm::begin(['id' => 'form-prepare', 'method' => 'post', 'action' => ['/buy']]); ?>
            <?= Html::activeHiddenInput($prepareForm, 'from_station'); ?>
            <?= Html::activeHiddenInput($prepareForm, 'to_station'); ?>
            <?= Html::activeHiddenInput($prepareForm, 'date'); ?>
            <?= Html::activeHiddenInput($prepareForm, 'train_id'); ?>
            <?= $form->field($prepareForm, 'email', ['template' => "{input}\n{error}"])->textInput(['placeholder' => "E-mail"]); ?>
            <?= $form->field($prepareForm, 'first_name', ['template' => "{input}\n{error}"])->textInput(['placeholder' => "Ваше ім'я"]); ?>
            <?= $form->field($prepareForm, 'last_name', ['template' => "{input}\n{error}"])->textInput(['placeholder' => "Ваше прізвище"]); ?>
            <?= $form->field($prepareForm, 'pay_method', ['template' => "{input}\n{error}"])->dropDownList(array_merge(['' => 'Оберіть метод оплати'], PrepareForm::$payMethods)); ?>
            <?= Html::submitButton('Купити', ['class' => 'btn btn-primary btn-lg btn-block text-center']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>