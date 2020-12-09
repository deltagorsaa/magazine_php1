<section class="shop container">
    <?php self::showFilters(\dataAccess\goods\getFilters($filters['groups']))?>
    <?php self::showGoods(\dataAccess\goods\getGoods($filters))?>
</section>