<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'Система бронювання залізничних квитків';
?>
<div class="row">
    <div class="col-md-12 text-center">
        <strong id="logo">Ticket System</strong>
        <h2>Найвидший спосіб купити залізничні квитки.</h2>
    </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->

<div class="row">
    <div class="col-md-4 col-md-offset-4 well well-sm">
        <?php $form = ActiveForm::begin(['id' => 'form-search', 'method' => 'post']); ?>
        <?= Html::activeHiddenInput($searchForm, 'from_station'); ?>
        <?= Html::activeHiddenInput($searchForm, 'to_station'); ?>
        <?= \yii\jui\DatePicker::widget([
            'model' => $searchForm,
            'attribute'  => 'date',
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => [
                'class' => 'form-control',
                'placeholder' => 'Дата відправлення'
            ]
        ]);
        ?>
        <?= $form->field($searchForm, 'date', ['template' => "{error}"]); ?>
        <?php
        echo \yii\jui\AutoComplete::widget([
            'model' => $searchForm,
            'attribute'  => 'from_station_string',
            'clientOptions' => [
                'source' => Url::to(['/site/get-stations']),
                'minLength' => 1,
                'select' => new \yii\web\JsExpression("function(event, ui) { selectStation(ui.item, 1); }")
            ],
            'options' => [
                'placeholder' => 'Станція відправлення',
                'class' => 'form-control',
            ]
        ]);
        ?>
        <?= $form->field($searchForm, 'from_station', ['template' => "{error}"]); ?>
        <?php
        echo \yii\jui\AutoComplete::widget([
            'model' => $searchForm,
            'attribute'  => 'to_station_string',
            'clientOptions' => [
                'source' => Url::to(['/site/get-stations']),
                'minLength' => 1,
                'select' => new \yii\web\JsExpression("function(event, ui) { selectStation(ui.item, 2); }")
            ],
            'options' => [
                'placeholder' => 'Станція прибуття',
                'class' => 'form-control',
            ]
        ]);
        ?>
        <?= $form->field($searchForm, 'to_station', ['template' => "{error}"]); ?>
        <?= Html::submitButton('Знайти!', ['class' => 'btn btn-primary btn-lg btn-block text-center']) ?>
        <?php ActiveForm::end(); ?>
    </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->

<div class="row">
    <div class="col-md-12 text-center" id="links">
        <p>
            <a href="http://alex-yaremchuk.me/">
                <span class="glyphicon glyphicon-user"></span>
                Автор
            </a>
        </p>
    </div> <!-- #links -->
</div> <!-- /.row -->