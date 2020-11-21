<?php
$title = 'Fashion';

include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

$productsPages = array_chunk($products, $countOnPage);
$countPages = count($productsPages);
if (isset($_GET['page']) && $_GET['page'] <= $countPages && $_GET['page'] > 0) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
?>

<main class="shop-page">
  <header class="intro">
    <div class="intro__wrapper">
      <h1 class=" intro__title">COATS</h1>
      <p class="intro__info">Collection 2018</p>
    </div>
  </header>
  <section class="shop container">
    <section class="shop__filter filter">
      <form method="get">
      <div class="filter__wrapper">
        <b class="filter__title">Категории</b>
        <ul class="filter__list">
          <li>
            <a class="filter__list-item <?= !isset($params['section']) || (isActiveSection($params['section'], 'all') || is_null($params['section'])) ? 'active' : '' ?>" href="/">Все</a>
          </li>
          <li>
            <a class="filter__list-item <?= isset($params['section']) && isActiveSection($params['section'], 'female') ? 'active' : '' ?>" href="?section=female">Женщины</a>
          </li>
          <li>
            <a class="filter__list-item <?= isset($params['section']) && isActiveSection($params['section'], 'male') ? 'active' : '' ?>" href="?section=male">Мужчины</a>
          </li>
          <li>
            <a class="filter__list-item <?= isset($params['section']) && isActiveSection($params['section'], 'children') ? 'active' : '' ?>" href="?section=children">Дети</a>
          </li>
          <li>
            <a class="filter__list-item <?= isset($params['section']) && isActiveSection($params['section'], 'access') ? 'active' : '' ?>" href="?section=access">Аксессуары</a>
          </li>
        </ul>
      </div>
        <div class="filter__wrapper">
          <b class="filter__title">Фильтры</b>
          <div class="filter__range range">
            <span class="range__info">Цена</span>
            <div class="range__line" aria-label="Range Line"></div>
            <div class="range__res">
              <span class="range__res-item min-price" data-min-price-products="<?= (int)$minPrice ?>" data-min-price="<?= $params['filter']['min-price'] ?? $minPrice ?>"><?= $params['filter']['min-price'] ?? $minPrice ?> руб.</span>
              <span class="range__res-item max-price" data-max-price-products="<?= (int)$maxPrice ?>" data-max-price="<?= $params['filter']['max-price'] ?? $maxPrice ?>"><?= $params['filter']['max-price'] ?? $maxPrice ?> руб.</span>
              <input type="text" name="filter[min-price]" id="input-min-price" value="<?= $params['filter']['min-price'] ?? $minPrice ?>" hidden>
              <input type="text" name="filter[max-price]" id="input-max-price" value="<?= $params['filter']['max-price'] ?? $maxPrice ?>" hidden>
            </div>
          </div>
        </div>

        <fieldset class="custom-form__group">
          <input type="checkbox" name="filter[novelty]" id="new" class="custom-form__checkbox" <?= isset($params['filter']) && isActiveSection($params['filter']['novelty'], 1) ? 'checked' : '' ?>>
          <label for="new" class="custom-form__checkbox-label custom-form__info" style="display: block;">Новинка</label>
          <input type="checkbox" name="filter[sale]" id="sale" class="custom-form__checkbox" <?= isset($params['filter']) && isActiveSection($params['filter']['sale'], 1) ? 'checked' : '' ?>>
          <label for="sale" class="custom-form__checkbox-label custom-form__info" style="display: block;">Распродажа</label>
        </fieldset>
        <button class="button" type="submit" style="width: 100%">Применить</button>
      </form>
    </section>

    <div class="shop__wrapper">
      <section class="shop__sorting">
        <div class="shop__sorting-item custom-form__select-wrapper">
          <select class="custom-form__select" name="order-on">
            <option hidden="">Сортировка</option>
            <option value="price" <?= isset($params['order']) && isActiveSection($params['order']['object'], 'price') ? 'selected' : '' ?>>По цене</option>
            <option value="name" <?= isset($params['order']) && isActiveSection($params['order']['object'], 'name') ? 'selected' : '' ?>>По названию</option>
          </select>
        </div>
        <div class="shop__sorting-item custom-form__select-wrapper">
          <select class="custom-form__select" name="order-how">
            <option hidden="">Порядок</option>
            <option value="asc" <?= isset($params['order']) && isActiveSection($params['order']['direction'], 'asc') ? 'selected' : '' ?>>По возрастанию</option>
            <option value="desc" <?= isset($params['order']) && isActiveSection($params['order']['direction'], 'desc') ? 'selected' : '' ?>>По убыванию</option>
          </select>
        </div>
        <a id="sorting-submit" hidden></a>
        <p class="shop__sorting-res">Найдено <span class="res-sort"><?= $countProducts ?></span> моделей</p>
      </section>
      <section class="shop__list">
          <?php if (!empty($productsPages)): ?>
              <?php foreach ($productsPages[$page - 1] as $product) { ?>
                  <article class="shop__item product" data-product-id="<?= $product['id'] ?>" tabindex="0">
                    <div class="product__image">
                      <img src="/img/products/<?= $product['img_path'] ?>" alt="<?= $product['name'] ?>">
                    </div>
                    <p class="product__name"><?= $product['name'] ?></p>
                    <span class="product__price"><?= $product['price'] ?> руб.</span>
                  </article>
              <?php } ?>
          <?php endif; ?>
      </section>
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
    </div>
  </section>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/order.php'; ?>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
