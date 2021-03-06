<?php \thebuggenie\core\framework\Event::createNew('core', 'before_header_userinfo')->trigger(); ?>
<ul id="user-menu">
    <li <?php if ($tbg_request->hasCookie('tbg3_original_username')): ?>class="temporarily_switched"<?php endif; ?> id="header_usermenu_link" class="dropdown">
        <?php if ($tbg_user->isGuest()): ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo image_tag($tbg_user->getAvatarURL(true), array('alt' => '[avatar]', 'class' => 'guest_avatar'), true) . __('You are not logged in'); ?> <span class="caret"></span></a>
        <?php else: ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo image_tag($tbg_user->getAvatarURL(true), array('alt' => '[avatar]', 'id' => 'header_avatar'), true) . '<span id="header_user_fullname">'.tbg_decodeUTF8($tbg_user->getDisplayName()).'</span>'; ?> <span class="caret"></span></a>
        <?php endif; ?>

        <?php if (\thebuggenie\core\framework\Event::createNew('core', 'header_usermenu_decider')->trigger()->getReturnValue() !== false): ?>

        <ul class="dropdown-menu">
            <?php if ($tbg_user->isGuest()): ?>
                <li>
                    <a href="/login"><?php echo image_tag('icon_login.png').__('Login'); ?></a>
                </li>
                <?php if (\thebuggenie\core\framework\Settings::isRegistrationAllowed()): ?>
                <li>
                    <a href="/login"><?php echo image_tag('icon_register.png').__('Register'); ?></a>
                </li>
                <?php endif; ?>
                <?php \thebuggenie\core\framework\Event::createNew('core', 'user_dropdown_anon')->trigger(); ?>
            <?php else: ?>
                <li>
                <div class="yamm-content" id="user_menu">
                    <div class="header" style="margin-bottom: 5px;">
                        <a href="javascript:void(0);" onclick="$('usermenu_changestate').toggle();" id="usermenu_changestate_toggler" class="button button-silver"><?php echo __('Change'); ?></a>
                        <?php echo image_tag('spinning_16.gif', array('style' => 'display: none;', 'id' => 'change_userstate_dropdown')); ?>
                        <?php echo __('You are: %userstate', array('%userstate' => '<span class="current_userstate userstate">'.__($tbg_user->getState()->getName()).'</span>')); ?>
                    </div>
                    <div id="usermenu_changestate" style="display: none;" onclick="$('usermenu_changestate').toggle();">
                        <?php foreach (\thebuggenie\core\entities\Userstate::getAll() as $state): ?>
                            <?php if ($state->getID() == \thebuggenie\core\framework\Settings::getOfflineState()->getID()) continue; ?>
                            <a href="javascript:void(0);" onclick="TBG.Main.Profile.setState('<?php echo make_url('set_state', array('state_id' => $state->getID())); ?>', 'change_userstate_dropdown');"><?php echo __($state->getName()); ?></a>
                        <?php endforeach; ?>
                    </div>
                    <ul>
                        <li><?php echo link_tag(make_url('dashboard'), image_tag('icon_dashboard_small.png').__('Your dashboard')); ?></li>
                    <?php if ($tbg_response->getPage() == 'dashboard'): ?>
                        <li><?php echo javascript_link_tag(image_tag('icon_dashboard_config.png').__('Customize your dashboard'), array('title' => __('Customize your dashboard'), 'onclick' => "$$('.dashboard').each(function (elm) { elm.toggleClassName('editable');});")); ?></li>
                    <?php endif; ?>
                        <li><?php echo link_tag(make_url('account'), image_tag('icon_account.png').__('Your account')); ?></li></li>
                    <?php if ($tbg_request->hasCookie('tbg3_original_username')): ?>
                        <div class="header"><?php echo __('You are temporarily this user'); ?></div>
                        <?php echo link_tag(make_url('switch_back_user'), image_tag('switchuser.png').__('Switch back to original user')); ?>
                    <?php endif; ?>
                    <?php if ($tbg_user->canAccessConfigurationPage()): ?>
                        <li><?php echo link_tag(make_url('configure'), image_tag('tab_config.png').__('Configure %thebuggenie_name', array('%thebuggenie_name' => \thebuggenie\core\framework\Settings::getSiteHeaderName()))); ?></li>
                    <?php endif; ?>
                    <?php \thebuggenie\core\framework\Event::createNew('core', 'user_dropdown_reg')->trigger(); ?>

                        <li><?php echo link_tag('http://www.thebuggenie.com/help/'.\thebuggenie\core\framework\Context::getRouting()->getCurrentRouteName(), image_tag('help.png').__('Help for this page'), array('id' => 'global_help_link')); ?></li>
                        <li><a href="<?php echo make_url('logout'); ?>" onclick="<?php if (\thebuggenie\core\framework\Settings::isPersonaAvailable()): ?>if (navigator.id) { navigator.id.logout();return false; }<?php endif; ?>"><?php echo image_tag('logout.png').__('Logout'); ?></a></li>
                    </ul>
                    <div class="header"><?php echo __('Your issues'); ?></div>
                    <ul>
                        <li><?php echo link_tag(make_url('my_reported_issues'), image_tag('icon_savedsearch.png') . __('Issues reported by me')); ?></li>
                        <li><?php echo link_tag(make_url('my_assigned_issues'), image_tag('icon_savedsearch.png') . __('Open issues assigned to me')); ?></li>
                        <li><?php echo link_tag(make_url('my_teams_assigned_issues'), image_tag('icon_savedsearch.png') . __('Open issues assigned to my teams')); ?></li>
                    </ul>
                </div><!-- /.yamm-content -->
                </li>
            <?php endif; ?>
            </ul><!-- /.dropdown-menu -->
        <?php endif; ?>
    </li><!-- /.dropdown -->
</ul> <!-- /.nav .navbar-right .yamm -->
<?php \thebuggenie\core\framework\Event::createNew('core', 'after_header_userinfo')->trigger(); ?>
