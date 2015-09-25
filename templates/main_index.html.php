<?php 

    $tbg_response->setTitle(__('Frontpage'));
    $tbg_response->addBreadcrumb(__('Frontpage'), make_url('home'), tbg_get_breadcrumblinks('main_links'));

?>
<?php if (isset($show_project_config_link) && $show_project_config_link && isset($show_project_list) && $show_project_list): ?>
    <?php if ($project_count == 1): ?>
        <?php include_component('main/hideableInfoBoxModal', array('key' => 'index_single_project_mode', 'title' => __('Only using The Bug Genie to track issues for one project?'), 'template' => 'main/intro_index_single_tracker')); ?>
    <?php elseif ($project_count == 0): ?>
        <?php include_component('main/hideableInfoBoxModal', array('key' => 'index_no_projects', 'title' => __('Get started using The Bug Genie'), 'template' => 'main/intro_index_no_projects')); ?>
    <?php endif; ?>
<?php endif; ?>

<div class="main-wrapper">
<aside class="sidebar">
        <?php include_component('main/menulinks', array('links' => $links, 'target_type' => 'main_menu', 'target_id' => 0, 'title' => __('Quick links'))); ?>
        <?php \thebuggenie\core\framework\Event::createNew('core', 'index_left')->trigger(); ?>
</aside>
<section class="main frontpage">
        <?php \thebuggenie\core\framework\Event::createNew('core', 'index_right_top')->trigger(); ?>
        <?php if (isset($show_project_list) && $show_project_list): ?>
            <div class="project_overview">
                <div class="header clearfix">
                    <?php echo __('Projects'); ?>
                    <div class="btn-group">
                        <button type="button" data-toggle="dropdown" aria-expanded="false" class="btn btn-default dropdown-toggle"><?php echo image_tag('icon-mono-settings.png'); ?><span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <?php if ($show_project_config_link): ?>
                                <li><?php echo link_tag(make_url('configure_projects'), __('Manage projects')); ?></li>
                            <?php endif; ?>
                            <li><a href="javascript:void(0);" onclick="TBG.Main.Helpers.Backdrop.show('<?php echo make_url('get_partial_for_backdrop', array('key' => 'archived_projects')); ?>');"><?php echo __('Show archived projects'); ?></a></li>
                        </ul>
                    </div>
                </div><!-- /.header -->

                <?php if ($project_count > 0): ?>
                    <ul class="project_list simple_list">
                    <?php foreach ($projects as $project): ?>
                        <li><?php include_component('project/overview', array('project' => $project)); ?></li>
                    <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="content">
                        <?php echo __('There are no top-level projects'); ?>.
                        <?php if ($show_project_config_link): ?>
                            <?php echo link_tag(make_url('configure_projects'), __('Go to project management').' &gt;&gt;'); ?>
                        <?php else: ?>
                            <?php echo __('Projects can only be created by an administrator'); ?>.
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php \thebuggenie\core\framework\Event::createNew('core', 'index_right_bottom')->trigger(); ?>
</section> <!-- /.main -->
</div> <!-- /.main-wrapper -->
