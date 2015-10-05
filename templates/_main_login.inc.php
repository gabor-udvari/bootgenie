<?php /* \thebuggenie\core\framework\Event::createNew('core', 'login_form_tab')->trigger(array('selected_tab' => $selected_tab)); */ ?>
<script type="text/javascript">
    require(['domReady', 'prototype'], function (domReady, prototype) {
        domReady(function () {
            if (document.location.href.search('<?php echo make_url('login_page'); ?>') != -1)
                if ($('tbg3_referer')) $('tbg3_referer').setValue('<?php echo make_url('dashboard'); ?>');
                else if ($('return_to')) $('return_to').setValue('<?php echo make_url('dashboard'); ?>');
        });
    });

</script>

<div id="regular_login_container">

    <?php if ($loginintro instanceof \thebuggenie\modules\publish\entities\Article): ?>
        <?php include_component('publish/articledisplay', array('article' => $loginintro, 'show_title' => false, 'show_details' => false, 'show_actions' => false, 'embedded' => true)); ?>
    <?php endif; ?>

    <h2><?php echo __('Log in with your username and password'); ?></h2>
    <form accept-charset="<?php echo \thebuggenie\core\framework\Context::getI18n()->getCharset(); ?>" action="<?php echo make_url('login'); ?>" method="post" id="login_form" onsubmit="TBG.Main.Login.login('<?php echo make_url('login'); ?>'); return false;">
        <?php if (!\thebuggenie\core\framework\Context::hasMessage('login_force_redirect') || \thebuggenie\core\framework\Context::getMessage('login_force_redirect') !== true): ?>
            <input type="hidden" id="tbg3_referer" name="tbg3_referer" value="<?php echo $referer; ?>" />
        <?php else: ?>
            <input type="hidden" id="return_to" name="return_to" value="<?php echo $referer; ?>" />
        <?php endif; ?>
        <div class="form-group">
            <label for="tbg3_username"><?php echo __('Username'); ?></label>
            <div class="control-wrapper">
                <input type="text" id="tbg3_username" name="tbg3_username">
            </div>
        </div>
        <div class="form-group">
            <label for="tbg3_password"><?php echo __('Password'); ?></label>
            <div class="control-wrapper">
                <input type="password" id="tbg3_password" name="tbg3_password">
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox-wrapper">
                <div class="checkbox">
                    <label for="tbg3_rememberme"><input type="checkbox" name="tbg3_rememberme" value="1" id="tbg3_rememberme"><?php echo __('Keep me logged in'); ?></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="button-wrapper">
                <?php \thebuggenie\core\framework\Event::createNew('core', 'login_button_container')->trigger(); ?>
                <button type="submit" id="login_button" class="btn btn-default"><?php echo __('Log in'); ?></button>
            </div>
        </div>
    </form>

   <div class="section-separator">
      <span><?php echo __('%regular_login or %persona_or_openid_login', array('%regular_login' => '', '%persona_or_openid_login' => '')); ?></span>
   </div>

    <?php if (\thebuggenie\core\framework\Settings::isPersonaAvailable() || \thebuggenie\core\framework\Settings::isOpenIDavailable()): ?>
    <div style="text-align: center">
        <?php if (\thebuggenie\core\framework\Settings::isPersonaAvailable()): ?>
            <a class="persona-button" id="persona-signin-button" href="#"><span><?php echo __('Sign in with Persona'); ?></span></a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

   <div class="section-separator">
      <span><?php echo __('%regular_login or %persona_or_openid_login', array('%regular_login' => '', '%persona_or_openid_login' => '')); ?></span>
   </div>

    <?php if (\thebuggenie\core\framework\Settings::isOpenIDavailable()): ?>
        <?php include_component('main/openidbuttons'); ?>
    <?php endif; ?>

</div>

<?php \thebuggenie\core\framework\Event::createNew('core', 'login_form_pane')->trigger(array_merge(array('selected_tab' => $selected_tab), $options)); ?>
<?php if (\thebuggenie\core\framework\Settings::isRegistrationAllowed()): ?>
    <?php include_component('main/loginregister', compact('registrationintro')); ?>
<?php endif; ?>

<?php if (isset($error)): ?>
    <script type="text/javascript">
        require(['domReady', 'thebuggenie/tbg'], function (domReady, TBG) {
            domReady(function () {
                TBG.Main.Helpers.Message.error('<?php echo $error; ?>');
            });
        });
    </script>
<?php endif; ?>
