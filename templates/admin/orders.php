<?php
    $deliveryText = [
      1 => 'Адрес самовывоза',
      2 => 'Адрес доставки'
    ];

    function splitPhoneNumber(string $number): string
    {
        $number = (strlen($number) === 11 && mb_substr($number, 0 ,1) === '8' ? substr_replace($number, '7', 0, 1) : $number);
        return mb_substr($number, 0 ,1) . ' ' . mb_substr($number, 1 ,3) . ' ' . mb_substr($number, 4 ,3) . ' ' . mb_substr($number, 7 ,2) . ' ' . mb_substr($number, 9 ,2);
    }
?>
<main class="page-order">
  <h1 class="h h--1">Список заказов</h1>
  <?php if(sizeof($orders) > 0) :?>
  <ul class="page-order__list">
    <?php foreach($orders as $order):?>
        <li class="order-item page-order__item" id="order_<?=$order['id']?>">
          <div class="order-item__wrapper">
            <div class="order-item__group order-item__group--id">
              <span class="order-item__title">Номер заказа</span>
              <span class="order-item__info order-item__info--id"><?=$order['id']?></span>
            </div>
            <div class="order-item__group">
              <span class="order-item__title">Сумма заказа</span>
                <?=$order['summa']?> руб.
            </div>
            <button class="order-item__toggle"></button>
          </div>
          <div class="order-item__wrapper">
            <div class="order-item__group order-item__group--margin">
              <span class="order-item__title">Заказчик</span>
              <span class="order-item__info"><?=$order['full_name']?></span>
            </div>
            <div class="order-item__group">
              <span class="order-item__title">Номер телефона</span>
              <span class="order-item__info">+<?=splitPhoneNumber($order['phone'])?></span>
            </div>
            <div class="order-item__group">
              <span class="order-item__title">Способ доставки</span>
              <span class="order-item__info"><?=$order['delivery_type_name']?></span>
            </div>
            <div class="order-item__group">
              <span class="order-item__title">Способ оплаты</span>
              <span class="order-item__info"><?=$order['payment_type_name']?></span>
            </div>
            <div class="order-item__group order-item__group--status">
              <span class="order-item__title">Статус заказа</span>
              <span class="order-item__info <?=$order['status'] == 1 ? 'order-item__info--yes' : 'order-item__info--no' ?>"><?=$order['status'] == 1 ? 'Выполнено' : 'Не выполнено' ?></span>
              <button class="order-item__btn">Изменить</button>
            </div>
          </div>
          <div class="order-item__wrapper">
            <div class="order-item__group">
              <span class="order-item__title"><?=$deliveryText[$order['delivery_type_id']]?></span>
              <span class="order-item__info"><?=$order['country']?> г. <?=$order['city']?>, ул. <?=$order['street']?>, д.<?=$order['street_number']?>,<?= !empty($order['room_number']) ? ' кв.' . $order['room_number'] : ''?></span>
            </div>
          </div>
          <div class="order-item__wrapper">
            <div class="order-item__group">
              <span class="order-item__title">Комментарий к заказу</span>
              <span class="order-item__info"><?=$order['comment']?></span>
            </div>
          </div>
        </li>
    <?php endforeach; ?>
  </ul>
  <?php else:?>
    <h2>Заказов нет</h2>
  <?php endif; ?>
</main>
