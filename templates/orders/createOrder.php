<section class="shop-page__order" hidden="">
    <button class="shop-page__order__close-button">+</button>
    <div class="shop-page__wrapper">
        <h2 class="h h--1">Оформление заказа</h2>
        <form action="/orders/add" method="post" class="custom-form js-order">
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
                        <input id="phone" class="custom-form__input" type="tel" name="thirdName" required="">
                        <p class="custom-form__input-label">Телефон <span class="req">*</span></p>
                    </label>
                    <label class="custom-form__input-wrapper" for="email">
                        <input id="email" class="custom-form__input" type="email" name="thirdName" required="">
                        <p class="custom-form__input-label">Почта <span class="req">*</span></p>
                    </label>
                </div>
            </fieldset>
            <fieldset class="custom-form__group js-radio">
                <legend class="custom-form__title custom-form__title--radio">Способ доставки</legend>
                <?php foreach ($deliveryTypes as $deliveryType):?>
                    <input
                            id="delivery_type_<?=$deliveryType['id']?>"
                            class="custom-form__radio"
                            type="radio" name="delivery"
                            value="<?=$deliveryType['id']?>"
                        <?=$deliveryType['id'] == $deliveryTypeDefault ? 'checked' : ''?>>
                    <label for="delivery_type_<?=$deliveryType['id']?>" class="custom-form__radio-label"><?=$deliveryType['name']?></label>
                <?php endforeach?>
            </fieldset>

            <?php require $_SERVER['DOCUMENT_ROOT'] . '/templates/orders/deliveryShop.php' ?>

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
                <?php foreach ($paymentTypes as $paymentType):?>
                    <input
                            id="payment_type_<?=$paymentType['id']?>"
                            class="custom-form__radio"
                            type="radio" name="pay"
                            value="<?=$paymentType['id']?>"
                        <?=$paymentType['id'] == $paymentTypeDefaultId ? 'checked' : ''?>>
                    <label for="payment_type_<?=$paymentType['id']?>" class="custom-form__radio-label"><?=$paymentType['name']?></label>
                <?php endforeach?>
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