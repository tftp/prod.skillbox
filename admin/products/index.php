<?php
$title = 'Товары';
include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/header.php';

$products = getProducts();
$productsPages = array_chunk($products, $countOnPage);
$countPages = count($productsPages);
if (isset($_GET['page']) && $_GET['page'] <= $countPages && $_GET['page'] > 0) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
?>

<main class="page-products">
  <h1 class="h h--1">Товары</h1>
  <?php if (isAdmin($_SESSION['user']['id'])) { ?>
      <a class="page-products__button button" href="/admin/products/add/">Добавить товар</a>
      <div class="page-products__header">
        <span class="page-products__header-field">Название товара</span>
        <span class="page-products__header-field">ID</span>
        <span class="page-products__header-field">Цена</span>
        <span class="page-products__header-field">Категория</span>
        <span class="page-products__header-field">Новинка</span>
      </div>
      <ul class="page-products__list">
        <?php foreach ($productsPages[$page - 1] as $product) { ?>
            <li class="product-item page-products__item">
              <b class="product-item__name"><?= $product['name'] ?></b>
              <span class="product-item__field"><?= $product['id'] ?></span>
              <span class="product-item__field"><?= $product['price'] ?> руб.</span>
              <span class="product-item__field"><?= str_replace(['female','male', 'children', 'access'], ['Женщины', 'Мужчины', 'Дети', 'Аксессуары'], implode(', ', $product['sections'])) ?></span>
              <span class="product-item__field"><?= str_replace([1, 0], ['Да', 'Нет'], $product['novelty']) ?></span>
              <a href="/admin/products/update/?id=<?= $product['id'] ?>" class="product-item__edit" aria-label="Редактировать"></a>
              <button class="product-item__delete" data-product-id="<?= $product['id'] ?>"></button>
            </li>
        <?php } ?>
      </ul>
      <!-- Страницы: -->
      <ul class="shop__paginator paginator">
      <?php for ($i=0; $i < $countPages; $i++) { ?>
          <?php if ($i === $page - 1) { ?>
              <li>
                <a class="paginator__item"><?= $i + 1 ?></a>
              </li>
          <?php } else { ?>
              <li>
                <a class="paginator__item" href="?page=<?= $i + 1 ?>"><?= $i + 1 ?></a>
              </li>
          <?php } ?>
      <?php } ?>
      </ul>
  <?php } else {?>
      <div>Раздел доступен Администраторам.</div>
  <?php } ?>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
