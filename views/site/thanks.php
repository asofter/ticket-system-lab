<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\PrepareForm;
$this->title = "Дякую! Квиток успішно куплено";
?>
<h1>Дякую, що купили квиток!</h1>

<div class="row">
    <div class="col-lg-6">
        <table class="table table-striped">
            <thead>
            <tr>
                <th colspan="2">Інформація про замовлення</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    Дата
                </td>
                <td>
                    <span class="label label-primary"><?= date("d.m.Y", strtotime($ticket['date'])); ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    Станція відправлення
                </td>
                <td>
                    <span class="label label-primary"><?= $ticket->fromStation['name']; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    Станція прибуття
                </td>
                <td>
                    <span class="label label-primary"><?= $ticket->toStation['name']; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    Потяг
                </td>
                <td>
                    <span class="label label-primary">№ <?= $ticket->train['train_number']; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    Метод оплати
                </td>
                <td>
                    <span class="label label-primary"><?= PrepareForm::$payMethods[$ticket['pay_method']]; ?></span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-lg-6">

        <table class="table table-striped">
            <thead>
            <tr>
                <th colspan="2">Інформація про замовника</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    Ім'я
                </td>
                <td>
                    <span class="label label-primary"><?= $ticket->user['first_name']; ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    Прізвище
                </td>
                <td>
                    <span class="label label-primary"><?= $ticket->user['last_name']; ?></span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div>SHOW PDF TICKET HERE</div>