<?php
use thebuggenie\core\framework;
$latest_articles = framework\Context::getModule('publish')->getLatestArticles(framework\Context::getCurrentProject());
?>

<div class="panel panel-default">
    <div class="panel-heading" onclick="$(this).up().toggleClassName('visible');">
        <h3 class="panel-title"><?php echo __('Recently edited pages here'); ?></h3>
    </div>
    <?php if (false): ?><div class="toggle_info"><?php echo __('Click the header to show / hide'); ?></div><?php endif; ?>
    <?php if (count($latest_articles)): ?>
        <div class="list-group">
            <?php foreach($latest_articles as $article): ?>
            <a href="<?php echo make_url('publish_article', array('article_name' => $article->getName())); ?>" class="list-group-item">
                    <div>
                        <?php echo image_tag('news_item_medium.png', array('style' => 'float: left;'), false, 'publish'); ?>
                        <?php echo get_spaced_name($article->getTitle()); ?>
                        <br>
                        <span><?php echo __('%time, by %user', array('%time' => tbg_formatTime($article->getPostedDate(), 3), '%user' => '<b>'.(($article->getAuthor() instanceof \thebuggenie\core\entities\common\Identifiable) ? '<a href="javascript:void(0);" onclick="TBG.Main.Helpers.Backdrop.show(\'' . make_url('get_partial_for_backdrop', array('key' => 'usercard', 'user_id' => $article->getAuthor()->getID())) . '\');">' . $article->getAuthor()->getName() . '</a>' : __('System')).'</b>')); ; ?></span>
                    </div>
            </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="panel-body no_items"><?php echo __('There are no recent pages here'); ?></div>
    <?php endif; ?>
</div>
