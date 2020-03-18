<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {
	// Change this to use your theme slug
	$option_name = get_option( 'stylesheet' );
    $option_name = preg_replace( "/\W/", "_", strtolower( $option_name ) );
    return $option_name;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'theme-textdomain'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __( 'One', 'theme-textdomain' ),
		'two' => __( 'Two', 'theme-textdomain' ),
		'three' => __( 'Three', 'theme-textdomain' ),
		'four' => __( 'Four', 'theme-textdomain' ),
		'five' => __( 'Five', 'theme-textdomain' )
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __( 'French Toast', 'theme-textdomain' ),
		'two' => __( 'Pancake', 'theme-textdomain' ),
		'three' => __( 'Omelette', 'theme-textdomain' ),
		'four' => __( 'Crepe', 'theme-textdomain' ),
		'five' => __( 'Waffle', 'theme-textdomain' )
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

	$options[] = array(
		'name' => __( '基本设置', 'theme-textdomain' ),
		'type' => 'heading'
	);

	$options[] = array(
		'name' => __( '网站名称', 'theme-textdomain' ),
		'desc' => __( '填写你的站点名称', 'theme-textdomain' ),
		'id' => 'web_name',
		'type' => 'text'
	);

    $options[] = array(
		'name' => __('favicon', 'theme-textdomain'),
		'desc' => __('注意图片大小', 'theme-textdomain'),
		'id' => 'favicon_img',
		'type' => 'upload'
	);
	
	$options[] = array(
        'name' => __("主题颜色", 'theme-textdomain'),
        'desc' => __('自定义主题颜色', 'theme-textdomain'),
        'id' => 'theme_color',
        'std' => "#FFFFFF",
        'type' => "color"
    );

    $options[] = array(
		'name' => __('网站关键词', 'theme-textdomain'),
		'desc' => __('关键字之间用","分割', 'theme-textdomain'),
		'id' => 'meta_keywords',
		'type' => 'text'
	);
    
    $options[] = array(
		'name' => __('网站描述', 'theme-textdomain'),
		'desc' => __('字数建议在150个字以内', 'theme-textdomain'),
		'id' => 'meta_description',
		'type' => 'textarea'
	);
	
	$options[] = array(
		'name' => __('首页大图', 'theme-textdomain'),
		'desc' => __('填写图片直链', 'theme-textdomain'),
		'id' => 'home_banner',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => __('博主个性签名', 'theme-textdomain'),
		'desc' => __('字数建议在15个字以内，会在首页及文章作者卡片处显示', 'theme-textdomain'),
		'id' => 'home_description',
		'type' => 'text'
	);
	
	$options[] = array(
        'name' => __('使用一言', 'theme-textdomain'),
        'desc' => __('默认关闭，勾选开启，使用<a href="https://hitokoto.cn/">一言</a>代替博主个性签名', 'theme-textdomain'),
        'id' => 'hitokoto',
        'std' => '0',
        'type' => 'checkbox'
    );
    
    $options[] = array(
		'name' => __('自定义底部文字', 'theme-textdomain'),
		'desc' => __('例如备案号，又拍云••••••', 'theme-textdomain'),
		'id' => 'footer_main', 
		'type' => 'textarea'
	);
    
    	$options[] = array(
		'name' => __( '文章设置', 'theme-textdomain' ),
		'type' => 'heading'
	);
	
    $options[] = array(
        'name' => __('显示上下篇文章', 'theme-textdomain'),
        'desc' => __('默认关闭，勾选开启', 'theme-textdomain'),
        'id' => 'prev_next_post',
        'std' => '0',
        'type' => 'checkbox'
    );

    $options[] = array(
        'name' => __('点赞功能', 'theme-textdomain'),
        'desc' => __('默认关闭，勾选开启', 'theme-textdomain'),
        'id' => 'post_like',
        'std' => '0',
        'type' => 'checkbox'
    );
    
    $options[] = array(
        'name' => __('分享功能', 'theme-textdomain'),
        'desc' => __('默认关闭，勾选开启', 'theme-textdomain'),
        'id' => 'share',
        'std' => '0',
        'type' => 'checkbox'
    );
    
     $options[] = array(
        'name' => __('打赏功能', 'theme-textdomain'),
        'desc' => __('默认关闭，勾选开启', 'theme-textdomain'),
        'id' => 'reward',
        'std' => '0',
        'type' => 'checkbox'
    );
    
    $options[] = array(
		'name' => __('打赏二维码', 'theme-textdomain'),
		'desc' => __('注意图片大小', 'theme-textdomain'),
		'id' => 'reward_img',
		'type' => 'upload'
	);
    
    $options[] = array(
		'name' => __( '社交', 'theme-textdomain' ),
		'type' => 'heading'
	);
	
	 $options[] = array(
        'name' => __('个人链接', 'theme-textdomain'),
        'desc' => __('默认关闭，勾选开启，会在首页显示你所添加的链接', 'theme-textdomain'),
        'id' => 'blogger-link',
        'std' => '0',
        'type' => 'checkbox'
    );
	
	$options[] = array(
	'name' => __('微信', 'theme-textdomain'),
	'desc' => __('上传微信二维码，注意图片大小', 'theme-textdomain'),
	'id' => 'wechat_img',
	'type' => 'upload'
	);

	
	$options[] = array(
		'name' => __('微博', 'theme-textdomain'),
		'desc' => __('填写你的新浪微博地址', 'theme-textdomain'),
		'id' => 'weibo_link',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => __('bilibili', 'theme-textdomain'),
		'desc' => __('填写你的bilibili地址', 'theme-textdomain'),
		'id' => 'bilibili_link',
		'type' => 'text'
	);
    
	$options[] = array(
		'name' => __('Facebook', 'theme-textdomain'),
		'desc' => __('填写你的Facebook地址', 'theme-textdomain'),
		'id' => 'facebook_link',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => __('网易云音乐', 'theme-textdomain'),
		'desc' => __('填写你的网易云音乐地址', 'theme-textdomain'),
		'id' => 'netease_cloud_music_link',
		'type' => 'text'
	);
	
    $options[] = array(
		'name' => __('知乎', 'theme-textdomain'),
		'desc' => __('填写你的知乎地址', 'theme-textdomain'),
		'id' => 'zhihu_link',
		'type' => 'text'
	);
	
	 $options[] = array(
		'name' => __('酷安', 'theme-textdomain'),
		'desc' => __('填写你的酷安地址', 'theme-textdomain'),
		'id' => 'coolapk_link',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => __('qq', 'theme-textdomain'),
		'desc' => __('填写你的qq账号', 'theme-textdomain'),
		'id' => 'qq_numaber',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => __('twitter', 'theme-textdomain'),
		'desc' => __('填写你的twitter地址', 'theme-textdomain'),
		'id' => 'twitter_link',
		'type' => 'text'
	);
	
	$options[] = array(
		'name' => __('telegram', 'theme-textdomain'),
		'desc' => __('填写你的telegram地址', 'theme-textdomain'),
		'id' => 'telegram_link',
		'type' => 'text'
	);
	
    	$options[] = array(
		'name' => __( '其他设置', 'theme-textdomain' ),
		'type' => 'heading'
	);
	
	$options[] = array(
		'name' => __('邮箱地址前缀', 'theme-textdomain'),
		'desc' => __('用于发送系统邮件，在用户的邮箱中显示的发件人地址，默认为email', 'theme-textdomain'),
		'id' => 'mail_name',
		'type' => 'text'
	);
	
	$options[] = array(
        'name' => __('网站运行时间', 'theme-textdomain'),
        'desc' => __('默认关闭，勾选开启，在网站底部显示网站运行时间', 'theme-textdomain'),
        'id' => 'web_run_time',
        'std' => '0',
        'type' => 'checkbox'
    );
    
    	$options[] = array(
		'name' => __('网站运行时间', 'theme-textdomain'),
		'desc' => __('填写建站时间，格式“年-月-日”', 'theme-textdomain'),
		'id' => 'build_time',
		'type' => 'text'
	);
	
		$options[] = array(
        'name' => __('评论表情', 'theme-textdomain'),
        'desc' => __('默认关闭，勾选开启', 'theme-textdomain'),
        'id' => 'comment_smile',
        'std' => '0',
        'type' => 'checkbox'
    );
	return $options;
}