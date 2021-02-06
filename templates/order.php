<section class="shop-page__order" hidden="">
  <div class="shop-page__wrapper">
    <h2 class="h h--1">Оформление заказа</h2>
    <div class="order-error"></div>
    <form action="#" method="post" class="custom-form js-order">
      <input class="order-product-id" type="text" name="product-id" value="" hidden>
      <fieldset class="custom-form__group">
        <legend class="custom-form__title">Укажите свои личные данные</legend>
        <p class="custom-form__info">
          <span class="req">*</span> поля обязательные для заполнения
        </p>
        <div class="custom-form__column">
          <label class="custom-form__input-wrapper" for="surname">
            <input id="surname" class="custom-form__input" type="text" name="surname" required="">
            <p class="custom-form__input-label">Фамилия <span class="req">*</span></p>
          </label>
          <label class="custom-form__input-wrapper" for="name">
            <input id="name" class="custom-form__input" type="text" name="name" required="">
            <p class="custom-form__input-label">Имя <span class="req">*</span></p>
          </label>
          <label class="custom-form__input-wrapper" for="thirdName">
            <input id="thirdName" class="custom-form__input" type="text" name="thirdName">
            <p class="custom-form__input-label">Отчество</p>
          </label>
          <label class="custom-form__input-wrapper" for="phone">
            <input id="phone" class="custom-form__input" type="tel" name="phone" required="">
            <p class="custom-form__input-label">Телефон <span class="req">*</span></p>
          </label>
          <label class="custom-form__input-wrapper" for="email">
            <input id="email" class="custom-form__input" type="email" name="email" required="">
            <p class="custom-form__input-label">Почта <span class="req">*</span></p>
          </label>
        </div>
      </fieldset>
      <fieldset class="custom-form__group js-radio">
        <legend class="custom-form__title custom-form__title--radio">Способ доставки</legend>
        <input id="dev-no" class="custom-form__radio" type="radio" name="delivery" value="dev-no" checked="">
        <label for="dev-no" class="custom-form__radio-label">Самовывоз</label>
        <input id="dev-yes" class="custom-form__radio" type="radio" name="delivery" value="dev-yes">
        <label for="dev-yes" class="custom-form__radio-label">Курьерная доставка</label>
      </fieldset>
      <div class="shop-page__delivery shop-page__delivery--no">
        <table class="custom-table">
          <caption class="custom-table__title">Пункт самовывоза</caption>
          <tr>
            <td class="custom-table__head">Адрес:</td>
            <td>Москва г, Тверская ул,<br> 4 Метро «Охотный ряд»</td>
          </tr>
          <tr>
            <td class="custom-table__head">Время работы:</td>
            <td>пн-вс 09:00-22:00</td>
          </tr>
          <tr>
            <td class="custom-table__head">Оплата:</td>
            <td>Наличными или банковской картой</td>
          </tr>
          <tr>
            <td class="custom-table__head">Срок доставки: </td>
            <td class="date">13 декабря—15 декабря</td>
          </tr>
        </table>
      </div>
      <div class="shop-page__delivery shop-page__delivery--yes" hidden="">
        <fieldset class="custom-form__group">
          <legend class="custom-form__title">Адрес</legend>
          <p class="custom-form__info">
            <span class="req">*</span> поля обязательные для заполнения
          </p>
          <div class="custom-form__row">
            <label class="custom-form__input-wrapper" for="city">
              <input id="city" class="custom-form__input" type="text" name="city">
              <p class="custom-form__input-label">Город <span class="req">*</span></p>
            </label>
            <label class="custom-form__input-wrapper" for="street">
              <input id="street" class="custom-form__input" type="text" name="street">
              <p class="custom-form__input-label">Улица <span class="req">*</span></p>
            </label>
            <label class="custom-form__input-wrapper" for="home">
              <input id="home" class="custom-form__input custom-form__input--small" type="text" name="home">
              <p class="custom-form__input-label">Дом <span class="req">*</span></p>
            </label>
            <label class="custom-form__input-wrapper" for="aprt">
              <input id="aprt" class="custom-form__input custom-form__input--small" type="text" name="aprt">
              <p class="custom-form__input-label">Квартира <span class="req">*</span></p>
            </label>
          </div>
        </fieldset>
      </div>
      <fieldset class="custom-form__group shop-page__pay">
        <legend class="custom-form__title custom-form__title--radio">Способ оплаты</legend>
        <input id="cash" class="custom-form__radio" type="radio" name="pay" value="cash">
        <label for="cash" class="custom-form__radio-label">Наличные</label>
        <input id="card" class="custom-form__radio" type="radio" name="pay" value="card" checked="">
        <label for="card" class="custom-form__radio-label">Банковской картой</label>
      </fieldset>
      <fieldset class="custom-form__group shop-page__comment">
        <legend class="custom-form__title custom-form__title--comment">Комментарии к заказу</legend>
        <textarea class="custom-form__textarea" name="comment"></textarea>
      </fieldset>
      <button class="button" type="submit">Отправить заказ</button>
    </form>
  </div>
</section>
<section class="shop-page__popup-end" hidden="">
  <div class="shop-page__wrapper shop-page__wrapper--popup-end">
    <h2 class="h h--1 h--icon shop-page__end-title">Спасибо за заказ!</h2>
    <p class="shop-page__end-message">Ваш заказ успешно оформлен, с вами свяжутся в ближайшее время</p>
    <button class="button">Продолжить покупки</button>
  </div>
</section>
