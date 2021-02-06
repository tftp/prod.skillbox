<?php

function connect() {
    include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';

    static $connection = null;

    if (null === $connection) {
        $connection = mysqli_connect($host, $user_db, $password_db, $dbname) or die('connection Error');
    }
    return $connection;
}

function getUser($email) {
    $email = mysqli_real_escape_string(connect(), $email);

    $query = "select * from users where email = '$email' limit 1";

    $result = mysqli_query(connect(), $query);

    return mysqli_fetch_array($result, MYSQLI_ASSOC);
}

function getRoles(int $id) {
    $roles = [];
    $query = "select roles.title from users
            join role_user on role_user.users_id = users.id
            join roles on roles.id = role_user.roles_id
            where users.id = '$id'";

    $result = mysqli_query(connect(), $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $roles[] = $row['title'];
    }
    return $roles;
}

function addProductToBD($imgSrc) {
    $name = mysqli_real_escape_string(connect(), $_POST['product-name']);
    $price = mysqli_real_escape_string(connect(), $_POST['product-price']);
    $img_path = mysqli_real_escape_string(connect(), $imgSrc);
    $novelty = isset($_POST['new']) ? 1 : 0;
    $sale = isset($_POST['sale']) ? 1 : 0;

    $query = "insert into products (name, price, img_path, novelty, sale)
                values ('$name', '$price', '$img_path', '$novelty', '$sale')";

    $result = mysqli_query(connect(), $query);

    if ($result) {
        $id = getLastID('products');
    }

    if ($result && isset($_POST['category'])) {
        foreach ($_POST['category'] as $section_name) {
            $section = getSection($section_name);
            if (isset($section['id'])) {
                setSectionProduct($id, $section['id']);
            }
        }
    }
    return $result;
}

function updateProductToBD($id, $imgSrc) {
    $id = mysqli_real_escape_string(connect(), $id);
    $name = mysqli_real_escape_string(connect(), $_POST['product-name']);
    $price = mysqli_real_escape_string(connect(), $_POST['product-price']);
    $img_path = mysqli_real_escape_string(connect(), $imgSrc);
    $novelty = isset($_POST['new']) ? 1 : 0;
    $sale = isset($_POST['sale']) ? 1 : 0;

    $query = "update products set name = '$name', price = '$price', img_path = '$img_path',
                novelty = '$novelty', sale = '$sale' where id = '$id'";

    $result = mysqli_query(connect(), $query);

    if ($result && isset($_POST['category'])) {
        deleteSectionProduct($id);
        foreach ($_POST['category'] as $section_name) {
            $section = getSection($section_name);
            if (isset($section['id'])) {
                setSectionProduct($id, $section['id']);
            }
        }
    }
    return $result;
}

function getSection($name) {
    $name = mysqli_real_escape_string(connect(), $name);

    $query = "select id from sections where name = '$name' limit 1";

    $result = mysqli_query(connect(), $query);

    return mysqli_fetch_array($result, MYSQLI_ASSOC);
}

function getSectionsOfProduct($id) {
    $id = mysqli_real_escape_string(connect(), $id);
    $sections = [];

    $query = "select sections.name from product_section
                join sections on sections.id = product_section.sections_id
                where product_section.products_id = '$id'";

    $result = mysqli_query(connect(), $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $sections[] = $row['name'];
    }
    return $sections;
}

function setSectionProduct(int $product_id, int $section_id) {
    $query = "insert into product_section (products_id, sections_id)
                values ('$product_id', '$section_id')";

    return mysqli_query(connect(), $query);
}

function isAdmin(int $id) {
    return in_array('Администратор', getRoles($id));
}

function deleteSectionProduct(int $id) {
    $query = "delete from product_section where products_id = '$id'";

    return mysqli_query(connect(), $query);
}

function getProducts($params = []) {
    $products = [];
    $query = createQuery($params);
    $result = mysqli_query(connect(), $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = ['id' => $row['id'],
                        'name' => $row['name'],
                        'price' => $row['price'],
                        'novelty' => $row['novelty'],
                        'img_path' => $row['img_path'],
                        'sections' => getSectionsOfProduct($row['id'])];

    }
    return $products;
}

function getProduct($id) {
    $id = mysqli_real_escape_string(connect(), $id);

    $query = "select * from products where id = '$id'";

    $result = mysqli_query(connect(), $query);
    return mysqli_fetch_array($result, MYSQLI_ASSOC);
}

function deactivityProduct($id) {
    $id = mysqli_real_escape_string(connect(), $id);

    $query = "update products set activity = '0' where id = '$id'";

    return mysqli_query(connect(), $query);
}

function createQuery($params) {
    $query = "select * from products where activity = 1";
    $advancedQuery = "";
    if (isset($params['filter']['novelty']) && $params['filter']['novelty']) {
        $advancedQuery .= " and novelty = 1 ";
    }

    if (isset($params['filter']['sale']) && $params['filter']['sale']) {
        $advancedQuery .= " and sale = 1 ";
    }

    if (isset($params['section'])) {
        $section = mysqli_real_escape_string(connect(), $params['section']);

        if ($section == 'all') {
            $query = "select * from products where activity = 1";
        } else {
            $query =  "select products.* from products
                        join product_section on products_id = products.id
                        join sections on sections.id = sections_id
                        where sections.name = '$section' and products.activity = 1";
        }
    }

    if (isset($params['filter']['min-price']) && isset($params['filter']['max-price'])) {
        $minPrice = $params['filter']['min-price'];
        $maxPrice = $params['filter']['max-price'];
        $advancedQuery .= " and price >= '$minPrice' and price <= '$maxPrice' ";
    }

    if (isset($params['order']['object']) && isset($params['order']['direction'])) {
        $object = $params['order']['object'];
        $direction = $params['order']['direction'];
        $advancedQuery.=" order by $object $direction ";
    }

    return $query . $advancedQuery;
}

function createOrder($params) {
    $fio = implode(' ', $params['fio']);
    $phone = $params['phone'];
    $email = $params['email'];
    $delivery = $params['delivery'];
    $address = isset($params['address']) ? implode(' ', $params['address']) : null;
    $comment = $params['comment'];
    $pay = $params['pay'];
    $productId = $params['productId'];

    $query = "insert into orders (fio, phone, email, delivery, address, comment, pay)
                values ('$fio', '$phone', '$email', '$delivery', '$address', '$comment', '$pay')";

    $result = mysqli_query(connect(), $query);

    if ($result) {
        $id = getLastID('orders');
        $result = setRelationOrderProduct($id, $productId);
    }
    return $result;
}

function setRelationOrderProduct($order_id, $product_id) {
    $query = "insert into order_product (orders_id, products_id) values ('$order_id', '$product_id')";

    return mysqli_query(connect(), $query);
}

function getOrders() {
    $query = "select orders.*, products.price from orders join order_product on orders_id = orders.id
                join products on products.id = order_product.products_id order by status asc, create_time desc ";

    $result = mysqli_query(connect(), $query);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function changeStatusOrder($id, $status) {
    $query = "update orders set status = $status where id = $id";

    return mysqli_query(connect(), $query);
}

function getMinPrice() {
    $query = "select price from products order by price asc limit 1";

    $result = mysqli_query(connect(), $query);

    $price = mysqli_fetch_array($result, MYSQLI_ASSOC);

    return $price['price'];
}

function getMaxPrice() {
    $query = "select price from products order by price desc limit 1";

    $result = mysqli_query(connect(), $query);

    $price = mysqli_fetch_array($result, MYSQLI_ASSOC);

    return $price['price'];
}

function getLastID($table) {
    $query = "select id from $table order by id desc limit 1";

    $result = mysqli_query(connect(), $query);

    $product = mysqli_fetch_array($result, MYSQLI_ASSOC);

    return $product['id'];
}
