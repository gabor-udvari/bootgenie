<!DOCTYPE html>
<html lang="<?php echo \thebuggenie\core\framework\Settings::getHTMLLanguage(); ?>">
    <head>
        <meta charset="<?php echo \thebuggenie\core\framework\Context::getI18n()->getCharset(); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php \thebuggenie\core\framework\Event::createNew('core', 'layout.php::header-begins')->trigger(); ?>
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

        <!-- Bootstrap -->
        <link href="<?php echo '/modules/bootgenie/assets/css/bootstrap.min.css'; ?>" rel="stylesheet">
        <link href="<?php echo '/modules/bootgenie/assets/css/bootstrap-theme.min.css'; ?>" rel="stylesheet">
        <!-- Yamm -->
        <link href="<?php echo '/modules/bootgenie/assets/css/yamm.css'; ?>" rel="stylesheet">

        <?php if (false): ?>
        <script>
            var require = {
                baseUrl: '<?php echo make_url('home'); ?>js',
                paths: {
                    jquery: 'jquery-2.1.3.min',
                    'jquery-ui': 'jquery-ui.min'
                },
                map: {
                    '*': { 'jquery': 'jquery-private' },
                    'jquery-private': { 'jquery': 'jquery' }
                },
                shim: {
                    'prototype': {
                        // Don't actually need to use this object as
                        // Prototype affects native objects and creates global ones too
                        // but it's the most sensible object to return
                        exports: 'Prototype'
                    },
                    'jquery.markitup': {
                        deps: ['jquery']
                    },
                    'calendarview': {
                        deps: ['prototype'],
                        exports: 'Calendar'
                    },
                    'jquery.flot': {
                        deps: ['jquery']
                    },
                    'jquery.flot.selection': {
                        deps: ['jquery.flot']
                    },
                    'scriptaculous': {
                        deps: ['prototype', 'effects', 'controls'],
                        exports: 'Scriptaculous'
                    },
                    deps: [<?php echo join(', ', array_map(function ($element) { return "\"{$element}\""; }, $localjs)); ?>]
                }
            };
        </script>
        <script data-main="thebuggenie" src="<?php echo make_url('home'); ?>js/require.js"></script>
        <?php foreach ($externaljs as $js): ?>
            <script type="text/javascript" src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
        <?php endif; ?>

          <!--[if lt IE 9]>
              <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
          <![endif]-->
        <?php \thebuggenie\core\framework\Event::createNew('core', 'layout.php::header-ends')->trigger(); ?>
    </head>

    <body id="body">
        <div id="main_container" class="page-<?php echo \thebuggenie\core\framework\Context::getRouting()->getCurrentRouteName(); ?>">
            <?php if (!in_array(\thebuggenie\core\framework\Context::getRouting()->getCurrentRouteName(), array('login_page', 'elevated_login_page', 'reset_password'))): ?>
                <?php \thebuggenie\core\framework\Logging::log('Rendering header'); ?>
                <?php require_once BOOTGENIE_PATH . 'templates/header.inc.php'; ?>
                <?php \thebuggenie\core\framework\Logging::log('done (rendering header)'); ?>
            <?php endif; ?>
            <div id="content_container" class="container">
                <?php \thebuggenie\core\framework\Logging::log('Rendering content'); ?>
                <?php echo $content; ?>
                <?php \thebuggenie\core\framework\Logging::log('done (rendering content)'); ?>
            </div>
            <?php \thebuggenie\core\framework\Event::createNew('core', 'layout.php::footer-begins')->trigger(); ?>
            <?php require_once BOOTGENIE_PATH . 'templates/footer.inc.php'; ?>
            <?php \thebuggenie\core\framework\Event::createNew('core', 'layout.php::footer-ends')->trigger(); ?>
        </div>

        <?php require THEBUGGENIE_CORE_PATH . 'templates/backdrops.inc.php'; ?>
        <script type="text/javascript">
            var TBG, jQuery;
            require(['domReady', 'thebuggenie/tbg', 'jquery'], function (domReady, tbgjs, jquery) {
                domReady(function () {
                    TBG = tbgjs;
                    jQuery = jquery;
                    require(['scriptaculous']);
                    var f_init = function() {TBG.initialize({ basepath: '<?php echo $webroot; ?>', data_url: '<?php echo make_url('userdata'); ?>', autocompleter_url: '<?php echo (\thebuggenie\core\framework\Context::isProjectContext()) ? make_url('project_quicksearch', array('project_key' => \thebuggenie\core\framework\Context::getCurrentProject()->getKey())) : make_url('quicksearch'); ?>'})};
                    <?php if (\thebuggenie\core\framework\Context::isDebugMode()): ?>
                        TBG.debug = true;
                        TBG.debugUrl = '<?php echo make_url('debugger', array('debug_id' => '___debugid___')); ?>';
                        <?php
                            $load_time = \thebuggenie\core\framework\Context::getLoadTime();
                            $load_time = ($load_time >= 1) ? round($load_time, 2) . 's' : round($load_time * 1000, 1) . 'ms';
                        ?>
                        TBG.Core.AjaxCalls.push({location: 'Page loaded', time: new Date(), debug_id: '<?php echo \thebuggenie\core\framework\Context::getDebugID(); ?>', loadtime: '<?php echo $load_time; ?>'});
                        TBG.loadDebugInfo('<?php echo \thebuggenie\core\framework\Context::getDebugID(); ?>', f_init);
                    <?php else: ?>
                        f_init();
                    <?php endif; ?>
                });
            });
        </script>
        <!-- Bootstrap -->
        <script src="/public/js/jquery-2.1.3.min.js"></script>
        <script src="/modules/bootgenie/assets/js/bootstrap.min.js"></script>
    </body>
</html>
