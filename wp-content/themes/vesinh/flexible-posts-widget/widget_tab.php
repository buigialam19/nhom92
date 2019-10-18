<?php
/**
 * Flexible Posts Widget: KENIT widget template
 */

if ( !defined('ABSPATH') )
	die('-1');

echo $before_widget;?>
<?php if ( !empty($title) )
	echo $before_title . $title . $after_title;

if( $flexible_posts->have_posts() ):
?>
<ul>
	<?php while( $flexible_posts->have_posts() ) : $flexible_posts->the_post(); global $product;?>
		<li class="box">
			<a class="post-img" href="<?php echo the_permalink(); ?>">
				<div class="screen">
            		<div class="frame">
					<?php
						if( $thumbnail == true ) {
							if( has_post_thumbnail() ) {
								the_post_thumbnail( $thumbsize );
							} elseif( 'image/' == substr( $post->post_mime_type, 0, 6 ) ) {
								echo wp_get_attachment_image( $post->ID, $thumbsize );
							}
						}
					?>
					</div>
				</div>
			</a>
			<a class="post-title" href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>">
                <?php the_title(); ?>
            </a>
             <div class="rating"><img src="<?php echo get_template_directory_uri(); ?>/images/stars.png"></div>
            <div class="price">
                <?php echo $product->get_price_html(); ?>
            </div>
		</li>
	<?php endwhile; ?>
</ul>
<?php else: ?>
		<p><?php _e( 'No post found', 'flexible-posts-widget' ); ?></p>
<?php	
endif;?>
<?php echo $after_widget;
