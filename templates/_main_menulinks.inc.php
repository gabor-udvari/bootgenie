<div class="panel panel-default" id="<?php echo $target_type; ?>_<?php echo $target_id; ?>_container">
    <div class="panel-heading">
        <?php if ($tbg_user->canEditMainMenu() && ((\thebuggenie\core\framework\Context::isProjectContext() && !\thebuggenie\core\framework\Context::getCurrentProject()->isArchived()) || !\thebuggenie\core\framework\Context::isProjectContext())): ?>
            <a href="javascript:void(0);" class="dropper dynamic_menu_link">
                <?php echo image_tag('icon-mono-settings.png'); ?>
            </a>
            <ul class="more_actions_dropdown popup_box">
                <li><?php echo javascript_link_tag(__('Toggle menu edit mode'), array('onclick' => "TBG.Main.Menu.toggleEditMode('{$target_type}', '{$target_id}', '".make_url('save_menu_order', array('target_type' => $target_type, 'target_id' => $target_id))."');")); ?></li>
                <li><?php echo javascript_link_tag(__('Add menu item'), array('onclick' => "$('attach_link_{$target_type}_{$target_id}').toggle();")); ?></li>
            </ul>
        <?php endif; ?>
        <h3 class="panel-title"><?php echo $title; ?></h3>
    </div>

    <?php if ($tbg_user->canEditMainMenu() && ((\thebuggenie\core\framework\Context::isProjectContext() && !\thebuggenie\core\framework\Context::getCurrentProject()->isArchived()) || !\thebuggenie\core\framework\Context::isProjectContext())): ?>
        <div class="rounded_box white shadowed" id="attach_link_<?php echo $target_type; ?>_<?php echo $target_id; ?>" style="position: absolute; width: 300px; z-index: 10001; margin: -1px 0 5px 5px; display: none; top: 0; left: 305px;">
            <div class="header_div" style="margin: 0 0 5px 0;"><?php echo __('Add a link'); ?>:</div>
            <form action="<?php echo make_url('attach_link', array('target_type' => $target_type, 'target_id' => $target_id)); ?>" method="post" onsubmit="TBG.Main.Link.add('<?php echo make_url('attach_link', array('target_type' => $target_type, 'target_id' => $target_id)); ?>', '<?php echo $target_type; ?>', '<?php echo $target_id; ?>');return false;" id="attach_link_<?php echo $target_type; ?>_<?php echo $target_id; ?>_form">
                <label for="attach_link_<?php echo $target_type; ?>_<?php echo $target_id; ?>_url"><?php echo ($target_type == 'wiki') ? __('Article name') : __('URL'); ?>:</label>
                <input type="text" name="link_url" id="attach_link_<?php echo $target_type; ?>_<?php echo $target_id; ?>_url" style="width: 96%; margin-left: 3px;">
                <label for="attach_link_<?php echo $target_type; ?>_<?php echo $target_id; ?>_description"><?php echo __('Description'); ?>:</label>
                <input type="text" name="description" id="attach_link_<?php echo $target_type; ?>_<?php echo $target_id; ?>_description" style="width: 96%; margin-left: 3px;">
                <div style="font-size: 12px; padding: 15px 2px 10px 2px;" class="faded_out" id="attach_link_<?php echo $target_type; ?>_<?php echo $target_id; ?>_submit">
                    <?php if ($target_type == 'wiki'): ?>
                        <?php echo __('Enter the name of the article to link to here, along with an (optional) description, and press "%add_link" to add it to the menu.', array('%add_link' => __('Add link'))); ?><br /><br />
                    <?php else: ?>
                        <?php echo __('Enter the link URL here, along with an (optional) description, and press "%add_link" to add it to the menu.', array('%add_link' => __('Add link'))); ?><br /><br />
                    <?php endif; ?>
                    <?php echo __('To add free text, just enter text in the description - without any url - and press the "%add_link" button (Text will be parsed according to the %wiki_formatting).', array('%add_link' => __('Add link'), '%wiki_formatting' => link_tag(make_url('publish_article', array('article_name' => 'WikiFormatting')), 'WikiFormatting'))); ?><br /><br />
                    <?php echo __('To add a spacer, just press "%add_link", without any url or description.', array('%add_link' => __('Add link'))); ?>

                    <div style="text-align: right; margin-top: 10px; font-size: 1.1em;">
                        <?php echo image_tag('spinning_16.gif', array('id' => 'attach_link_'.$target_type.'_'.$target_id.'_indicator', 'style' => 'display: none; vertical-align: middle; margin-right: 5px;')); ?>
                        <?php echo __('%cancel or %attach_link', array('%attach_link' => '', '%cancel' => javascript_link_tag(__('cancel'), array('onclick' => "$('attach_link_{$target_type}_{$target_id}').toggle();")))); ?>
                        <input type="submit" value="<?php echo __('Add link'); ?>">
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!--
    <div class="panel-body">
    </div>
    -->

        <div class="list-group" id="<?php echo $target_type; ?>_<?php echo $target_id; ?>_links">
            <?php for ($i=0; $i<count($links); $i++):
                $link = $links[$i];
                if (isset($links[$i+1])) $linknext = $links[$i+1];
             ?>

                <?php // include_component('main/menulink', array('link_id' => $link['id'], 'link' => $link)); ?>
<!-- <li id="<?php echo $link['target_type']; ?>_<?php echo $link['target_id']; ?>_links_<?php echo $link['id']; ?>" class="list-group-item"> -->
    <?php if ($link['target_type'] == 'wiki' && $link['url'] != ''): ?>
        <?php if ($tbg_routing->getCurrentRouteModule() == 'publish' && $tbg_request['article_name'] == $link['url']): ?>
            <a href="<?php make_url('publish_article', array('article_name' => strip_tags($link['url']))); ?>" class="list-group-item active"><?php echo ($link['description'] != '') ? tbg_parse_text($link['description'], false, null, array('embedded' => true)) : strip_tags($link['url']); ?>
        <?php else: ?>
            <a href="<?php echo make_url('publish_article', array('article_name' => strip_tags($link['url']))); ?>" class="list-group-item"><?php echo ($link['description'] != '') ? tbg_parse_text($link['description'], false, null, array('embedded' => true)) : strip_tags($link['url']); ?>
        <?php endif; ?>
    <?php elseif (mb_substr($link['url'], 0, 1) == '@'): ?>
        <a href="<?php echo make_url($link['url']); ?>" class="list-group-item"><?php echo ($link['description'] != '') ? tbg_parse_text($link['description'], false, null, array('embedded' => true)) : strip_tags($link['url']); ?>
    <?php elseif ($link['url'] != ''): ?>
        <a href="<?php echo $link['url']; ?>" class="list-group-item"><?php echo ($link['description'] != '') ? tbg_parse_text($link['description'], false, null, array('embedded' => true)) : strip_tags($link['url']); ?>
    <?php else: ?>
        &nbsp;
    <?php endif; ?>

    <?php 
        // check next link for an empty description
        if ( empty($linknext['url']) && $linknext['description'] != '' ) :
            // print it out and skip in next cycle
            $i = $i+1;
     ?>
        <p><?php echo tbg_parse_text($linknext['description'], false, null, array('embedded' => true)); ?></p>
    <?php endif; ?>

    <?php
        // close the link if required
        if ( $link['url'] != '') :
    ?>
    </a>
    <?php endif; ?>

    <?php if ($tbg_user->canEditMainMenu()): ?>
        <?php // echo javascript_link_tag(image_tag('action_delete.png'), array('class' => 'delete-icon', 'style' => 'float: right;', 'onclick' => "TBG.Main.Helpers.Dialog.show('".__('Please confirm')."', '".__('Do you really want to delete this link?')."', {yes: {click: function() {TBG.Main.Link.remove('".make_url('remove_link', array('target_type' => $link['target_type'], 'target_id' => $link['target_id'], 'link_id' => $link_id))."', '{$link['target_type']}', '{$link['target_id']}', ".$link_id."); TBG.Main.Helpers.Dialog.dismiss(); }}, no: {click: TBG.Main.Helpers.Dialog.dismiss}})")); ?>
    <?php endif; ?>
<!-- </li> -->
<?php /* if ($tbg_user->canEditMainMenu()): ?>
    <tr id="<?php echo $link['target_type']; ?>_<?php echo $link['target_id']; ?>_links_<?php echo $link_id; ?>_remove_confirm" style="display: none;">
        <td colspan="2">
            <div class="rounded_box white shadowed" style="position: absolute; padding: 0 5px 5px 5px; font-size: 12px; width: 300px; z-index: 10001;">
                <div class="header_div" style="margin-top: 0;"><?php echo __('Are you sure?'); ?></div>
                <div class="content" style="padding: 3px;">
                    <?php echo __('Do you really want to remove this item from the menu?'); ?>
                    <div style="text-align: right;">
                        <?php echo javascript_link_tag(__('Yes'), array('onclick' => "$('{$link['target_type']}_{$link['target_id']}_links_{$link_id}_remove_confirm').toggle();TBG.Main.Link.remove('".make_url('remove_link', array('target_type' => $link['target_type'], 'target_id' => $link['target_id'], 'link_id' => $link_id))."', '{$link['target_type']}', '{$link['target_id']}', ".$link_id.");")); ?> ::
                        <?php echo javascript_link_tag('<b>'.__('No').'</b>', array('onclick' => "$('{$link['target_type']}_{$link['target_id']}_links_{$link_id}_remove_confirm').toggle();")); ?>
                    </div>
                </div>
            </div>
        </td>
    </tr>
<?php endif; */ ?>

            <?php endfor; ?>
        </div>

        <div style="padding-left: 5px;<?php if (count($links) > 0): ?> display: none;<?php endif; ?>" class="no_items" id="<?php echo $target_type; ?>_<?php echo $target_id; ?>_no_links"><?php echo __('There are no links in this menu'); ?></div>
        <div style="padding-left: 5px; text-align: center; display: none;" id="<?php echo $target_type; ?>_<?php echo $target_id; ?>_indicator"><?php echo image_tag('spinning_16.gif'); ?></div>
</div>
