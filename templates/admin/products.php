<main class="page-products">
  <h1 class="h h--1">Товары</h1>
  <a class="page-products__button button" href="add">Добавить товар</a>
  <div class="page-products__header">
    <span class="page-products__header-field">Название товара</span>
    <span class="page-products__header-field">ID</span>
    <span class="page-products__header-field">Цена</span>
    <span class="page-products__header-field">Категория</span>
    <span class="page-products__header-field">Новинка</span>
  </div>
  <ul class="page-products__list">
      <?php foreach ($products as $item):?>
          <li class="product-item page-products__item">
              <b class="product-item__name"><?=$item['short_name']?></b>
              <span class="product-item__field product-item__id"><?=$item['id']?></span>
              <span class="product-item__field"><?=$item['price']?> руб.</span>
              <span class="product-item__field"><?= $item['group_name'] ?? 'Не установлена' ?></span>
              <span class="product-item__field"><?=$item['is_active'] == true ? 'Да' : 'Нет'?></span>
              <a href="change?id=<?=$item['id']?>" class="product-item__edit" aria-label="Редактировать"></a>
              <button class="product-item__delete"></button>
          </li>
      <?php endforeach;?>
  </ul>
</main>