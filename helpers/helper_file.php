<?php

function uploadImage($file) {
    include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
    $result = [];
    $errors = errorsLoad($file);
    if (empty($errors)) {
        $pattern = '/.+\./';
        $replacement = time() . ".";
        $result['img_src'] = preg_replace($pattern, $replacement, $file['name']);
        $result['upload'] = move_uploaded_file($file['tmp_name'], $uploadPath . $result['img_src']);
    } else {
        $result['errors'] = $errors;
        $result['upload'] = false;
    }
    return $result;
}

function errorsLoad($file) {
    include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
    $errors = [];
    $isEmptyNameFile = empty($file['name']);
    $isAllowedType = in_array($file['type'], $allowedType);
    $isAllowedSize = $file['size'] / 1024 / 1024 <= $allowedSize;
    $isEmptyErrors = empty($file['error']);

    if ($isEmptyNameFile) {
        $errors[] = 'Изображение продукта не добавлено.';
        return $errors;
    }

    if (!$isAllowedType) {
        $errors[] = 'Несоответствие типов (разрешенные типы: png, jpg, jpeg)';
    }
    if (!$isAllowedSize) {
        $errors[] = "Размер файла должен быть менее {$allowedSize} Мб";
    }
    if (!$isEmptyErrors) {
        $errors[] = "Ошибка загрузки {$file['error']}";
    }
    return $errors;
}
