<?php if ($tbg_user->hasProjectPageAccess('project_planning', $project)): ?>
    <li class="dropdown <?php if (in_array($tbg_response->getPage(), array('project_planning', 'agile_board', 'agile_whiteboard'))): ?>active<?php endif; ?>">
        <a href="<?php make_url('agile_index', array('project_key' => $project->getKey())); ?>" class="dropdown-toggle" data-toggle="dropdown">
            <?php echo image_tag('icon_agile.png') . __('Agile'); ?><span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
        <li><div>
            <?php echo link_tag(make_url('agile_index', array('project_key' => $project->getKey())), __('Manage boards'), ((in_array($tbg_response->getPage(), array('project_planning'))) ? array('class' => 'selected') : array())); ?>
            <h3><?php echo __('Project boards'); ?></h3>
            <?php if (count($boards)): ?>
                <?php foreach ($boards as $board): ?>
                    <a href="<?php echo make_url('agile_board', array('project_key' => $board->getProject()->getKey(), 'board_id' => $board->getID())); ?>" class="<?php if ($tbg_request['board_id'] == $board->getID()) echo ' selected'; ?>"><?php echo $board->getName(); ?></a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="disabled"><?php echo __('No project boards available'); ?></div>
            <?php endif; ?>
        </div></li>
        </ul>
    </li>
<?php endif; ?>
