<?php

    $article_name = ($article instanceof \thebuggenie\modules\publish\entities\Article) ? $article->getName() : $article;

?>
<div class="panel panel-default toggled<?php if (isset($special) && $special) echo ' visible'; ?>">
    <div class="panel-heading header" onclick="$(this).up().toggleClassName('visible');">
        <h3 class="panel-title"><?php echo __('Wiki tools'); ?></h3>
    </div>
    <?php if(false): ?><div class="toggle_info"><?php echo __('Click the header to show / hide'); ?></div><?php endif; ?>
    <div class="list-group">
        <?php if (!isset($special) || !$special): ?>
            <a href="<?php echo make_url('publish_special_whatlinkshere', array('linked_article_name' => $article_name)); ?>" class="list-group-item">
                <?php echo image_tag('news_item.png', array('style' => 'float: left;'), false, 'publish'); ?>
                <?php echo __('What links here'); ?>
            </a>
        <?php endif; ?>
        <?php if (\thebuggenie\core\framework\Context::isProjectContext()): ?>
            <a href="<?php make_url('publish_article', array('article_name' => 'Special:'.ucfirst(mb_strtolower(\thebuggenie\core\framework\Context::getCurrentProject()->getKey())).':SpecialPages')); ?>" class="list-group-item">
                <?php echo image_tag('news_item.png', array('style' => 'float: left;'), false, 'publish'); ?>
                <?php echo __('Project special pages'); ?>
            </a>
        <?php endif; ?>
        <a href="<?php echo make_url('publish_article', array('article_name' => 'Special:SpecialPages')); ?>" class="list-group-item">
            <?php echo image_tag('news_item.png', array('style' => 'float: left;'), false, 'publish'); ?>
            <?php echo __('Special pages'); ?>
        </a>
    </div>
</div> <!-- /.panel -->
