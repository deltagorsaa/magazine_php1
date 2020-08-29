<section class="shop__sorting">
    <?php foreach ($sorting as $sortItem):?>
        <div class="shop__sorting-item custom-form__select-wrapper">
            <select class="custom-form__select" name="<?=$sortItem['id']?>">
                <option hidden=""><?=$sortItem['name']?></option>
                <?php foreach ($sortItem['values'] as $item):?>
                    <option value="<?=$item['id']?>" <?=$filters['sorting'][$sortItem['id']] === $item['id'] ? 'selected' : ''?>><?=$item['name']?></option>
                <?php endforeach?>
            </select>
        </div>
    <?php endforeach?>
    <p class="shop__sorting-res">Найдено <span class="res-sort"><?=$allCount?></span> моделей</p>
</section>
