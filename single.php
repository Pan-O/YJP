<?php get_header(); ?>
    <div class="content-area container">
        <div class="site-content">
            <?php while ( have_posts() ) : the_post(); ?>
                <section class="prev">
                    <div class="single-post-inner grap">
                        <?php the_content();?>
                    </div>
                </section>
                <div class="post-footer">
                  <?php if ( yjp_option('reward') == '1') { ?><div class="reward"><a><p>赏</p><span class="reward_content"><img src="<?php echo yjp_option('reward_img'); ?>" alt="打赏我！"></span></a></div><?php } ?>
                <?php echo get_the_tag_list('<div class="tag-list"><i class="iconfont icon-tag"></i>','','</div>');?>
                <?php if ( yjp_option('share') == '1') { ?><div class="share"><span class="share_show"><a href="http://connect.qq.com/widget/shareqq/index.html?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank"><i class="iconfont icon-QQ"></i></a><a href="http://service.weibo.com/share/share.php?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank"><i class="iconfont icon-weibo"></i></a> <span class="wechat_share"><a><i class="iconfont icon-wechat1"></i><div class="share_wechat_content"><span id="wechat_share_qrcode"></span>用微信扫一扫打开</div></a></span><a href="https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="iconfont icon-Facebook"></i></a><a href="https://twitter.com/intent/tweet?text=<?php the_title();?>&url=<?php the_permalink(); ?>" target="_blank"><i class="iconfont icon-twitter1"></i></a><a href="https://telegram.me/share/url?url=<?php the_permalink(); ?>&text=<?php the_title();?>" target="_blank"><i class="iconfont icon-telegram1"></i></a></span><span class="share_button"><i class="iconfont icon-share"></i></span></div><?php } ?>
                <?php if ( yjp_option('post_like') == '1') { ?><div class="post-like"><a href="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>" class="specsZan <?php if(isset($_COOKIE['specs_zan_'.$post->ID])) echo 'done';?>"><i class="iconfont icon-heart"></i><span class="count"> <?php if( get_post_meta($post->ID,'specs_zan',true) ){	echo get_post_meta($post->ID,'specs_zan',true); } else { echo '0'; }?></span></a></div><?php } ?>
                </div>
                <div class="author-field u-textAlignCenter">
                    <?php echo get_avatar(get_the_author_meta( 'user_email' ),64)?>
                    <h3><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') );?>"><?php the_author();?></a></h3>
                    <?php if ( yjp_option('hitokoto') == '0') : ?>
                    <p><?php echo yjp_option('home_description'); ?></p>
                    <?php elseif ( yjp_option('hitokoto') == '1') : ?>
                    <p id="hitokoto">:D 获取中...</p>
                    <?php endif; ?>
                </div>
                <?php if ( yjp_option('prev_next_post') == '1') { ?>
                <?php the_post_navigation( array(
                    'next_text' => '<span class="meta-nav">Next</span><span class="post-title">%title</span>',
                    'prev_text' => '<span class="meta-nav">Previous</span><span class="post-title">%title</span>',
                ) );?>
                <?php } ?>
                <?php comments_template(); ?>
            <?php endwhile; ?>
        </div>
    </div>
<?php get_footer(); ?>