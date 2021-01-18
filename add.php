<?php
include('header.php');
if (isset($_GET['search'])) {
    include('main.php');
} else {
?>
<h6 class="text-center">Добавление контакта</h6>
<form style="margin: 1%" method="post" action="logic.php">
    <div class="row" style="margin-top: 1%">
        <div class="col">
            <input type="text" class="form-control" placeholder="First name" aria-label="First name" name="first_name" required>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" name="last_name">
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Email" aria-label="Email" name="email">
        </div>
    </div>
    <div class="row" style="margin-top: 1%">
        <div class="col-md-6">
            <span style="margin-left: 2%; color: #198754">Дата рождения:</span>
            <input id="datepicker" type="text" class="form-control" placeholder="Date of Birth" aria-label="Date of Birth" name="date" required>
        </div>
        <div class="col-md-6">
            <span style="margin-left: 2%; color: #198754">Номер телефона:</span>
            <input type="text" class="form-control" placeholder="Format: +380123456789 or 0123456789" aria-label="Format: +380123456789 or 0123456789" name="phone" required>
        </div>
    </div>
    <div class="row" style="margin-top: 2%">
        <input type="hidden" name="add">
        <div class="text-center">
            <button type="submit" class="btn btn-outline-primary">Сохранить</button>
        </div>
    </div>
</form>
<?php
}
