<?php
$title =  'Авторизация';

include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/header.php';
?>

<main class="page-authorization">
  <h1 class="h h--1"><?= isSession() ? 'Вы успешно авторизованны' : 'Авторизация' ?></h1>
  <?php if (isset($error)): ?>
      <div><?= $error; ?></div>
  <?php endif; ?>
  <?php if (!isSession()) { ?>
      <form class="custom-form"  method="post">
        <input type="email" class="custom-form__input" required="" name="email">
        <input type="password" class="custom-form__input" required=""  name="password">
        <button class="button" type="submit">Войти в личный кабинет</button>
      </form>
  <?php } ?>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
