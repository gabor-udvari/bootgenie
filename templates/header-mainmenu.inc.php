<?php

use thebuggenie\core\framework;

?>
<ul id="main-menu">
    <?php if (!framework\Settings::isSingleProjectTracker() && !framework\Context::isProjectContext()): ?>
        <li <?php if ($tbg_response->getPage() == 'home'): ?>class="active"<?php endif; ?>>
            <?php echo link_tag(make_url('home'), image_tag('tab_index.png') . __('Frontpage')); ?>
        </li>
    <?php elseif (framework\Context::isProjectContext()): ?>
        <?php $page = (in_array($tbg_response->getPage(), array('project_dashboard', 'project_scrum_sprint_details', 'project_timeline', 'project_team', 'project_roadmap', 'project_statistics', 'vcs_commitspage'))) ? $tbg_response->getPage() : 'project_dashboard'; ?>
        <li class="dropdown <?php if (in_array($tbg_response->getPage(), array('project_dashboard', 'project_scrum_sprint_details', 'project_timeline', 'project_team', 'project_roadmap', 'project_statistics', 'vcs_commitspage'))): ?>active<?php endif; ?>">
            <a href="<?php echo make_url($page, array('project_key' => framework\Context::getCurrentProject()->getKey())); ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo image_tag('icon_dashboard_small.png') . tbg_get_pagename($tbg_response->getPage()); ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
            <li>
                <div id="project_information_menu">
                    <?php include_component('project/projectinfolinks', array('submenu' => true)); ?>
                </div>
            </li>
            </ul>
        </li>
    <?php endif; ?>

    <?php if (!$tbg_user->isThisGuest() && !framework\Settings::isSingleProjectTracker() && !framework\Context::isProjectContext()): ?>
        <li class="dropdown <?php echo ($tbg_response->getPage() == 'dashboard') ? 'active' : ''; ?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo image_tag('icon_dashboard_small.png') . __('Dashboard'); ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li>
                    <?php echo link_tag(make_url('dashboard'), __('My dashboard'), ((in_array($tbg_response->getPage(), array('dashboard'))) ? array('class' => 'selected') : array())); ?>
                </li>
            </ul><!-- /.dropdown-menu -->
        </li>
    <?php endif; ?>

    <?php if (framework\Context::isProjectContext() && $tbg_user->canSearchForIssues()): ?>
        <li class="dropdown <?php if (in_array($tbg_response->getPage(), array('project_issues', 'viewissue'))): ?>active<?php endif; ?>">
            <a href="<?php echo make_url('project_issues', array('project_key' => framework\Context::getCurrentProject()->getKey())); ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo image_tag('tab_search.png') . __('Issues'); ?><span class="caret"></span></a>
            <?php if (framework\Context::isProjectContext()): ?>
            <?php endif; ?>
            <ul class="dropdown-menu">
                <li><div>
                <?php echo link_tag(make_url('project_open_issues', array('project_key' => framework\Context::getCurrentProject()->getKey())), image_tag('icon_savedsearch.png') . __('Open issues for this project')); ?>
                <?php echo link_tag(make_url('project_closed_issues', array('project_key' => framework\Context::getCurrentProject()->getKey())), image_tag('icon_savedsearch.png') . __('Closed issues for this project')); ?>
                <?php echo link_tag(make_url('project_wishlist_issues', array('project_key' => framework\Context::getCurrentProject()->getKey())), image_tag('icon_savedsearch.png') . __('Wishlist for this project')); ?>
                <?php echo link_tag(make_url('project_milestone_todo_list', array('project_key' => framework\Context::getCurrentProject()->getKey())), image_tag('icon_savedsearch.png') . __('Milestone todo-list for this project')); ?>
                <?php echo link_tag(make_url('project_most_voted_issues', array('project_key' => framework\Context::getCurrentProject()->getKey())), image_tag('icon_savedsearch.png') . __('Most voted for issues')); ?>
                <?php echo link_tag(make_url('project_month_issues', array('project_key' => framework\Context::getCurrentProject()->getKey())), image_tag('icon_savedsearch.png') . __('Issues reported this month')); ?>
                <?php echo link_tag(make_url('project_last_issues', array('project_key' => framework\Context::getCurrentProject()->getKey(), 'units' => 30, 'time_unit' => 'days')), image_tag('icon_savedsearch.png') . __('Issues reported last 30 days')); ?>
                <h3><?php echo __('Recently watched issues'); ?></h3>
                <?php if (array_key_exists('viewissue_list', $_SESSION) && is_array($_SESSION['viewissue_list'])): ?>
                    <?php foreach ($_SESSION['viewissue_list'] as $k => $i_id): ?>
                        <?php
                        try
                        {
                            $an_issue = \thebuggenie\core\entities\tables\Issues::getTable()->getIssueById($i_id);
                            if (!$an_issue instanceof \thebuggenie\core\entities\Issue)
                            {
                                unset($_SESSION['viewissue_list'][$k]);
                                continue;
                            }
                        }
                        catch (\Exception $e)
                        {
                            unset($_SESSION['viewissue_list'][$k]);
                        }
                        echo link_tag(make_url('viewissue', array('project_key' => $an_issue->getProject()->getKey(), 'issue_no' => $an_issue->getFormattedIssueNo())), $an_issue->getFormattedTitle(true, false), array('title' => $an_issue->getFormattedTitle(true, true)));
                        ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (!isset($an_issue)): ?>
                    <a href="javascript:void(0);"><?php echo __('No recent issues'); ?></a>
                <?php endif; ?>
            </div></li>
            </ul>
        </li>
    <?php endif; ?>

    <?php if (!framework\Context::isProjectContext() && ($tbg_user->hasPageAccess('teamlist') || count($tbg_user->getTeams())) && !is_null(\thebuggenie\core\entities\tables\Teams::getTable()->getAll())): ?>
        <li class="dropdown <?php echo ($tbg_response->getPage() == 'team') ? 'active' : ''; ?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo image_tag('tab_teams.png') . __('Teams'); ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <?php foreach (\thebuggenie\core\entities\Team::getAll() as $team): ?>
                <?php if (!$team->hasAccess()) continue; ?>
                <li>
                    <a href="<?php echo make_url('team_dashboard', array('team_id' => $team->getID())); ?>"><?php echo image_tag('tab_teams.png') . $team->getName(); ?></a>
                </li>
                <?php endforeach; ?>
            </ul> <!-- /.dropdown-menu -->
        </li>
    <?php endif; ?>

    <?php if (!framework\Context::isProjectContext() && $tbg_user->hasPageAccess('clientlist') && count($tbg_user->getClients()) && !is_null(\thebuggenie\core\entities\Client::getAll())): ?>
        <li<?php if ($tbg_response->getPage() == 'client'): ?> class="active"<?php endif; ?>>
            <?php echo link_tag('javascript:void(0)', image_tag('tab_clients.png') . __('Clients'), array('class' => 'not_clickable')); ?>
            <div id="client_menu" class="tab_menu_dropdown yamm-content">
                <?php foreach (\thebuggenie\core\entities\Client::getAll() as $client): ?>
                    <?php if (!$client->hasAccess()) continue; ?>
                    <?php echo link_tag(make_url('client_dashboard', array('client_id' => $client->getID())), image_tag('tab_clients.png') . $client->getName()); ?>
                <?php endforeach; ?>
            </div>
        </li>
    <?php endif; ?>

    <?php framework\Event::createNew('core', 'templates/headermainmenu::projectmenulinks', framework\Context::getCurrentProject())->trigger(); ?>

    <?php if (framework\Context::isProjectContext() && !framework\Context::getCurrentProject()->isArchived() && !framework\Context::getCurrentProject()->isLocked() && ($tbg_user->canReportIssues() || $tbg_user->canReportIssues(framework\Context::getCurrentProject()->getID()))): ?>
        <li>
            <?php echo javascript_link_tag(image_tag('icon-mono-add.png') . __('Report an issue'), array('onclick' => "TBG.Main.Helpers.Backdrop.show('" . make_url('get_partial_for_backdrop', array('key' => 'reportissue', 'project_id' => framework\Context::getCurrentProject()->getId())) . "');", 'class' => 'button button-lightblue')); ?>
        </li>
    <?php endif; ?>
</ul>
