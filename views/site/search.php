<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = "Пошук квитків на " . date("d.m.Y", strtotime($date)). ", напрямок " . $fromStation['name'] . "-" . $toStation['name'];
?>
<h1>Напрямок <?= $fromStation['name'] . " - " . $toStation['name']; ?></h1>
<span class="pageData" data-date="<?= $date; ?>" data-from-station="<?= $fromStation['id']; ?>" data-to-station="<?= $toStation['id']; ?>"></span>
<div class="ajax_container"></div>
<?php if(count($trains) > 0): ?>
    <div class="list-group col-lg-8">
        <?php foreach($trains as $train): ?>
            <?php $freePlaces = $train['places_count'] - $ticketsCount[$train['id']]; ?>
            <a href="#" data-train-id="<?= $train['id']; ?>" class="list-group-item <?= $freePlaces > 0 ? '' : 'list-group-item list-group-item-danger'; ?> trainListBtn">
                <div class="row">
                    <div class="col-lg-8">
                        <h4 class="list-group-item-heading">Потяг №<?= $train['train_number']; ?></h4>
                        <p class="list-group-item-text">
                            <i class="glyphicon glyphicon-time"></i> Відправлення: <?= date("H:i", strtotime($schedules[$train['id']]['from'])); ?><br />
                            <i class="glyphicon glyphicon-time"></i> Прибуття: <?= date("H:i", strtotime($schedules[$train['id']]['to'])); ?><br />
                            <i class="glyphicon glyphicon-user"></i> Вільно: <?= $freePlaces; ?> місць
                        </p>
                    </div>
                    <div class="col-lg-4">
                        <div class="pull-right" style="font-size:38px;padding-top:10px;">
                            <i class="glyphicon glyphicon-money"></i> 0 грн
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-danger">
        Нажаль, по заданому напрямку нічого не знайдено. <?= Html::a("Спробуйте змінити дату пошуку!", ['/']); ?>
    </div>
<?php endif; ?>
