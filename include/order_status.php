<?php

session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helper_db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helper_func.php';

$result = false;

if (isSession() && isset($_POST['id']) && isset($_POST['status'])) {
    $id = (int)$_POST['id'];
    $status = (int)$_POST['status'];

    $result = changeStatusOrder($id, $status);
}

echo json_encode($result);
