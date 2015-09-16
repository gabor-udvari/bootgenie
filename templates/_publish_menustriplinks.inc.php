<li class="dropdown" <?php if (strpos($tbg_response->getPage(), 'publish') === 0): ?> class="active"<?php endif; ?>>
    <?php if (!isset($wiki_url)): ?>
        <a href="<?php echo ((isset($project_url)) ? $project_url : $url); ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo image_tag('tab_publish.png', array(), false, 'publish'); ?> <?php echo \thebuggenie\core\framework\Context::getModule('publish')->getMenuTitle(); ?> <span class="caret"></span></a>
    <?php else: ?>
        <?php echo link_tag($wiki_url, \thebuggenie\core\framework\Context::getModule('publish')->getMenuTitle(), array('target' => 'blank')) ?>
    <?php endif; ?>

    <?php if (count(\thebuggenie\core\entities\Project::getAll())): ?>
     <ul class="dropdown-menu">
        <li>
        <div id="wiki_dropdown_menu" class="tab_menu_dropdown yamm-content">
            <?php if (\thebuggenie\core\framework\Context::isProjectContext()): ?>
            <div class="header"><?php echo \thebuggenie\core\framework\Context::getCurrentProject()->getName(); ?></div>
                <?php if (!isset($wiki_url)): ?>
                    <?php echo link_tag($project_url, __('Project wiki frontpage')); ?>
                    <?php $quicksearch_title = __('Find project article (press enter to search)'); ?>
                    <div style="font-weight: normal; margin: 0 0 15px 5px;">
                        <form action="<?php echo make_url('publish_find_project_articles', array('project_key' => \thebuggenie\core\framework\Context::getCurrentProject()->getKey())); ?>" method="get" accept-charset="<?php echo \thebuggenie\core\framework\Context::getI18n()->getCharset(); ?>">
                            <input type="search" name="articlename" placeholder="<?php echo $quicksearch_title; ?>">
                        </form>
                    </div>
                <?php else: ?>
                    <?php echo link_tag($wiki_url, __('Project wiki frontpage'), array('target' => 'blank')) ?>
                <?php endif; ?>
            <?php endif; ?>
            <div class="header"><?php echo __('Global content'); ?></div>
            <?php echo link_tag($url, \thebuggenie\core\framework\Context::getModule('publish')->getMenuTitle(false)); ?>
            <?php $quicksearch_title = __('Find any article (press enter to search)'); ?>
            <div style="font-weight: normal; margin: 0 0 15px 5px;">
                <form action="<?php echo make_url('publish_find_articles'); ?>" method="get" accept-charset="<?php echo \thebuggenie\core\framework\Context::getI18n()->getCharset(); ?>">
                    <input type="search" name="articlename" placeholder="<?php echo $quicksearch_title; ?>">
                </form>
            </div>
            <?php if (count(\thebuggenie\core\entities\Project::getAll()) > (int) \thebuggenie\core\framework\Context::isProjectContext()): ?>
                <div class="header"><?php echo __('Project wikis'); ?></div>
                <?php foreach (\thebuggenie\core\entities\Project::getAll() as $project): ?>
                    <?php if (!$project->hasAccess() || (isset($project_url) && $project->getID() == \thebuggenie\core\framework\Context::getCurrentProject()->getID())) continue; ?>
                    <?php if (!$project->hasWikiURL()): ?>
                        <?php echo link_tag(make_url('publish_article', array('article_name' => ucfirst($project->getKey()).':MainPage')), $project->getName()); ?>
                    <?php else: ?>
                        <?php echo link_tag($project->getWikiURL(), $project->getName(), array('target' => 'blank')) ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        </li></ul>
    <?php endif; ?>
</li>
