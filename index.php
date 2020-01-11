<?php get_header('simple'); ?>
    <div class="content-area container is-homeList">
        <div class="site-content">
            <?php if ( have_posts() ) : ?>
                <div class="main-content">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'content', get_post_format() ); ?>
                <?php endwhile; ?>
                </div>
               <div id="pagination"><?php next_posts_link(__('下一页')); ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php get_footer(); ?>