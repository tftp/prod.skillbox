<?php

session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helper_db.php';
$result = [];
if (isAdmin($_SESSION['user']['id'])) {
    $id = (int)$_POST['id'];
    $result['success'] = deactivityProduct($id);
    echo json_encode($result);
} else {
    echo json_encode(["error" => "Действие запрещено"]);
}
