<?php

    include_component('publish/wikibreadcrumbs', array('article_name' => $article_name));
    \thebuggenie\core\framework\Context::loadLibrary('publish/publish');
    $tbg_response->setTitle($article_name);
?>

<?php if ($article instanceof \thebuggenie\modules\publish\entities\Article): ?>
<aside class="sidebar <?php if ($article->getArticleType() == \thebuggenie\modules\publish\entities\Article::TYPE_MANUAL) echo 'manual'; ?>">
            <?php if ($article->getArticleType() == \thebuggenie\modules\publish\entities\Article::TYPE_MANUAL): ?>
                <?php include_component('manualsidebar', array('article' => $article)); ?>
            <?php else: ?>
                <?php include_component('leftmenu', array('article' => $article)); ?>
            <?php endif; ?>
</aside>

<section class="main article">
            <a name="top"></a>
            <?php if ($error): ?>
                <div class="redbox">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <?php if ($message): ?>
                <div class="greenbox" style="margin: 0 0 5px 5px; font-size: 14px;">
                    <b><?php echo $message; ?></b>
                </div>
            <?php endif; ?>
            <?php if (isset($revision) && !$error): ?>
                <div class="lightyellowbox" style="margin: 0 0 5px 5px; font-size: 14px;">
                    <?php echo __('You are now viewing a previous revision of this article - revision %revision_number %date, by %author', array('%revision_number' => '<b>'.$revision.'</b>', '%date' => '<span class="faded_out">[ '.tbg_formatTime($article->getPostedDate(), 20).' ]</span>', '%author' => (($article->getAuthor() instanceof \thebuggenie\core\entities\User) ? $article->getAuthor()->getName() : __('System')))); ?><br>
                    <b><?php echo link_tag(make_url('publish_article', array('article_name' => $article->getName())), __('Show current version')); ?></b>
                </div>
            <?php endif; ?>
            <?php if ($article->getID()): ?>
                <?php include_component('articledisplay', array('article' => $article, 'show_article' => true, 'redirected_from' => $redirected_from)); ?>
                <?php $article_name = $article->getName(); ?>
            <?php else: ?>
                <div class="article">
                    <?php include_component('publish/header', array('article' => $article, 'show_actions' => true, 'mode' => 'view')); ?>
                    <?php if (\thebuggenie\core\framework\Context::isProjectContext() && \thebuggenie\core\framework\Context::getCurrentProject()->isArchived()): ?>
                        <?php include_component('publish/placeholder', array('article_name' => $article_name, 'nocreate' => true)); ?>
                    <?php else: ?>
                        <?php include_component('publish/placeholder', array('article_name' => $article_name)); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if (!$article->getID() && ((\thebuggenie\core\framework\Context::isProjectContext() && !\thebuggenie\core\framework\Context::getCurrentProject()->isArchived()) || (!\thebuggenie\core\framework\Context::isProjectContext() && \thebuggenie\core\framework\Context::getModule('publish')->canUserEditArticle($article_name)))): ?>
                <div class="publish_article_actions">
                    <form action="<?php echo make_url('publish_article_edit', array('article_name' => $article_name)); ?>" method="get" style="float: left; margin-right: 10px;">
                        <input class="button button-green" type="submit" value="<?php echo __('Create this article'); ?>">
                    </form>
                </div>
            <?php endif; ?>
            <?php if ($article->getID()): ?>
                <?php $attachments = $article->getFiles(); ?>
                <div id="article_attachments">
                    <?php /*if (\thebuggenie\core\framework\Settings::isUploadsEnabled() && $article->canEdit()): ?>
                        <?php include_component('main/uploader', array('article' => $article, 'mode' => 'article')); ?>
                    <?php endif;*/ ?>
                    <h4>
                        <?php echo __('Article attachments'); ?>
                        <?php if (\thebuggenie\core\framework\Settings::isUploadsEnabled() && $article->canEdit()): ?>
                            <button class="button button-silver" onclick="TBG.Main.showUploader('<?php echo make_url('get_partial_for_backdrop', array('key' => 'uploader', 'mode' => 'article', 'article_name' => $article_name)); ?>');"><?php echo __('Attach a file'); ?></button>
                        <?php else: ?>
                            <button class="button button-silver disabled" onclick="TBG.Main.Helpers.Message.error('<?php echo __('File uploads are not enabled'); ?>');"><?php echo __('Attach a file'); ?></button>
                        <?php endif; ?>
                    </h4>
                    <?php include_component('publish/attachments', array('article' => $article, 'attachments' => $attachments)); ?>
                </div>
                <div id="article_comments">
                    <h4>
                        <?php echo __('Article comments (%count)', array('%count' => \thebuggenie\core\entities\Comment::countComments($article->getID(), \thebuggenie\core\entities\Comment::TYPE_ARTICLE))); ?>
                        <?php if ($tbg_user->canPostComments() && ((\thebuggenie\core\framework\Context::isProjectContext() && !\thebuggenie\core\framework\Context::getCurrentProject()->isArchived()) || !\thebuggenie\core\framework\Context::isProjectContext())): ?>
                            <button id="comment_add_button" class="button button-silver" onclick="TBG.Main.Comment.showPost();"><?php echo __('Post comment'); ?></button>
                        <?php endif; ?>
                    </h4>
                    <?php include_component('main/comments', array('target_id' => $article->getID(), 'mentionable_target_type' => 'article', 'target_type' => \thebuggenie\core\entities\Comment::TYPE_ARTICLE, 'show_button' => false, 'comment_count_div' => 'article_comment_count', 'forward_url' => make_url('publish_article', array('article_name' => $article->getName())))); ?>
                </div>
            <?php endif; ?>
</section> <!-- /.main -->

<?php else: ?>
<section class="main-fullwidth">
    <div class="alert alert-danger" id="notfound_error">
        <h3><?php echo __("This article can not be displayed"); ?></h3>
        <p><?php echo __("This article either does not exist, has been deleted or you do not have permission to view it."); ?></p>
    </div>
</section>
<?php endif; ?>
