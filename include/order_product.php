<?php

include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helper_db.php';

$errors = [];
$success = false;

$params = [];

if (isset($_POST['surname']) && isset($_POST['name'])) {
    $params['fio'][] = strip_tags($_POST['surname']);
    $params['fio'][] = strip_tags($_POST['name']);
    if (isset($_POST['thirdName'])) {
        $params['fio'][] = strip_tags($_POST['thirdName']);
    }
} else {
    $errors[] = 'Незаполненны обязательные поля';
}

if (isset($_POST['delivery'])) {
    $params['delivery'] = $_POST['delivery'] === 'dev-yes' ? 1 : 0;

    if ($params['delivery']) {
        if (isset($_POST['city']) && isset($_POST['street']) && isset($_POST['home']) && isset($_POST['aprt'])) {
            $params['address'][] = strip_tags($_POST['city']);
            $params['address'][] = strip_tags($_POST['street']);
            $params['address'][] = strip_tags($_POST['home']);
            $params['address'][] = strip_tags($_POST['aprt']);
        } else {
            $error[] = 'Отсутствуют обязательные данные адреса доставки';
        }
    }
} else {
    $errors[] = 'Отсутствует параметр доставки';
}

if (isset($_POST['comment'])) {
    $params['comment'] = htmlspecialchars($_POST['comment']);
}

if (isset($_POST['email'])) {
    $params['email'] = strip_tags($_POST['email']);
} else {
    $errors[] = 'Не указан email';
}

if (isset($_POST['pay'])) {
    $params['pay'] = strip_tags($_POST['pay']);
} else {
    $errors[] = 'Не указан способ оплаты';
}

if (isset($_POST['phone'])) {
    $params['phone'] = strip_tags($_POST['phone']);
} else {
    $errors[] = 'Не указан телефон';
}

if (isset($_POST['product-id'])) {
    $params['productId'] = (int)$_POST['product-id'];
} else {
    $errors[] = 'Такого продукта нет в каталоге';
}

if (empty($errors)) {
    $success = createOrder($params);
    echo json_encode(["success" => $success]);
} else {
    echo json_encode(["errors" => $errors]);
}
