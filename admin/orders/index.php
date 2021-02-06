<?php $title = 'Список заказов';

include $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/header.php';

$orders = getOrders();
?>

<main class="page-order">
  <h1 class="h h--1">Список заказов</h1>
  <ul class="page-order__list">
      <?php foreach ($orders as $order): ?>
          <li class="order-item page-order__item">
            <div class="order-item__wrapper">
              <div class="order-item__group order-item__group--id">
                <span class="order-item__title">Номер заказа</span>
                <span class="order-item__info order-item__info--id"><?= $order['id'] ?></span>
              </div>
              <div class="order-item__group">
                <span class="order-item__title">Сумма заказа</span>
                <?= $order['delivery'] ? checkPriceOrder($order['price']) : $order['price'] ?> руб.
              </div>
              <button class="order-item__toggle"></button>
            </div>
            <div class="order-item__wrapper">
              <div class="order-item__group order-item__group--margin">
                <span class="order-item__title">Заказчик</span>
                <span class="order-item__info"><?= $order['fio'] ?></span>
              </div>
              <div class="order-item__group">
                <span class="order-item__title">Номер телефона</span>
                <span class="order-item__info"><?= $order['phone'] ?></span>
              </div>
              <div class="order-item__group">
                <span class="order-item__title">Способ доставки</span>
                <?php if ($order['delivery']) { ?>
                    <span class="order-item__info">Курьерная доставка</span>
                <?php } else { ?>
                    <span class="order-item__info">Самовывоз</span>
                <?php } ?>
              </div>
              <div class="order-item__group">
                <span class="order-item__title">Способ оплаты</span>
                <?php if ($order['pay'] === 'card') { ?>
                    <span class="order-item__info">Банковской картой</span>
                <?php } else { ?>
                    <span class="order-item__info">Наличными</span>
                <?php } ?>
              </div>
              <div class="order-item__group order-item__group--status">
                <span class="order-item__title">Статус заказа</span>
                <?php if ($order['status']) { ?>
                    <span class="order-item__info order-item__info--yes" data-order-id="<?= $order['id'] ?>" data-order-status="<?= $order['status'] ?>">Выполнено</span>
                <?php } else { ?>
                    <span class="order-item__info order-item__info--no" data-order-id="<?= $order['id'] ?>" data-order-status="<?= $order['status'] ?>">Не выполнено</span>
                <?php } ?>
                <button class="order-item__btn">Изменить</button>
              </div>
            </div>
            <div class="order-item__wrapper">
              <div class="order-item__group">
                <span class="order-item__title">Адрес доставки</span>
                <span class="order-item__info"><?= $order['address'] ?></span>
              </div>
            </div>
            <div class="order-item__wrapper">
              <div class="order-item__group">
                <span class="order-item__title">Комментарий к заказу</span>
                <span class="order-item__info"><?= $order['comment'] ?></span>
              </div>
            </div>
          </li>
      <?php endforeach; ?>

  </ul>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php'; ?>
