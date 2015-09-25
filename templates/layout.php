<!DOCTYPE html>
<html lang="<?php echo \thebuggenie\core\framework\Settings::getHTMLLanguage(); ?>">
    <head>
<?php \thebuggenie\core\framework\Event::createNew('core', 'layout.php::header-begins')->trigger(); ?>
        <meta charset="<?php echo \thebuggenie\core\framework\Context::getI18n()->getCharset(); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="The bug genie, friendly issue tracking">
        <meta name="keywords" content="thebuggenie friendly issue tracking">
        <meta name="author" content="thebuggenie.com">
        <title><?php echo ($tbg_response->hasTitle()) ? strip_tags(\thebuggenie\core\framework\Settings::getSiteHeaderName() . ' - ' . $tbg_response->getTitle()) : strip_tags(\thebuggenie\core\framework\Settings::getSiteHeaderName()); ?></title>
        <link rel="shortcut icon" href="<?php if (\thebuggenie\core\framework\Settings::isUsingCustomFavicon()): echo \thebuggenie\core\framework\Settings::getFaviconURL(); else: echo image_url('favicon.png'); endif; ?>">
        <link title="<?php echo (\thebuggenie\core\framework\Context::isProjectContext()) ? __('%project_name search', array('%project_name' => \thebuggenie\core\framework\Context::getCurrentProject()->getName())) : __('%site_name search', array('%site_name' => \thebuggenie\core\framework\Settings::getSiteHeaderName())); ?>" href="<?php echo (\thebuggenie\core\framework\Context::isProjectContext()) ? make_url('project_opensearch', array('project_key' => \thebuggenie\core\framework\Context::getCurrentProject()->getKey())) : make_url('opensearch'); ?>" type="application/opensearchdescription+xml" rel="search">
<?php foreach ($tbg_response->getFeeds() as $feed_url => $feed_title): ?>
        <link rel="alternate" type="application/rss+xml" title="<?php echo str_replace('"', '\'', $feed_title); ?>" href="<?php echo $feed_url; ?>">
<?php endforeach; ?>

<?php list ($localcss, $externalcss) = $tbg_response->getStylesheets(); ?>
<?php foreach ($localcss as $css): ?>
        <link rel="stylesheet" href="<?php print make_url('home').'css/'.$css; ?>">
<?php endforeach; ?>
<?php foreach ($externalcss as $css): ?>
        <link rel="stylesheet" href="<?php echo $css; ?>">
<?php endforeach; ?>

        <link href="<?php echo '/modules/bootgenie/assets/styles/bootgenie.css'; ?>" rel="stylesheet">

        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
<?php \thebuggenie\core\framework\Event::createNew('core', 'layout.php::header-ends')->trigger(); ?>
    </head>

    <body>
        <div id="main_container" class="page-<?php echo \thebuggenie\core\framework\Context::getRouting()->getCurrentRouteName(); ?>">
            <header>
                <?php \thebuggenie\core\framework\Logging::log('Rendering header'); ?>
                <?php require_once BOOTGENIE_PATH . 'templates/header.inc.php'; ?>
                <?php \thebuggenie\core\framework\Logging::log('done (rendering header)'); ?>
            </header>
            <div id="content_container">
                <div class="content-wrapper">
                <?php \thebuggenie\core\framework\Logging::log('Rendering content'); ?>
                <?php echo $content; ?>
                <?php \thebuggenie\core\framework\Logging::log('done (rendering content)'); ?>
                </div> <!-- /.content-wrapper -->
            </div> <!-- /#content_container -->
            <footer>
                <?php \thebuggenie\core\framework\Event::createNew('core', 'layout.php::footer-begins')->trigger(); ?>
                <?php require_once BOOTGENIE_PATH . 'templates/footer.inc.php'; ?>
                <?php \thebuggenie\core\framework\Event::createNew('core', 'layout.php::footer-ends')->trigger(); ?>
            </footer>
        </div> <!-- /#main_container -->

        <!-- Bootstrap -->
        <script src="/public/js/jquery-2.1.3.min.js"></script>
        <script src="/modules/bootgenie/assets/scripts/bootstrap.js"></script>
    </body>
</html>
