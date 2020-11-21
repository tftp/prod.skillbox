<?php
$title = 'Изменение товара';
include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helper_file.php';
include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/header.php';

$idProduct = (int)$_GET['id'];
$product = getProduct($idProduct);
$sections = getSectionsOfProduct($idProduct);

if (isset($_POST['product-name']) && $product) {
    $errors = [];
    $errors = validatePostData();

    if (empty($errors) && isset($_FILES['product-photo'])) {
        if (empty($_FILES['product-photo']['name'])) {
            $fileUploadResult['upload'] = true;
            $fileUploadResult['img_src'] = $product['img_path'];
        } else {
            $fileUploadResult = uploadImage($_FILES['product-photo']);
            if (isset($fileUploadResult['errors'])) {
                $errors = $fileUploadResult['errors'];
            }
            if (empty($errors) && !$fileUploadResult['upload']) {
                $errors[] = "Ошибка загрузки файла. Нет прав доступа.";
            }
        }
    }
    if (empty($errors)) {
        if ($fileUploadResult['upload']) {
            $result = updateProductToBD($product['id'], $fileUploadResult['img_src']);
        }

        if (!$result) {
            $errors[] = "Ошибка сохранения в БД.";
        }
    }
}

 ?>

<main class="page-add">
  <h1 class="h h--1">Изменение товара</h1>
  <?php if (isAdmin($_SESSION['user']['id']) && $product) { ?>
      <?php if (!isset($_POST['add-button']) || !empty($errors)) { ?>
          <?php if (!empty($errors)) { ?>
              <div class="add-errors">
                  При изменении товара возникли ошибки: <?= implode(" ", $errors) ?>
              </div>
          <?php } ?>
      <form class="custom-form" method="post" enctype="multipart/form-data">
        <fieldset class="page-add__group custom-form__group">
          <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
          <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
            <input type="text" class="custom-form__input" name="product-name" id="product-name" value="<?= $product['name'] ?>">
          </label>
          <label for="product-price" class="custom-form__input-wrapper">
            <input type="text" class="custom-form__input" name="product-price" id="product-price" value="<?= $product['price'] ?>">
          </label>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
          <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
          <ul class="add-list">
              <li class="add-list__item add-list__item--add">
                <input type="file" name="product-photo" id="product-photo" hidden="" value=<?= $uploadPath . $product['img_path']  ?>>
                <label for="product-photo">Добавить фотографию</label>
              </li>
              <li class="add-list__item add-list__item--active">
                  <img src="<?= '/img/products/' . $product['img_path'] ?>">
              </li>
          </ul>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
          <legend class="page-add__small-title custom-form__title">Раздел</legend>
          <div class="page-add__select">
            <select name="category[]" class="custom-form__select" multiple="multiple">
              <option hidden="">Название раздела</option>
              <option value="female" <?= in_array('female', $sections) ? 'selected' : '' ?>>Женщины</option>
              <option value="male" <?= in_array('male', $sections) ? 'selected' : '' ?>>Мужчины</option>
              <option value="children" <?= in_array('children', $sections) ? 'selected' : '' ?>>Дети</option>
              <option value="access" <?= in_array('access', $sections) ? 'selected' : '' ?>>Аксессуары</option>
            </select>
          </div>
          <input type="checkbox" name="new" id="new" class="custom-form__checkbox" <?= $product['novelty'] == 1 ? 'checked' : '' ?>>
          <label for="new" class="custom-form__checkbox-label">Новинка</label>
          <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?= $product['sale'] == 1 ? 'checked' : '' ?>>
          <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
        </fieldset>
        <button class="button" type="submit" name="add-button">Изменить товар</button>
      </form>
    <?php } else { ?>
      <section class="shop-page__popup-end page-add__popup-end" >
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно изменен</h2>
        </div>
      </section>
    <?php } ?>
<?php } else {?>
    <div>Не найден товар для редактирования, либо вы не Администратор.</div>
<?php } ?>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
