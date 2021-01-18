<?php
include('db.php');

$pattern = "/^(\+38)?\d{10}$/";
$pattern_email = "/[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-.]+$/";
$years = 567648000; //18 лет в секундах

//Поиск:
if (!empty($_GET['search'])) {
    $search = $_GET['search'];
    $search = trim($search);
    $search = stripslashes($search);
    $search = htmlspecialchars($search);
    if (!empty($search)) {
        $search = '%' . $search . '%';
        $query = "SELECT u.*, GROUP_CONCAT(DISTINCT p.phone ORDER BY p.phone ASC SEPARATOR ' ') AS phones FROM users u LEFT JOIN phones p ON u.id=p.user_id WHERE u.first_name LIKE :search1 OR u.last_name LIKE :search2 OR p.phone LIKE :search3 GROUP BY u.id";
        $users = sql($query, array('search1' => $search, 'search2' => $search, 'search3' => $search));
    }

//Вывод всех контактов:
}else {
    $query = "SELECT u.*, GROUP_CONCAT(DISTINCT p.phone ORDER BY p.phone ASC SEPARATOR ' ') AS phones FROM users u LEFT JOIN phones p ON u.id=p.user_id GROUP BY u.id";
    $users = sql($query);
}

//Добавление:
if(isset($_POST["add"])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $date = DateTime::createFromFormat('m/d/Y', $date)->format('Y-m-d');
    $years_user = time() - strtotime($date);
    $phone = $_POST['phone'];

    if (preg_match($pattern_email, $email) || empty($email)) {
        if ($years_user > $years) {
            $query_edit = "INSERT INTO users (first_name, last_name, email, date) VALUES (:first_name, :last_name, :email, :dates)";
            $edit = sql($query_edit, array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'dates' => $date));
        }
    }
    $query_id = "SELECT id FROM users ORDER BY id DESC LIMIT 0 , 1";
    $last_id = sql($query_id);

    if (preg_match($pattern, $phone)) {
        if (iconv_strlen($phone) == 10) {
            $phone = '+38' . $phone;
        }
        $search_p = '%' . $phone . '%';
        $search_phone = "SELECT phone FROM phones WHERE phone LIKE :search_p";
        $result_search = sql($search_phone, array('search_p' => $search_p));
        if ($result_search == null) {
            foreach ($last_id as $value) {
                $query_insert = "INSERT INTO phones (user_id, phone) VALUES (:user_id, :phone)";
                $insert_phone = sql($query_insert, array('user_id' => $value['id'], 'phone' => $phone));
            }
        }
    }
    header("Location: /");
}

//Удаление:
if(isset($_GET["delete"])) {
    $id = $_GET["id"];
    $query_d_phone = "DELETE FROM phones WHERE user_id=:user_id";
    $del_p = sql($query_d_phone, array('user_id' => $id));
    $query_d_user = "DELETE FROM users WHERE id=:id";
    $del_u = sql($query_d_user, array('id' => $id));
?>
<script>
    window.location.href = 'http://phonebook.com/';
</script>
<?php
}

//Редактирование:
$id_edit = $_GET['id'];
$query_user = "SELECT u.*, GROUP_CONCAT(DISTINCT p.phone ORDER BY p.phone ASC SEPARATOR ' ') AS phones FROM users u LEFT JOIN phones p ON u.id=p.user_id WHERE u.id=:id_edit GROUP BY u.id";
$user_edit = sql($query_user, array('id_edit' => $id_edit)); //view.php

if(!empty($_POST["edit"])) {
    $id_post = $_POST["edit"];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $date = DateTime::createFromFormat('m/d/Y', $date)->format('Y-m-d');
    $years_user = time() - strtotime($date);

    if (isset($_POST["phones"])) {
        $phones = $_POST["phones"];
        foreach ($phones as $key => $item) {
            if (preg_match($pattern, $item)) {
                if (iconv_strlen($item) == 10) {
                    $item = '+38' . $item;
                }
                $search_p = '%' . $item . '%';
                $search_phone = "SELECT phone FROM phones WHERE phone LIKE :search_p";
                $result_search = sql($search_phone, array('search_p' => $search_p));
                if ($result_search == null) {
                    $query_edit_p = "UPDATE phones SET phone=:phone WHERE phone=:keys AND user_id=:id_post";
                    $edit_phone = sql($query_edit_p, array('phone' => $item, 'keys' => $key, 'id_post' => $id_post));
                }
            }
        }
    } else {
        $phone = $_POST['phone'];
        if (preg_match($pattern, $phone)) {
            if (iconv_strlen($phone) == 10) {
                $phone = '+38' . $phone;
            }
            $search_p = '%' . $phone . '%';
            $search_phone = "SELECT phone FROM phones WHERE phone LIKE :search_p";
            $result_search = sql($search_phone, array('search_p' => $search_p));
            if ($result_search == null) {
                $query_edit_p = "UPDATE phones SET phone=:phone WHERE user_id=:id_post";
                $edit_phone = sql($query_edit_p, array('phone' => $phone, 'id_post' => $id_post));
            }
        }
    }
    if (preg_match($pattern_email, $email) || empty($email)) {
        if ($years_user > $years) {
            $query_edit = "UPDATE users SET first_name=:first_name, last_name=:last_name, email=:email, date=:dates WHERE id=:id_post";
            $edit = sql($query_edit, array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'dates' => $date, 'id_post' => $id_post));
        }
    }
    header("Location: /edit.php?id=$id_post");
}

//Удаление телефона:
if (isset($_GET["remove"])) {
    $id = $_GET["id"];
    $phone = '+'.trim($_GET["phone"]);
    $query_delete = "DELETE FROM phones WHERE phone=:phone AND user_id=:user_id";
    $delete_phone = sql($query_delete, array('phone' => $phone, 'user_id' => $id));

    header("Location: /edit.php?id=$id");
}

//Добавление телефона:
if (!empty($_POST['newphone'])) {
    $phone = $_POST['newphone'];
    $id = $_POST["id"];
    if (preg_match($pattern, $phone)) {
        if (iconv_strlen($phone) == 10) {
            $phone = '+38' . $phone;
        }
        $search_p = '%' . $phone . '%';
        $search_phone = "SELECT phone FROM phones WHERE phone LIKE :search_p";
        $result_search = sql($search_phone, array('search_p' => $search_p));
        if ($result_search == null) {
            $query_insert = "INSERT INTO phones (user_id, phone) VALUES (:user_id, :phone)";
            $insert_phone = sql($query_insert, array('user_id' => $id, 'phone' => $phone));
        }
    }
    header("Location: /edit.php?id=$id");
}