<main class="page-add">
  <h1 class="h h--1"><?= isset($changedProduct) ? 'Изменение' : 'Добавление' ?> товара</h1>
  <form class="custom-form" action="#" method="post" <?= isset($changedProduct) ? "id=${changedProduct['id']}" : null ?>>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
      <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="product-name" id="product-name" value="<?= $changedProduct['short_name'] ?? null ?>" required>
        <p class="custom-form__input-label" <?= isset($changedProduct) ? 'hidden' : null ?>>
            Название товара
        </p>
      </label>
      <label for="product-price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="product-price" id="product-price" value="<?= $changedProduct['price'] ?? null ?>" required>
        <p class="custom-form__input-label" <?= isset($changedProduct) ? 'hidden' : null ?>>
          Цена товара
        </p>
      </label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
      <ul class="add-list">
        <li class="add-list__item add-list__item--add">
          <input type="file" name="product-photo" id="product-photo" hidden="" value="<?= $changedProduct['image_path'] ?? null ?>" required>
          <label for="product-photo">Добавить фотографию</label>
        </li>
      </ul>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>
      <div class="page-add__select">
        <select name="category" class="custom-form__select" multiple="multiple" required>
          <option hidden="">Название раздела</option>
            <?php foreach($groups as $group) :?>
                <option value="<?=$group['code']?>" <?= (isset($changedProduct) && $changedProduct['group_id'] === $group['id']) ? 'selected' : null ?>> <?=$group['short_name']?> </option>
            <?php endforeach; ?>
        </select>
      </div>
      <input type="checkbox"
             name="new"
             id="new"
             class="custom-form__checkbox"
             <?= (isset($changedProduct) && $this->checkInGroup($changedProductGroups, 'new')) ? 'checked' : null ?>
        >
      <label for="new" class="custom-form__checkbox-label">Новинка</label>
      <input type="checkbox"
             name="sale"
             id="sale"
             class="custom-form__checkbox"
            <?= (isset($changedProduct) && $this->checkInGroup($changedProductGroups, 'sale')) ? 'checked' : null ?>
      >
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
    </fieldset>
    <button class="button" type="submit"><?= isset($changedProduct) ? 'Изменить' : 'Добавить' ?> товар</button>
  </form>
  <section class="shop-page__popup-end page-add__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно добавлен</h2>
    </div>
  </section>
</main>