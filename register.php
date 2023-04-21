<?php

require_once __DIR__ . '/boot.php';

$db = pdo()->prepare("SELECT * FROM `users` WHERE `username` = :username");
$db->execute(['username' => $_POST['username']]);
if ($db->rowCount() > 0) {
    flash('Это имя пользователя уже занято');
    header('Location: /');
    die;
}

$stmt = pdo()->prepare("INSERT INTO `users` (`username`, `password`) VALUES (:username, :password)");
$stmt->execute([
    'username' => $_POST['username'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
]);

header('Location: login.php');