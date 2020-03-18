<?php 
/**
 Template Name: 友链
 */
get_header(); 
?>
 <div class="content-area container">
        <div class="site-content">
            <?php while ( have_posts() ) : the_post(); ?>
                <section class="post-content">
                    <div class="single-post-inner grap">
                        <?php the_content();?>
                        <?php
 $bookmarks = get_bookmarks('title_li=&orderby=rand');
 if ( !empty($bookmarks) ){
 echo '<ul class="link-content">';
 foreach ($bookmarks as $bookmark) {
 $friendimg = $bookmark->link_image;
 if(empty($friendimg)){
 echo '<li class="link_item" style="background-image:url('. get_avatar($bookmark->link_notes,64) . ');"><a href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank"><span class="link-info"><span class="site_name">'. $bookmark->link_name .'</span><span class="site_description">'. $bookmark->link_description .'</span></span></a></li>';
 } else {
 echo '<li class="link_item" style="background-image:url('. $bookmark->link_image. ');"><a href="' . $bookmark->link_url . '" title="' . $bookmark->link_description . '" target="_blank" ><span class="link-info"><span class="site_name">'. $bookmark->link_name .'</span><span class="site_description">'. $bookmark->link_description .'</span></span></a></li>';
 }
 }
 echo '</ul>';
 }
 ?>
                </div>
                </section>
                <?php comments_template(); ?>
            <?php endwhile; ?>
        </div>
    </div>
<?php get_footer(); ?>