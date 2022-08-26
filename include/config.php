<?php
// разрешенные типы файлов для загрузки
$allowedType = ['image/jpg', 'image/jpeg', 'image/png'];

// разрешенный размер файлов для загрузки в MB
$allowedSize = 5;

// директория загрузки файлов
$uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/img/products/';

// количество продуктов на странице
$countOnPage = 6;

// Параметры доставки
$freeDelivery = 2000;       // сумма заказа для бесплатной доставки
$standartDelivery = 280;    // сумма стандартной доставки
$fastDelivery = 560;        // сумма быстрой доставки
$fitDelivery = 280;         // сумма доставки с примеркой

// Конфигурация базы данных
$host = 'localhost';
$user_db = 'student';
$password_db = 'student';
$dbname = 'prod';
