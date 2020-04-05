<?php
//禁止自动更新
add_filter('automatic_updater_disabled', '__return_true');	// 彻底关闭自动更新

remove_action('init', 'wp_schedule_update_checks');	// 关闭更新检查定时作业
wp_clear_scheduled_hook('wp_version_check');			// 移除已有的版本检查定时作业
wp_clear_scheduled_hook('wp_update_plugins');		// 移除已有的插件更新定时作业
wp_clear_scheduled_hook('wp_update_themes');			// 移除已有的主题更新定时作业
wp_clear_scheduled_hook('wp_maybe_auto_update');		// 移除已有的自动更新定时作业

remove_action( 'admin_init', '_maybe_update_core' );		// 移除后台内核更新检查

remove_action( 'load-plugins.php', 'wp_update_plugins' );	// 移除后台插件更新检查
remove_action( 'load-update.php', 'wp_update_plugins' );
remove_action( 'load-update-core.php', 'wp_update_plugins' );
remove_action( 'admin_init', '_maybe_update_plugins' );

remove_action( 'load-themes.php', 'wp_update_themes' );		// 移除后台主题更新检查
remove_action( 'load-update.php', 'wp_update_themes' );
remove_action( 'load-update-core.php', 'wp_update_themes' );
remove_action( 'admin_init', '_maybe_update_themes' );
//引入主题设置
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
require_once dirname( __FILE__ ) . '/inc/options-framework.php';
//评论图片转换
define('ALLOW_POSTS', '');
function fa_comment_image( $comment ) {
    $post_ID = $comment["comment_post_ID"];
    $allow_posts = ALLOW_POSTS ? explode(',', ALLOW_POSTS) : array();
    if(in_array($post_ID,$allow_posts) || empty($allow_posts) ){
        global $allowedtags;
        $content = $comment["comment_content"];
        $content = preg_replace('/(https?:\/\/\S+\.(?:jpg|png|jpeg|gif))+/','<img src="$0" alt="" />',$content);
        $allowedtags['img'] = array('src' => array (), 'alt' => array ());
        $comment["comment_content"] = $content;
    }
    return $comment;
}
add_filter('preprocess_comment', 'fa_comment_image');
// 去除WP版本号
function remove_wp_version(){
  return '';
}
add_filter('the_generator', 'remove_wp_version');
function remove_wpversion($src){
global $wp_version;
 parse_str(parse_url($src, PHP_URL_QUERY), $query);
 if ( !empty($query['ver']) && $query['ver'] === $wp_version ) {
$src = str_replace($wp_version, 1.5, $src);
  }
 return $src;
}
add_filter('script_loader_src', 'remove_wpversion');
add_filter('style_loader_src', 'remove_wpversion');
//私密评论
function fa_private_message_hook( $comment_content , $comment){
    $comment_ID = $comment->comment_ID;
    $parent_ID = $comment->comment_parent;
    $parent_email = get_comment_author_email($parent_ID);
    $is_private = get_comment_meta($comment_ID,'_private',true);
    $email = $comment->comment_author_email;
    $current_commenter = wp_get_current_commenter();
    if ( $is_private ) $comment_content = '#私密# ' . $comment_content;
    if ( $current_commenter['comment_author_email'] == $email || $parent_email == $current_commenter['comment_author_email'] || current_user_can('delete_user') ) return $comment_content;
    if ( $is_private ) return '该评论为私密评论';
    return $comment_content;
}


if ( yjp_option('comment_private') == '1' && is_singular() ) {
add_filter('get_comment_text','fa_private_message_hook',10,2);
}
function fa_mark_private_message( $comment_id ){
    if ( $_POST['is-private'] ) {
        update_comment_meta($comment_id,'_private','true');
    }
}
add_action('comment_post', 'fa_mark_private_message');
//表情（来自wp-alu插件）
add_filter('smilies_src', 'alu_smilies_src', 1, 10); 
function alu_smilies_src($img_src, $img, $siteurl) {
    $img = rtrim($img, "gif");
    return get_template_directory_uri() .'/build/img/alu/' . $img . 'gif';
}
function alu_get_wpsmiliestrans() {
    global $wpsmiliestrans;
    $wpsmilies = array_unique($wpsmiliestrans);
    $output = '';
    foreach ($wpsmilies as $alt => $src_path) {
        //$emoji = str_replace(array('&#x', ';'), '', wp_encode_emoji($src_path));
        $output .= '<a class="add-smily" data-action="addSmily" data-smilies="' . $alt . '"><img class="wp-smiley" src="'. get_template_directory_uri() .'/build/img/alu/' . $src_path .'" /></a>';
    }
    return $output;
}
function alu_smilies_reset() {
    global $wpsmiliestrans, $wp_smiliessearch;
// don't bother setting up smilies if they are disabled
    if ( !get_option( 'use_smilies' ) )
        return;
    $wpsmiliestrans = array(
        ':mrgreen:' => 'icon_mrgreen.gif',
        ':neutral:' => 'icon_neutral.gif',
        ':twisted:' => 'icon_twisted.gif',
        ':arrow:' => 'icon_arrow.gif',
        ':shock:' => 'icon_eek.gif',
        ':smile:' => 'icon_smile.gif',
        ':???:' => 'icon_confused.gif',
        ':cool:' => 'icon_cool.gif',
        ':evil:' => 'icon_evil.gif',
        ':grin:' => 'icon_biggrin.gif',
        ':idea:' => 'icon_idea.gif',
        ':oops:' => 'icon_redface.gif',
        ':razz:' => 'icon_razz.gif',
        ':roll:' => 'icon_rolleyes.gif',
        ':wink:' => 'icon_wink.gif',
        ':cry:' => 'icon_cry.gif',
        ':eek:' => 'icon_surprised.gif',
        ':lol:' => 'icon_lol.gif',
        ':mad:' => 'icon_mad.gif',
        ':sad:' => 'icon_sad.gif',
        '8-)' => 'icon_cool.gif',
        '8-O' => 'icon_eek.gif',
        ':-(' => 'icon_sad.gif',
        ':-)' => 'icon_smile.gif',
        ':-?' => 'icon_confused.gif',
        ':-D' => 'icon_biggrin.gif',
        ':-P' => 'icon_razz.gif',
        ':-o' => 'icon_surprised.gif',
        ':-x' => 'icon_mad.gif',
        ':-|' => 'icon_neutral.gif',
        ';-)' => 'icon_wink.gif',
        // This one transformation breaks regular text with frequency.
        //     '8)' => 'icon_cool.gif',
        '8O' => 'icon_eek.gif',
        ':(' => 'icon_sad.gif',
        ':)' => 'icon_smile.gif',
        ':?' => 'icon_confused.gif',
        ':D' => 'icon_biggrin.gif',
        ':P' => 'icon_razz.gif',
        ':o' => 'icon_surprised.gif',
        ':x' => 'icon_mad.gif',
        ':|' => 'icon_neutral.gif',
        ';)' => 'icon_wink.gif',
        ':!:' => 'icon_exclaim.gif',
        ':?:' => 'icon_question.gif',
    );
}
add_action('init','alu_smilies_reset');
//链接卡片
function linkcard($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>'网站标题',"link"=>''),$atts));
    $return = '<div class="link_card"><a class="link_card_main" href="'.$link.'" ref="nofollow" target="_blank"><span class="link_card_name">'.$title.'</span><span class="link_card_p">';
    $return .= $content;
    $return .= '</span><span class="link_card_i" title="前往链接"><i class="iconfont icon-chevron_right"></i></span></a></div>';
    return $return;
}
add_shortcode('link','linkcard');
//下载按钮
function download_button($atts,$content=null,$code=""){
    extract(shortcode_atts(array(),$atts));
    $return .= '<span class="download_button"><a href="'.$content.'">';
    $return .= '<i class="iconfont icon-download"></i>Download';
    $return .= '</a></span>';
    return $return;
}
add_shortcode('download','download_button');
//代码高亮
function highlight_code($atts,$content=null,$code=""){
    extract(shortcode_atts(array(),$atts));
    $return .= '<pre><code>';
    $return .= $content;
    $return .= '</code></pre>';
    return $return;
}
add_shortcode('code','highlight_code');
//浏览次数
function restyle_text($number)
{
    if ($number >= 1000) {
        return round($number / 1000, 2) . 'k';
    } else {
        return $number;
    }
}
function set_post_views()
{
    global $post;
    $post_id = intval($post->ID);
    $count_key = 'views';
    $views = get_post_custom($post_id);
    $views = intval($views['views'][0]);
    if (is_single() || is_page()) {
        if (!update_post_meta($post_id, 'views', ($views + 1))) {
            add_post_meta($post_id, 'views', 1, true);
        }
    }
}
add_action('get_header', 'set_post_views');
function get_post_views($post_id)
{
    $count_key = 'views';
    $views = get_post_custom($post_id);
    $views = intval($views['views'][0]);
    $post_views = intval(post_custom('views'));
    if ($views == '') {
        return 0;
    } else {
        return restyle_text($views);
    }
}
//评论回复邮件通知
function fanly_comment_mail_notify($comment_id) {
$mail_name = yjp_option('mail_name'); 
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	$comment = get_comment($comment_id);
	$parent_id = $comment->comment_parent ? $comment->comment_parent : '';
	$spam_confirmed = $comment->comment_approved;
	if (($parent_id != '') && ($spam_confirmed != 'spam')) {
		$wp_email = $mail_name . '@' . 'email.' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
		$to = trim(get_comment($parent_id)->comment_author_email);
		$subject = trim(get_comment($parent_id)->comment_author) . ',您在 [' . $blogname . '] 中的留言有新的回复啦！';
		$message = '<div style="color:#555;font:12px/1.5 微软雅黑,Tahoma,Helvetica,Arial,sans-serif;max-width:550px;margin:50px auto;border-top: none;" ><table border="0" cellspacing="0" cellpadding="0"><tbody><tr valign="top" height="2"><td valign="top"><div style="background-color:white;max-width:550px;color:#555555;font-family:微软雅黑, Arial;font-size:12px;border: 1px solid rgba(0,0,0,.14);border-radius:10px;">
<h2 style="border-bottom:1px solid #DDD;text-align:center;font-size:16px;font-weight:normal;padding:8px 0 10px 8px;"><span style="color: #00A7EB;font-weight: bold;"> </span>你在<span style="text-decoration:none; color:#58B5F5;font-weight:600;">' . $blogname . '</span>的留言有回复啦！</h2><div style="padding:0 12px 0 12px;margin-top:18px">
<p>Hi,' . trim(get_comment($parent_id)->comment_author) . '! 这是你发表在 《' . get_the_title($comment->comment_post_ID) . '》 的评论:</p>
<p style="background-color: #FAFAE7;padding: 15px;margin: 15px 0;border-radius:6px;">' . nl2br(strip_tags(get_comment($parent_id)->comment_content)) . '</p>
<p>' . trim($comment->comment_author) . '给你的回复如下:</p>
<p style="background-color: #FAFAE7;padding: 15px;margin: 15px 0;border-radius:6px;">' . nl2br(strip_tags($comment->comment_content)) . '</p>
<p>你可以 <a style="text-decoration:none; color:#5692BC" href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看完整的回复內容</a>,祝您生活愉快！</p>
<p style="padding-bottom: 15px;color:#F5F171;text-align:center;">此邮件由系统自动发出,请勿直接回复!</p></div></div></td></tr></tbody></table></div>';
		$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
		$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
		wp_mail( $to, $subject, $message, $headers );
	}
}
add_action('comment_post', 'fanly_comment_mail_notify');
//文章点赞 
add_action('wp_ajax_nopriv_specs_zan', 'specs_zan');
add_action('wp_ajax_specs_zan', 'specs_zan');
function specs_zan(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ( $action == 'ding'){
        $specs_raters = get_post_meta($id,'specs_zan',true);
        $expire = time() + 99999999;
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; 
        setcookie('specs_zan_'.$id,$id,$expire,'/',$domain,false);
        if (!$specs_raters || !is_numeric($specs_raters)) {
            update_post_meta($id, 'specs_zan', 1);
        } 
        else {
            update_post_meta($id, 'specs_zan', ($specs_raters + 1));
        }
        echo get_post_meta($id,'specs_zan',true);
    } 
    die;
}
//获得网站头部大图
function jaguar_get_background_image($post_id = null , $width = null , $height = null){
    if( has_post_thumbnail($post_id) ){
        $timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
        $output = $timthumb_src[0];
    } else {
        $content = get_post_field('post_content', $post_id);
        $defaltthubmnail = get_template_directory_uri().'/build/img/default.jpg';
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if($n > 0){
            $output = $strResult[1][0];
        } else {
            $output = $defaltthubmnail;
        }
    }
    return $output;
}
//获得文章图片
function jaguar_is_has_image($post_id){
    static $has_image;
    global $post;
    if( has_post_thumbnail($post_id) ){
        $has_image = true;
    } else {
        $content = get_post_field('post_content', $post_id);
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if($n > 0){
            $has_image = true;
        } else {
            $has_image = false;
        }
    }
    return $has_image;
}
//杂项
function jaguar_setup() {
    add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array('status') );
    register_nav_menu( 'top' , '顶部菜单' );
    add_filter('pre_option_link_manager_enabled','__return_true');
}
add_action( 'after_setup_theme', 'jaguar_setup' );
//网站标题
function jaguar_wp_title( $title, $sep ) {
    global $paged, $page;
    if ( is_feed() )
        return $title;
    $title .= get_bloginfo( 'name', 'display' );
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";
    if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'twentythirteen' ), max( $paged, $page ) );
    return $title;
}
add_filter( 'wp_title', 'jaguar_wp_title', 10, 2 );
//设置gravatar头像
function jaguar_ssl_avatar($avatar) {
    $avatar = str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"),"secure.gravatar.com",$avatar);
    return $avatar;
}
add_filter('get_avatar', 'jaguar_ssl_avatar');
//评论表单在评论下方
function jaguar_recover_comment_fields($comment_fields){
    $comment = array_shift($comment_fields);
    $comment_fields =  array_merge($comment_fields ,array('comment' => $comment));
    return $comment_fields;
}
add_filter('comment_form_fields','jaguar_recover_comment_fields');
//上下篇文章图片
function jaguar_post_nav_background() {
    if ( ! is_single() ) {
        return;
    }
    $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );
    $css      = '';
    if ( is_attachment() && 'attachment' == $previous->post_type ) {
        return;
    }
    if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
        $prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
        $css .= '
      .post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . ');}
      .post-navigation .nav-previous .post-title { color: #fff; }
      .post-navigation .nav-previous .meta-nav { color: rgba(255,255,255,.9)}
      .post-navigation .nav-previous:before{
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0,0,0,0.4);
    }
    ';
    }
    if ( $next && has_post_thumbnail( $next->ID ) ) {
        $nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
        $css .= '
      .post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . ');}
      .post-navigation .nav-next .post-title { color: #fff; }
      .post-navigation .nav-next .meta-nav { color: rgba(255,255,255,.9)}
      .post-navigation .nav-next:before{
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0,0,0,0.4);
    }
    ';
    }
    wp_add_inline_style( 'jaguar', $css );
}
add_action( 'wp_enqueue_scripts', 'jaguar_post_nav_background' );
//展开 / 收缩功能
function xcollapse($atts,$content=null,$code=""){
    extract(shortcode_atts(array("title"=>'标题内容'),$atts));
    $return = '<div class="xControl"><div class="xHeading"><div class="xIcon"><i class="iconfont icon-plus"></i></div><h5>';
    $return .= $title;
    $return .= '</h5></div><div class="xContent"><div class="inner">';
    $return .= $content;
    $return .= '</div></div></div>';
    return $return;
}
add_shortcode('collapse','xcollapse');
//引入js和css
function jaguar_scripts_styles() {
     if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    wp_enqueue_style( 'jaguar', get_template_directory_uri() . '/build/css/app.css', array(), '1.5' );
    wp_enqueue_style( 'iconfont', get_template_directory_uri() . '/build/css/iconfont.css', array(), '1.5' );
if ( is_singular() ) {
    wp_enqueue_style( 'highlight', get_template_directory_uri() . '/build/css/highlight.css', array(), '9.15.10' );
 wp_enqueue_script( 'highlight' , get_template_directory_uri() . '/build/js/highlight.min.js' , array() , '9.15.10' ,true);
}
if ( is_singular() && yjp_option('share') == '1' ) {
 wp_enqueue_script( 'qrcode' , get_template_directory_uri() . '/build/js/qrcode.min.js' , array() , '' ,true);
}
 wp_enqueue_script( 'jaguar_jquery' , get_template_directory_uri() . '/build/js/jquery.min.js' , array() , '3.4.1' ,true);
    wp_enqueue_script( 'jaguar' , get_template_directory_uri() . '/build/js/application.js' , array('jquery') , '1.5' ,true);
$singular = is_singular();
$comment_img = yjp_option('comment_img') ? '1' : '0';
$hitokoto = yjp_option('hitokoto') ? '1' : '0';
$qrcode = yjp_option('share') ? '1' : '0';
$singular_post_open = is_singular('post');
$comment_open = comments_open();
$is_home = is_home();

   wp_localize_script( 'jaguar', 'J', array(
            'ajax_url'   => admin_url('admin-ajax.php'),
            'order' => get_option('comment_order'),
            'formpostion' => 'bottom',
         'singular_open' => $singular,
'hitokoto' => $hitokoto,
'qrcode' => $qrcode,
'singular_post_open' => $singular_post_open,
'comment_open' => $comment_open,
'comment_img' => $comment_img,
'is_home' => $is_home,

        ) );
    if ( is_singular() && has_post_thumbnail() ) {
        global $post;
        $timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
        $output = $timthumb_src[0];
        $custom_css = "
                .banner-mask{
                        background-image:url(" . $output . ");
                }";
 wp_add_inline_style( 'jaguar', $custom_css );
    }
}
add_action( 'wp_enqueue_scripts', 'jaguar_scripts_styles' );
//评论回调
function comment_format($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment; ?>
    <li class="comment" id="comment-<?php comment_ID(); ?>">
<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
 <footer class="comment-meta">
 <div class="comment-author vcard">
<?php echo get_avatar( $comment, $size = '40')?>
  <b class="fn">
      <?php echo get_comment_author_link();?>
      </b>
<?php if(user_can($comment->user_id, "update_core")){echo '<span class="comment-admin">'.__('博主','yjp').'</span>';}?>
      <span class="says">说道：</span> 
     </div>
      <div class="comment-metadata">
 <time><?php echo get_comment_date(); ?></time>
 </div>
 </footer>
 <div class="comment-content">
 <p><?php comment_text(); ?></p>
 </div>
 <div class="reply"><?php comment_reply_link(array_merge($args, array('reply_text' => '回复', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
</div> </article>
 </li>
    <?php
}
//ajax评论发表
    function fa_ajax_comment_callback(){
        $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
    if ( is_wp_error( $comment ) ) {
        $data = $comment->get_error_data();
        if ( ! empty( $data ) ) {
            fa_ajax_comment_err($comment->get_error_message());
        } else {
            exit;
        }
    }
    $user = wp_get_current_user();
    do_action('set_comment_cookies', $comment, $user);
    $GLOBALS['comment'] = $comment;
    ?>
        <li <?php comment_class(); ?>>
            <article class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php echo get_avatar( $comment, $size = '48')?>
                        <b class="fn">
                            <?php echo get_comment_author_link();?>
                        </b>
                    </div>
                    <div class="comment-metadata">
                        <?php echo get_comment_date(); ?>
                    </div>
                </footer>
                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>
            </article>
        </li>
        <?php die();
    }


add_action('wp_ajax_nopriv_ajax_comment', 'fa_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'fa_ajax_comment_callback');
//回复评论加@ 
function wp_comment_add_at( $comment_text, $comment = '') {
if( $comment->comment_parent > 0) {
$comment_text = '<a href="#comment-' . $comment->comment_parent . '" class="comment-at">@'.get_comment_author( $comment->comment_parent ) . ' </a>' . $comment_text;
}
return $comment_text;
}
add_filter( 'comment_text' , 'wp_comment_add_at', 20, 2);
//评论者的链接新窗口打开
function get_comment_author_link_blank($content){
    $content = str_replace('<a', '<a target="_blank"', $content);
    return $content;
}
add_filter('get_comment_author_link', 'get_comment_author_link_blank');
//评论内容中的链接新窗口打开
function comment_blank($content){
    $content = str_replace('<a', '<a target="_blank"', $content);
    return $content;
}
add_filter('comment_text', 'comment_blank');
