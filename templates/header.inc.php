<nav class="navbar navbar-default">
    <div class="container-fluid">
    <div id="logo_container" class="navbar-header">
        <?php \thebuggenie\core\framework\Event::createNew('core', 'header_before_logo')->trigger(); ?>
        <?php $link = (\thebuggenie\core\framework\Settings::getHeaderLink() == '') ? \thebuggenie\core\framework\Context::getWebroot() : \thebuggenie\core\framework\Settings::getHeaderLink(); ?>
        <a class="logo" href="<?php print $link; ?>" class="navbar-brand"><?php echo image_tag(\thebuggenie\core\framework\Settings::getHeaderIconUrl(), array('style' => 'max-height: 24px;'), \thebuggenie\core\framework\Settings::isUsingCustomHeaderIcon()); ?></a>
        <div class="logo_name" class="navbar-brand"><?php echo \thebuggenie\core\framework\Settings::getSiteHeaderName(); ?></div>
    </div>

    <?php if (!\thebuggenie\core\framework\Settings::isMaintenanceModeEnabled()): ?>
        <div id="topmenu-container">
            <div class="navbar-inner">
            <?php if (\thebuggenie\core\framework\Event::createNew('core', 'header_mainmenu_decider')->trigger()->getReturnValue() !== false): ?>
                <?php require_once BOOTGENIE_PATH . 'templates/header-mainmenu.inc.php'; ?>
            <?php endif; ?>
            <?php require_once BOOTGENIE_PATH . 'templates/header-usermenu.inc.php'; ?>
            </div>
        </div>
        <?php if (\thebuggenie\core\framework\Event::createNew('core', 'header_mainmenu_decider')->trigger()->getReturnValue() !== false): ?>
            <?php // require THEBUGGENIE_CORE_PATH . 'templates/submenu.inc.php'; ?>
        <?php endif; ?>
        <?php \thebuggenie\core\framework\Event::createNew('core', 'header_menu_end')->trigger(); ?>
    <?php endif; ?>
    </div>
</nav>
