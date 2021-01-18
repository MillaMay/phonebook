<?php
include('header.php');
if (isset($_GET['search'])) {
    include('main.php');
}
?>

<?php if ($_GET['id']) : ?>
<h6 class="text-center">Редактирование контакта</h6>
<?php foreach ($user_edit as $user) : ?>
<form style="margin: 1%" method="post" action="logic.php">
    <div class="row" style="margin-top: 1%">
        <div class="col">
            <input type="text" class="form-control" placeholder="First name" aria-label="First name" name="first_name" value="<?=$user['first_name']?>" required>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" name="last_name" value="<?=$user['last_name']?>">
        </div>
        <div class="col">
            <input type="email" class="form-control" placeholder="Email" aria-label="Email" name="email" value="<?=$user['email']?>">
        </div>
    </div>
    <?php
    $phones = explode(' ', $user['phones']);
    ?>
    <div class="row" style="margin-top: 1%">
        <?php if (count($phones) == 1) : ?>
            <div class="col">
                <input type="text" class="form-control" placeholder="Phone" aria-label="Phone" name="phone" value="<?=$user['phones']?>" required>
            </div>
        <?php else : ?>
        <?php foreach ($phones as $val) : ?>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Phone" aria-label="Phone" name="phones[<?=$val?>]" value="<?=$val?>">
                <a class="btn btn-outline-danger" type="button" id="button-addon2" href="/?remove=true&id=<?=$_GET['id']?>&phone=<?=$val?>">Удалить</a>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
        <?php
        $user_date = DateTime::createFromFormat('Y-m-d', $user['date'])->format('m/d/Y');
        ?>
    <div class="row" style="margin-top: 1%">
        <div class="col-md-4">
            <span style="margin-left: 3%; color: #198754">Дата рождения:</span>
            <input id="datepicker" type="text" class="form-control" placeholder="Date of Birth" aria-label="Date of Birth" name="date" value="<?=$user_date?>" required>
        </div>
    </div>
    <div class="row" style="margin-top: 1%">
        <input type="hidden" name="edit" value="<?=$_GET['id']?>">
        <div class="text-center">
            <button type="submit" class="btn btn-outline-primary">Сохранить изменения</button>
        </div>
    </div>
</form>
<form style="margin: 3% 1%" method="post" action="logic.php">
    <div class="row" style="margin-top: 1%">
        <div class="col-md-4 input-group">
            <input type="text" class="form-control" placeholder="Format: +380123456789 or 0123456789" aria-label="Format: +380123456789 or 0123456789" name="newphone">
            <input type="hidden" name="id" value="<?=$_GET['id']?>">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Добавить ещё телефон</button>
        </div>
    </div>
</form>
<?php endforeach; ?>
<?php endif; ?>




