<nav class="<?=$navClassName?>">
    <ul class="<?=$ulClassName?>">
        <?php foreach ($menu as $menuItem):?>
            <?php if(!isset($menuItem['accessRoles']) || (isset($userRoles) && isset($menuItem['accessRoles']) && sizeof(array_intersect($userRoles, $menuItem['accessRoles'])) > 0)) :?>
                <li>
                    <a class="<?=$itemClassName?> <?=$isShowActive && \ext\isCurrentUrl($menuItem['link']) ? 'active' : ''?>"
                       href="<?=$menuItem['link']?>">
                        <?=$menuItem['name']?>
                    </a>
                </li>
            <?php endif;?>
        <?php endforeach;?>
    </ul>
</nav>
