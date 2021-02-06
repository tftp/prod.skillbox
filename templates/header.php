<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helper_db.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helper_func.php';
$params = [];
$minPrice = getMinPrice();
$maxPrice = getMaxPrice();

if (isset($_COOKIE['filter'])) {
    $filter = unserialize($_COOKIE['filter']);
    $filter = checkFilter($filter, $minPrice, $maxPrice);
}

if (isset($_COOKIE['order'])) {
    $order = unserialize($_COOKIE['order']);
    $order = checkOrder($order);
}
if (isset($_COOKIE['section'])) {
    $section = strip_tags($_COOKIE['section']);
}

if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
    $filter = checkFilter($filter, $minPrice, $maxPrice);
    setcookie('filter', serialize($filter));
}

if (isset($_GET['order'])) {
    $order = $_GET['order'];
    $order = checkOrder($order);
    setcookie('order', serialize($order));
}

if (isset($_GET['section'])) {
    $section = strip_tags($_GET['section']);
    setcookie('section', $section);
}

if (isset($filter)) {
    $params['filter'] = $filter;
}

if (isset($order)) {
    $params['order'] = $order;
}

if (isset($section)) {
    $params['section'] = $section;
}

if (empty($_GET)) {
    setcookie('filter', '', 1);
    setcookie('order', '', 1);
    setcookie('section', '', 1);
    $params = [];
}

$products = getProducts($params);
$countProducts = count($products);
 ?>
 <!DOCTYPE html>
 <html lang="ru">
 <head>
   <meta charset="utf-8">
   <title><?= $title ?></title>

   <meta name="description" content="Fashion - интернет-магазин">
   <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

   <meta name="theme-color" content="#393939">

   <link rel="preload" href="/img/intro/coats-2018.jpg" as="image">
   <link rel="preload" href="/fonts/opensans-400-normal.woff2" as="font">
   <link rel="preload" href="/fonts/roboto-400-normal.woff2" as="font">
   <link rel="preload" href="/fonts/roboto-700-normal.woff2" as="font">

   <link rel="icon" href="/img/favicon.png">
   <link rel="stylesheet" href="/css/style.min.css">

   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script src="/js/scripts.js" defer=""></script>
 </head>
 <body>
 <header class="page-header">
   <a class="page-header__logo" href="/">
     <img src="/img/logo.svg" alt="Fashion">
   </a>
   <nav class="page-header__menu">
     <ul class="main-menu main-menu--header">
       <li>
         <a class="main-menu__item <?= (!isset($params['filter']) || (isActiveSection($params['filter']['novelty'], $params['filter']['sale']) || is_null($params['filter']['sale']))) && (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/') ? 'active' : '' ?>" href="/">Главная</a>
       </li>
       <li>
         <a class="main-menu__item <?= isset($params['filter']) && isActiveSection($params['filter']['novelty'], 1) && isActiveSection($params['filter']['sale'], 0) ? 'active' : '' ?>" href="/?filter%5Bnovelty%5D=on">Новинки</a>
       </li>
       <li>
         <a class="main-menu__item <?= isset($params['filter']) && isActiveSection($params['filter']['sale'], 1) && isActiveSection($params['filter']['novelty'], 0) ? 'active' : '' ?>" href="/?filter%5Bsale%5D=on">Sale</a>
       </li>
       <li>
         <a class="main-menu__item <?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/delivery/' ? 'active' : '' ?>" href="/delivery/">Доставка</a>
       </li>
     </ul>
   </nav>
 </header>
