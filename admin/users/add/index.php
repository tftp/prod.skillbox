<?php
// Временный файл для добавления зарегестрированных пользователей

include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helper_db.php';
$email = 'operator@localhost';
$password = '123456';

$hash = password_hash($password, PASSWORD_BCRYPT);
$query = "insert into users (email, password) values ('$email', '$hash')";
$result = mysqli_query(connect(), $query);
echo $result;
