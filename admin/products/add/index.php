<?php
$title = 'Добавление товара';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helper_file.php';
include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/header.php';

if (isset($_POST['product-name'])) {
    $errors = [];
    $errors = validatePostData();

    if (empty($errors) && isset($_FILES['product-photo'])) {
        $fileUploadResult = uploadImage($_FILES['product-photo']);
        if (isset($fileUploadResult['errors'])) {
            $errors = $fileUploadResult['errors'];
        }
        if (empty($errors) && !$fileUploadResult['upload']) {
            $errors[] = "Ошибка загрузки файла. Нет прав доступа.";
        }
    }
    if (empty($errors)) {
        if ($fileUploadResult['upload']) {
            $result = addProductToBD($fileUploadResult['img_src']);
        }

        if (!$result) {
            $errors[] = "Ошибка сохранения в БД.";
        }
    }
}
?>

<main class="page-add">
  <h1 class="h h--1">Добавление товара</h1>
  <?php if (isAdmin($_SESSION['user']['id'])) { ?>
      <?php if (!isset($_POST['add-button']) || !empty($errors)) { ?>
          <?php if (!empty($errors)) { ?>
              <div class="add-errors">
                  При добавлении товара возникли ошибки: <?= implode(" ", $errors) ?>
              </div>
          <?php } ?>
      <form class="custom-form" method="post" enctype="multipart/form-data">
        <fieldset class="page-add__group custom-form__group">
          <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
          <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
            <input type="text" class="custom-form__input" placeholder="Название товара" name="product-name" id="product-name" value="<?= checkProduct($_POST['product-name']) ?>">
          </label>
          <label for="product-price" class="custom-form__input-wrapper">
            <input type="text" class="custom-form__input" placeholder="Цена товара" name="product-price" id="product-price" value="<?= checkProduct($_POST['product-price']) ?>">
          </label>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
          <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
          <ul class="add-list">
            <li class="add-list__item add-list__item--add">
              <input type="file" name="product-photo" id="product-photo" hidden="">
              <label for="product-photo">Добавить фотографию</label>
            </li>
          </ul>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
          <legend class="page-add__small-title custom-form__title">Раздел</legend>
          <div class="page-add__select">
            <select name="category[]" class="custom-form__select" multiple="multiple">
              <option hidden="">Название раздела</option>
              <option value="female" <?= in_array('female', $_POST['category']) ? 'selected' : '' ?>>Женщины</option>
              <option value="male" <?= in_array('male', $_POST['category']) ? 'selected' : '' ?>>Мужчины</option>
              <option value="children" <?= in_array('children', $_POST['category']) ? 'selected' : '' ?>>Дети</option>
              <option value="access" <?= in_array('access', $_POST['category']) ? 'selected' : '' ?>>Аксессуары</option>
            </select>
          </div>
          <input type="checkbox" name="new" id="new" class="custom-form__checkbox" <?= isset($_POST['new']) ? 'checked' : '' ?>>
          <label for="new" class="custom-form__checkbox-label">Новинка</label>
          <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?= isset($_POST['sale']) ? 'checked' : '' ?>>
          <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
        </fieldset>
        <button class="button" type="submit" name="add-button">Добавить товар</button>
      </form>
    <?php } else { ?>
      <section class="shop-page__popup-end page-add__popup-end" >
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно добавлен</h2>
        </div>
      </section>
    <?php } ?>
<?php } else {?>
    <div>Раздел доступен только Администраторам.</div>
<?php } ?>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
