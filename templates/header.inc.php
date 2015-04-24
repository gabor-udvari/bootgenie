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
        <?php \thebuggenie\core\framework\Event::createNew('core', 'header_menu_end')->trigger(); ?>
    <?php endif; ?>
    </div> <!-- /.container-fluid -->
</nav>

<div class="container">
    <?php if (\thebuggenie\core\framework\Event::createNew('core', 'header_mainmenu_decider')->trigger()->getReturnValue() !== false): ?>
    <ol class="breadcrumb">
        <?php $breadcrumbs = $tbg_response->getBreadcrumbs(); ?>
        <?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
            <li>
                <?php $class = (array_key_exists('class', $breadcrumb) && $breadcrumb['class']) ? $breadcrumb['class'] : ''; ?>
                <?php if ($breadcrumb['url']): ?>
                    <?php echo link_tag($breadcrumb['url'], $breadcrumb['title'], array('class' => $class)); ?>
                <?php else: ?>
                    <span <?php if ($class): ?> class="<?php echo $class; ?>"<?php endif; ?>><?php echo $breadcrumb['title']; ?></span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        <li class="breadcrumb-form pull-right">
            <?php if ($tbg_user->canSearchForIssues()): ?>
                <form accept-charset="<?php echo \thebuggenie\core\framework\Context::getI18n()->getCharset(); ?>" action="<?php echo (\thebuggenie\core\framework\Context::isProjectContext()) ? make_url('search', array('project_key' => \thebuggenie\core\framework\Context::getCurrentProject()->getKey())) : make_url('search'); ?>" method="get" name="quicksearchform" id="quicksearchform" class="form-inline">
                    <div id="quicksearch_container">
                        <div class="form-group">
                            <input type="hidden" name="fs[text][o]" value="=">
                            <input type="search" name="fs[text][v]" accesskey="f" id="searchfor" placeholder="<?php echo __('Search for anything here'); ?>" class="autocomplete form-control">
                        </div>
                        <button type="submit" class="btn btn-default" id="quicksearch_submit"><?php echo \thebuggenie\core\framework\Context::getI18n()->__('Find'); ?></button>
                    </div>
                </form>
            <?php endif; ?>
        </li>
    </ol>

    <?php // require BOOTGENIE_PATH . 'templates/submenu.inc.php'; ?>
    <?php endif; ?>
</div>
