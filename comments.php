<?php
if ( post_password_required() )
    return;
?>

<div id="comments" class="comments-area">
    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <i class="iconfont icon-comments"></i><?php echo number_format_i18n( get_comments_number() );?> 条评论
        </h2>
        <div id="loading-comments"><div class="loading"><span></span><span></span><span></span><span></span><span></span></div></div>
        
        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
            'callback' => 'comment_format',
            ) );
            ?>
        </ol>
        <?php the_comments_pagination( array(
            'prev_text' => '上一页',
            'next_text' => '下一页',
            'prev_next' => false, 
        ) );?>
    <?php endif; ?> 
<?php if (yjp_option('comment_smile') == '1') { ?> <?php $smile = '<a class="comment-addsmilies" href="javascript:;"><i class="iconfont icon-smile"></i></a><span class="comment-form-smilies">' . alu_get_wpsmiliestrans() . '</span>'; ?><?php } ?>
<?php if (yjp_option('comment_img') == '1') { ?><?php $comment_img ='<a id="comment_add_img"><i class="iconfont icon-photo_upload"></i></a>'; ?><?php } ?>
<?php if (yjp_option('comment_private') == '1') { ?><?php $comment_private ='<span class="comment-span"><input type="checkbox" name="is-private" class="checkbox">私密评论</span>'; ?><?php } ?>
  <?php comment_form(array(  
    	 'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>'.$comment_private.' '.$comment_img.' '.$smile.'') ); ?>
    
    
    
</div>