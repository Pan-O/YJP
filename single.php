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
                <?php echo get_the_tag_list('<div class="tag-list"><i class="iconfont icon-tag"></i>','','</div>');?>
                <?php if ( yjp_option('post_like') == '1') { ?><div class="post-like"><a href="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>" class="specsZan <?php if(isset($_COOKIE['specs_zan_'.$post->ID])) echo 'done';?>"><i class="iconfont icon-heart-outline"></i><span class="count"> <?php if( get_post_meta($post->ID,'specs_zan',true) ){	echo get_post_meta($post->ID,'specs_zan',true); } else { echo '0'; }?></span></a></div><?php } ?>
                </div>
                <div class="author-field u-textAlignCenter">
                    <?php echo get_avatar(get_the_author_meta( 'user_email' ),64)?>
                    <h3><a href="<?php echo get_author_posts_url( get_the_author_meta('ID') );?>"><?php the_author();?></a></h3>
                    <p><?php echo yjp_option('home_description'); ?></p>
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