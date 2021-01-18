<?php
include('header.php');
if (isset($_GET['search'])) {
    include('main.php');
}
?>

<?php if ($_GET['id']) : ?>
<?php foreach ($user_edit as $user) : ?>
    <div class="row text-center" style="margin-top: 2%">
        <span style="color: #198754">Имя:</span>
        <h5><?=$user['first_name']?></h5>
        <hr>
    </div>
    <div class="row text-center">
        <span style="color: #198754">Фамилия:</span>
        <h5><?=$user['last_name'] ? $user['last_name'] : '-'?></h5>
        <hr>
    </div>
    <div class="row text-center">
        <span style="color: #198754">Email:</span>
        <h5><?=$user['email'] ? $user['email'] : '-'?></h5>
        <hr>
    </div>
    <div class="row text-center">
        <span style="color: #198754">Дата рождения:</span>
        <?php
        $user_date = DateTime::createFromFormat('Y-m-d', $user['date'])->format('m/d/Y');
        ?>
        <h5><?=$user_date?></h5>
        <hr>
    </div>
    <?php
    $phones = explode(' ', $user['phones']);
    ?>
    <?php foreach ($phones as $val) : ?>
        <div class="row text-center">
            <h5><?=$val?></h5>
            <hr>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>
<?php endif; ?>
