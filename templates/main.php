<?php
require $_SERVER['DOCUMENT_ROOT'] . '/include/controllers/orders.php';
?>
<main class="shop-page">
    <header class="intro">
        <div class="intro__wrapper">
            <h1 class=" intro__title">COATS</h1>
            <p class="intro__info">Collection 2018</p>
        </div>
    </header>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/templates/mainShopContainer.php' ?>
    <?php \controllers\Order::showOrder()?>
</main>