<table class="table table-hover" style="margin-top: 1%">
    <thead>
    <tr>
        <th class="col-1">id</th>
        <th class="col-3">Телефон</th>
        <th class="col-2">Имя</th>
        <th class="col-3">Фамилия</th>
        <th class="col-3">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($users)) : ?>
    <?php foreach ($users as $user): ?>
    <tr>
        <td scope="row"><?=$user['id']?></td>
        <td style="color: #198754;">
            <a class="nav-link" style="color: #198754; padding-top: 0; padding-left: 0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Посмотреть
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php
                $phones = explode(' ', $user['phones']);
                ?>
                <?php foreach ($phones as $val): ?>
                <li><span class="dropdown-item"><?=$val?></span></li>
                <?php endforeach; ?>
            </ul>
        </td>
        <td style="color: #198754;"><?=$user['first_name']?></td>
        <td style="color: #198754;"><?=$user['last_name']?></td>
        <td><a type="button" class="btn btn-outline-warning btn-sm" href="/view.php?id=<?=$user['id']?>">Обзор</a>
            <a type="button" class="btn btn-outline-primary btn-sm" href="/edit.php?id=<?=$user['id']?>">Редактировать</a>
            <a type="button" class="btn btn-outline-danger btn-sm" href="/?delete=true&id=<?=$user['id']?>">Удалить</a>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>