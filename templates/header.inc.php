<nav class="navbar navbar-default">
    <div class="container-fluid">
    <div id="logo_container" class="navbar-header">
        <?php \thebuggenie\core\framework\Event::createNew('core', 'header_before_logo')->trigger(); ?>
        <?php $link = (\thebuggenie\core\framework\Settings::getHeaderLink() == '') ? \thebuggenie\core\framework\Context::getWebroot() : \thebuggenie\core\framework\Settings::getHeaderLink(); ?>
        <div class="logo"><a href="<?php echo $link; ?>" class="navbar-brand"><?php echo image_tag(\thebuggenie\core\framework\Settings::getHeaderIconUrl(), [], \thebuggenie\core\framework\Settings::isUsingCustomHeaderIcon()); ?></a></div>
        <div class="logo_name"><a href="<?php echo $link; ?>" class="navbar-brand"><?php echo \thebuggenie\core\framework\Settings::getSiteHeaderName(); ?></a></div>
    </div>

    <?php if (!\thebuggenie\core\framework\Settings::isMaintenanceModeEnabled()): ?>
        <div id="topmenu-container">
            <?php if (\thebuggenie\core\framework\Event::createNew('core', 'header_mainmenu_decider')->trigger()->getReturnValue() !== false): ?>
                <?php require_once BOOTGENIE_PATH . 'templates/header-mainmenu.inc.php'; ?>
            <?php endif; ?>
            <?php require_once BOOTGENIE_PATH . 'templates/header-usermenu.inc.php'; ?>
        </div> <!-- #topmenu-container -->
        <?php if (\thebuggenie\core\framework\Event::createNew('core', 'header_mainmenu_decider')->trigger()->getReturnValue() !== false): ?>
            <?php // require THEBUGGENIE_CORE_PATH . 'templates/submenu.inc.php'; ?>
        <?php endif; ?>
        <?php \thebuggenie\core\framework\Event::createNew('core', 'header_menu_end')->trigger(); ?>
    <?php endif; ?>
    </div> <!-- /.container-fluid -->
</nav>
