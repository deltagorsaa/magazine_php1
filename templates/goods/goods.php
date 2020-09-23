<div class="shop__wrapper">
   <?php self::showSorting($allCount, $filters);?>

    <section class="shop__list">
        <?php foreach($goods as $goodItem):?>
            <article class="shop__item product" tabindex="0">
                <div class="product__image">
                    <img src="<?=$goodItem['image_path']?>" alt="product-name">
                </div>
                <p class="product__name"><?=$goodItem['short_name']?></p>
                <span class="product__price">
                <?=number_format($goodItem['price'], $goodItem['price'] - round($goodItem['price'], 2, PHP_ROUND_HALF_DOWN) == 0 ? 0 : 2,'.',' ')?> руб.
            </span>
            </article>
        <?php endforeach?>
    </section>
    <?php if($allCount > GOODS_PER_PAGE):?>
        <ul class="shop__paginator paginator">
            <?php if(isset($allCount)):?>
                <?php for($pageNumber = 1; $pageNumber <= round($allCount / GOODS_PER_PAGE) + 1; $pageNumber++):?>
                    <li>
                        <a class="paginator__item" <?=$filters['page'] !== $pageNumber ? 'href="?page=' .$pageNumber .'"'  : ''?>>
                            <?=$pageNumber?>
                        </a>
                    </li>
                <?php endfor?>
            <?php endif?>
        </ul>
    <?php endif?>
</div>
