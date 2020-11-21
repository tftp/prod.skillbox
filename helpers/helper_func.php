<?php

function isSession() {
    return isset($_SESSION['success']) && $_SESSION['success'] == true;
}

function exitSession() {
    session_destroy();
    setcookie('session_id', '', 1, '/');
    unset($_SESSION['success']);
    unset($_SESSION['user']);
    mysqli_close(connect());
}

function validatePostData() {
    $errors = [];
    if (empty($_POST['product-name'])) {
        $errors[] = "Нужно указать название продукта.";
    }
    if (empty($_POST['product-price'])) {
        $errors[] = "Нужно указать цену продукта.";
    }

    if (empty($_POST['category'])) {
        $errors[] = "Нужно указать категорию продукта.";
    }

    return $errors;
}

function isActiveSection($param, $value) {
    return isset($param) ? $param == $value : false;
}

function checkFilter($param, $minPrice, $maxPrice) {

    if (isset($param['min-price'])) {
        settype($param['min-price'], 'integer');
        $param['min-price'] = $param['min-price'] < $minPrice || $param['min-price'] > $maxPrice ? $minPrice : $param['min-price'];
    }

    if (isset($param['max-price'])) {
        settype($param['max-price'], 'integer');
        $param['max-price'] = $param['max-price'] > $maxPrice || $param['max-price'] < $minPrice ? $maxPrice : $param['max-price'];
    }

    $param['novelty'] = isset($param['novelty']) && in_array($param['novelty'], ['on', 1], true) ? 1 : 0;
    $param['sale'] = isset($param['sale']) && in_array($param['sale'], ['on', 1], true) ? 1 : 0;
    return $param;
}

function checkOrder($param) {
    if (isset($param['object'])) {
        $param['object'] = $param['object'] === 'price' ? 'price' : 'name';
    }

    if (isset($param['direction'])) {
        $param['direction'] = $param['direction'] === 'asc' ? 'asc' : 'desc';
    }
    return $param;
}

function checkProduct($param) {
    $result = '';
    if (isset($param)) {
        $result = strip_tags($param);
    }
    return $result;
}

function checkPriceOrder($price) {
    include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';

    if ($price <= $freeDelivery) {
        $price += $standartDelivery;
    }
    return $price;
}
