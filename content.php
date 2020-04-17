<article class="post-item">
<?php if ( yjp_option('lazyload') == '0') : ?><div class="post-image" style="background-image: url(<?php echo jaguar_get_background_image(get_the_ID(),740,340);?>);"><?php elseif ( yjp_option('lazyload') == '1') : ?><div class="post-image lazyload" style="background-image: url(data:image/gif;base64,R0lGODdhAQABAPAAAMPDwwAAACwAAAAAAQABAAACAkQBADs=)" data-src="<?php echo jaguar_get_background_image(get_the_ID(),740,340);?>"><?php endif; ?>
        <div class="info-mask">
            <div class="mask-wrapper">
                <h2 class="post-title">
                    <a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?>	<?php if(is_sticky()) { ?><i class="iconfont icon-fire"></i><?php } ?></a>
                </h2>
                <div class="post-info"><span class="post-time"><i class="iconfont icon-clock"></i><time><?php echo get_the_date( 'M d,Y');?></time></span><span class="middotDivider"></span><span class="post-tags"><i class="iconfont icon-categorized"></i><?php the_category(',');;?></span><span class="middotDivider"></span><span class="post-views"><i class="iconfont icon-eye"></i><?php echo get_post_views(get_the_ID()); ?></span></span></div>
            </div>
        </div>
    </div>
</article>