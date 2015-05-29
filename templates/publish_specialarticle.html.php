<?php

    include_component('publish/wikibreadcrumbs', array('article_name' => $article_name));
    \thebuggenie\core\framework\Context::loadLibrary('publish/publish');
    $tbg_response->setTitle($article_name);

?>

<div class="main-wrapper">
<aside class="sidebar">
    <?php include_component('leftmenu', compact('article', 'special')); ?>
</aside>

<section class="main article">
    <a name="top"></a>
    <?php if ($component): ?>
        <?php include_component("publish/special{$component}", compact('projectnamespace')); ?>
    <?php else: ?>
        <div class="redbox" style="margin: 15px;">
            <?php echo __('This special page does not exist'); ?>
        </div>
    <?php endif; ?>
</section>
