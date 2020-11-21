<?php
// error_reporting(E_ALL);
// ini_set('display_errors', true);
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helper_db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helper_func.php';

$isExitSession = isSession() && isset($_GET['login']) && $_GET['login'] == 'exit';

if ($isExitSession) exitSession();

$strUrlPath = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$strUrlPath = array_filter($strUrlPath);

if (in_array('admin', $strUrlPath) && count($strUrlPath) > 1 && !isSession()) {
    header("Location: /admin/");
}

if (isset($_POST['email'])) {
    $postEmail = strip_tags($_POST['email']);
    $postPass = htmlspecialchars($_POST['password']);
    $user = getUser($postEmail);

    if (isset($user['password']) && password_verify($postPass, $user['password'])) {
        $_SESSION['success'] = true;
        $_SESSION['user'] = $user;
        setcookie('login', '', 1, '/admin/');
        setcookie('login', $postEmail, time() + 3600 * 24 * 30, '/admin/');
    } else {
        $error = "Неверный логин или пароль";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title><?= $title ?></title>

  <meta name="description" content="Fashion - интернет-магазин">
  <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

  <meta name="theme-color" content="#393939">

  <link rel="preload" href="/fonts/opensans-400-normal.woff2" as="font">
  <link rel="preload" href="/fonts/roboto-400-normal.woff2" as="font">
  <link rel="preload" href="/fonts/roboto-700-normal.woff2" as="font">

  <link rel="icon" href="/img/favicon.png">
  <link rel="stylesheet" href="/css/style.min.css">

  <script src="/js/scripts.js" defer=""></script>
</head>
<body>
<header class="page-header">
  <a class="page-header__logo" href="/">
    <img src="/img/logo.svg" alt="Fashion">
  </a>
  <nav class="page-header__menu">
    <ul class="main-menu main-menu--header">
        <?php if (isSession()) { ?>
            <li>
              <a class="main-menu__item" href="/">Главная</a>
            </li>
            <li>
              <a class="main-menu__item" href="/admin/products/">Товары</a>
            </li>
            <li>
              <a class="main-menu__item" href="/admin/orders/">Заказы</a>
            </li>
            <li>
              <a class="main-menu__item" href="?login=exit">Выйти</a>
            </li>
        <?php } else { ?>
            <li>
            <a class="main-menu__item" href="/">Главная</a>
            </li>
            <li>
            <a class="main-menu__item" href="/?filter%5Bnovelty%5D=on">Новинки</a>
            </li>
            <li>
            <a class="main-menu__item" href="/?filter%5Bsale%5D=on">Sale</a>
            </li>
            <li>
            <a class="main-menu__item" href="/delivery/">Доставка</a>
            </li>
        <?php } ?>
    </ul>
  </nav>
</header>
