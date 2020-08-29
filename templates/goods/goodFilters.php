<section class="shop__filter filter">
    <form class="filter__form">
        <div class="filter__wrapper">
            <b class="filter__title">Категории</b>
            <ul class="filter__list">
                <?php foreach ($categoryFilters as $filterItem):?>
                    <li>
                        <a class="filter__list-item <?=\ext\isCurrentUrl($filterItem['link']) ? 'active' : '' ?>" href="<?=$filterItem['link']?>">
                            <?=$filterItem['name']?>
                        </a>
                    </li>
                <?php endforeach?>
            </ul>
        </div>
        <div class="filter__wrapper">
            <b class="filter__title">Фильтры</b>
            <?php foreach ($rangeFilters as $filterItem):?>
                <div class="filter__range range">
                    <span class="range__info"><?=$filterItem['name']?></span>
                    <div class="range__line" aria-label="Range Line"></div>
                    <div class="range__res">
                        <span class="range__res-item <?=$filterItem['minValueClass']?> min-value">
                            <?=$filterItem['minValue']?> <?=$filterItem['dimension']?>
                        </span>

                        <span class="range__res-item <?=$filterItem['maxValueClass']?> max-value">
                            <?=$filterItem['maxValue']?> <?=$filterItem['dimension']?>
                        </span>
                    </div>
                </div>
            <?php endforeach?>
        </div>

        <fieldset class="custom-form__group">
            <?php foreach ($checkedFilters as $filterItem):?>
                <input
                        type="checkbox"
                        name="<?=$filterItem['id']?>"
                        id="<?=$filterItem['id']?>"
                        class="custom-form__checkbox"
                        <?=\ext\isCurrentUrl('/goods/'.$filterItem['id'] . '/') ? 'checked' : ''?>
                >
                <label for="<?=$filterItem['id']?>" class="custom-form__checkbox-label custom-form__info" style="display: block;"><?=$filterItem['name']?></label>
            <?php endforeach?>
        </fieldset>
        <button class="button" type="submit" style="width: 100%">Применить</button>
    </form>
</section>
