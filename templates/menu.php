<nav class="<?=$navClassName?>">
    <ul class="<?=$ulClassName?>">
        <?php foreach ($menu as $menuItem):?>
            <li>
                <a class="<?=$itemClassName?> <?=$isShowActive && \ext\isCurrentUrl($menuItem['link']) ? 'active' : ''?>" href="<?=$menuItem['link']?>">
                    <?=$menuItem['name']?>
                </a>
            </li>
        <?php endforeach?>
    </ul>
</nav>
