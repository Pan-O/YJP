<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link type="image/vnd.microsoft.icon" href="<?php echo yjp_option('favicon_img'); ?>" rel="shortcut icon">
    <meta name="Keywords" Content="<?php echo yjp_option('meta_keywords'); ?>">
    <meta name="Description" Content="<?php echo yjp_option('meta_description'); ?>">
    <?php wp_head(); ?>
    <style>
    .banner-mask{background-image: url(<?php echo yjp_option('home_banner'); ?>)}
.cute,.post-like,#submit:hover,#pagination a:hover,.mask-wrapper .post-title:hover,.comment .fn,.comment-form .required,.comment-at,.post-navigation .nav-next a:hover .post-title,.post-navigation .nav-previous a:hover .post-title ,.share_button i{color: <?php echo yjp_option('theme_color'); ?>}
#submit:hover {border-color: <?php echo yjp_option('theme_color'); ?>;}
.loading span,.nav-links .page-numbers.current,.nav-links .page-numbers:hover,.comment-body .reply .comment-reply-link,.checkbox::after,.comment-admin,.download_button,.searchform input[type=submit] {background-color: <?php echo yjp_option('theme_color'); ?>}
#pagination a:hover{border:2px solid <?php echo yjp_option('theme_color'); ?>;}
.searchform input[type=submit],.checkbox {border: 1px solid <?php echo yjp_option('theme_color'); ?>;}
</style>
</head>
<body <?php body_class(($_COOKIE['night'] == '1' ? 'night' : '') ); ?>">
<div id="page" class="hfeed site">
    <header id="header" class="home-header blog-background banner-mask">
        <div class="nav-header container">       
            <div class="nav-header-container">
                <?php wp_nav_menu( array( 'theme_location' => 'top' )); ?>
            </div>            
        </div>
        <div class="header-wrap">
            <div class="container">
                <?php if (is_singular()) :
                    global $post;
                    ?>
                    <div class="header-wrap">
                        <div class="post-info-container">
                            <h2 class="post-page-title "><?php the_title();?></h2>
                            <i class="iconfont icon-clock"></i><time class="post-page-time"><?php echo get_the_date('M d,Y');?></time><span class="middotDivider"></span>
                            <span class="post-page-author"><i class="iconfont icon-account"></i><a href="<?php echo get_author_posts_url($post->post_author);?>"><?php echo get_user_meta($post->post_author,'nickname',true);?></a></span>
                            <span class="middotDivider"></span><i class="iconfont icon-eye"></i><span class="post-page-views"><?php echo get_post_views(get_the_ID()); ?></span>
                        </div>
                    </div>
                <?php elseif (is_archive()) :
                    the_archive_title( '<h2 class="page-title">', '</h2>' );
                    the_archive_description( '<h4 class="taxonomy-description">', '</h4>' );

                elseif (is_404()) : ?>
                    <h2>404</h2>
                <?php elseif (is_search()) : ?>
                    <h2><?php echo get_search_query(); ?>的搜索结果</h2>
                <?php else : ?>
                <div class="home-info-container">
                    <a href="/">
                        <h2><?php echo yjp_option('web_name'); ?></h2>
                    </a>
                    <?php if ( yjp_option('hitokoto') == '0') : ?>
                    <h4><?php echo yjp_option('home_description'); ?></h4>
                    <?php elseif ( yjp_option('hitokoto') == '1') : ?>
                    <h4 id="hitokoto">:D 获取中...</h4>                <?php endif; ?>
                    <?php if ( yjp_option('blogger-link') == '1') { ?><div class="blogger_link"><?php if (yjp_option('qq_numaber')){ ?><a href="//wpa.qq.com/msgrd?v=3&uin=<?php echo yjp_option('qq_numaber'); ?>&site=qq&menu=yes" target="_blank"><i class="iconfont icon-QQ1"></i></a><?php } ?><?php if (yjp_option('netease_cloud_music_link')){ ?><a href="<?php echo yjp_option('netease_cloud_music_link'); ?>" target="_blank"><i class="iconfont icon-netease-cloud-music"></i></a><?php } ?><?php if (yjp_option('wechat_img')){ ?><span class="link_wechat"><a><i class="iconfont icon-wechat"></i><p class="link_wechat_content"><img src="<?php echo yjp_option('wechat_img'); ?>"></p></a></span><?php } ?><?php if (yjp_option('weibo_link')){ ?><a href="<?php echo yjp_option('weibo_link'); ?>" target="_blank"><i class="iconfont icon-weibo1"></i></a><?php } ?><?php if (yjp_option('coolapk_link')){ ?><a href="<?php echo yjp_option('coolapk_link'); ?>" target="_blank"><i class="iconfont icon-coolapk"></i></a><?php } ?><?php if (yjp_option('zhihu_link')){ ?><a href="<?php echo yjp_option('zhihu_link'); ?>" target="_blank"><i class="iconfont icon-zhihu"></i></a><?php } ?><?php if (yjp_option('bilibili_link')){ ?><a href="<?php echo yjp_option('bilibili_link'); ?>" target="_blank"><i class="iconfont icon-bilibili"></i></a><?php } ?><?php if (yjp_option('facebook_link')){ ?><a href="<?php echo yjp_option('facebook_link'); ?>" target="_blank"><i class="iconfont icon-facebook1"></i></a><?php } ?><?php if (yjp_option('twitter_link')){ ?><a href="<?php echo yjp_option('twitter_link'); ?>" target="_blank"><i class="iconfont icon-twitter"></i></a><?php } ?><?php if (yjp_option('telegram_link')){ ?><a href="<?php echo yjp_option('telegram_link'); ?>" target="_blank"><i class="iconfont icon-telegram"></i></a><?php } ?><?php if (yjp_option('link_email')){ ?><a href="mailto:<?php echo yjp_option('link_email'); ?>" target="_blank"><i class="iconfont icon-email"></i></a><?php } ?></div><?php } ?>
                </div>
            </div>
        </div>
        <?php endif;?>
    </header>
    <div id="main" class="content homepage">