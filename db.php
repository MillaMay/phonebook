<?php
$host = '127.0.0.1';
$db   = 'phonebook';
$charset = 'utf8';

$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    //PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
function sql($sql = null, $placeholders = null) {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $placeholders ? $stmt->execute($placeholders) : $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}