<html>
<head>
<style>
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
        border-spacing: 0;
        border-collapse: collapse;
        border:1px solid #000000;
    }

    .table tr td {
        width:50%;
        padding:10px;
        border-right:1px solid #000000;
        border-bottom: 1px solid #000000;
    }
</style>
</head>
<body>
<h1 style="text-align:center;">Квиток №<?= $ticket['id']; ?></h1>
<br />
<h2 style="text-align: center;">Інформація про замовлення</h2>
<table class="table">
    <tr>
        <td>
            <strong>Дата</strong>
        </td>
        <td>
            <span class="label label-primary"><?= date("d.m.Y", strtotime($ticket['date'])); ?></span>
        </td>
    </tr>
    <tr>
        <td>
            <strong>Станція відправлення</strong>
        </td>
        <td>
            <span class="label label-primary"><?= $ticket->fromStation['name']; ?></span>
        </td>
    </tr>
    <tr>
        <td>
            <strong>Станція прибуття</strong>
        </td>
        <td>
            <span class="label label-primary"><?= $ticket->toStation['name']; ?></span>
        </td>
    </tr>
    <tr>
        <td>
            <strong>Потяг</strong>
        </td>
        <td>
            <span class="label label-primary">№ <?= $ticket->train['train_number']; ?></span>
        </td>
    </tr>
</table>
<br />
<h2 style="text-align: center;">Інформація про замовника</h2>
<table class="table">
    <tr>
        <td>
            <strong>Ім'я</strong>
        </td>
        <td>
            <span class="label label-primary"><?= $ticket->user['first_name']; ?></span>
        </td>
    </tr>
    <tr>
        <td>
            <strong>Прізвище</strong>
        </td>
        <td>
            <span class="label label-primary"><?= $ticket->user['last_name']; ?></span>
        </td>
    </tr>
    <tr>
        <td>
            <strong>E-mail</strong>
        </td>
        <td>
            <span class="label label-primary"><?= $ticket->user['email']; ?></span>
        </td>
    </tr>
</table>

<div style="text-align:right;">
    <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=<?= urlencode("http://tickets.dev/site/get-ticket/?id=" . $ticket['id']); ?>&choe=UTF-8" title="Link to Ticket #<?= $ticket['id']; ?> page" />
</div>

</body>
</html>
