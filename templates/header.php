<header class="page-header">
    <a class="page-header__logo" href="#">
        <img src="/img/logo.svg" alt="Fashion">
    </a>

    <?php \ext\showMenu(
            $menu
            ,'page-header__menu'
            ,'main-menu main-menu--header'
            ,true
            ,(method_exists($this, 'getUserRoles') ? $this-> getUserRoles() : []))?>
</header>