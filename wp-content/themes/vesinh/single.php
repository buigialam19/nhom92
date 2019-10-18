<?php get_header(); ?>
	<div id="content" class="content">
<?php
if ( function_exists('yoast_breadcrumb') ) {
yoast_breadcrumb('
<p id="breadcrumbs">','</p>
');
}
?>
	<main role="main">
	<!-- section -->
	<section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="col-poster">
    <div class="fstory-poster">
        <div class="poster"> <?php the_post_thumbnail(array(500,377));?></div> <span class="film-rip1"><?php the_field('chat_luong');?></span> </div>
</div>
		<div class="col-finfo">
    <div class="finfo"> <span class="finfo-line"></span>
        <div class="finfo-block">
            <div class="finfo-title">Tên phim :</div>
            <h1 class="finfo-text"><b><?php the_title(); ?></b>
            </h1>
        </div>
    </div>
    <div class="finfo"> <span class="finfo-line"></span>
        <div class="finfo-block">
            <div class="finfo-title">Tiếng anh :</div>
            <div class="finfo-text"><b><?php the_field('ten_tieng_anh');?></b>
            </div>
        </div>
    </div>
    <div class="finfo"> <span class="finfo-line"></span>
        <div class="finfo-block">
            <div class="finfo-title">Đạo diễn :</div>
            <div class="finfo-text"><?php the_field('dao_dien');?>
            </div>
        </div>
    </div>
    <div class="finfo"> <span class="finfo-line"></span>
        <div class="finfo-block">
            <div class="finfo-title">Thể loại :</div>
            <div class="finfo-text"><?php the_terms( $post->ID, 'the-loai') ?>
            </div>
        </div>
    </div>
    <div class="finfo"> <span class="finfo-line"></span>
        <div class="finfo-block">
            <div class="finfo-title">Quốc gia :</div>
            <div class="finfo-text"><?php the_terms( $post->ID, 'quoc-gia') ?>
            </div>
        </div>
    </div>
    <div class="finfo"><span class="finfo-line"></span>
        <div class="finfo-block">
            <div class="finfo-title">Diễn viên :</div>
            <div class="finfo-text"><?php the_terms( $post->ID, 'dien-vien') ?></div>
        </div>
    </div>
    <div class="finfo"> <span class="finfo-line"></span>
        <div class="finfo-block">
            <div class="finfo-title">Phát hành : </div>
            <div class="finfo-text"><?php the_field('nam_san_xuat');?></div>
        </div>
    </div>
    <div class="box-rating">
	<?php if(function_exists("kk_star_ratings")) : echo kk_star_ratings($pid); endif; ?>
    </div>
</div>
<div class="col-tt">
<h3 class="homepage-title">Thông tin phim</h3>
<?php the_content(); ?>
</div>
<div class="col-player">
<?php echo do_shortcode('[videoapi]'); ?>
</div>
<?php the_tags( __( 'Tags: ', 'html5blank' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>
			
		

			

			<?php edit_post_link(); // Always handy to have Edit Post Links available ?>


			<?php comments_template(); ?>

		</article>
		<!-- /article -->

	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>

	</section>
	<!-- /section -->
	</main>


<aside class="sidebar" role="complementary">
	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-2')) ?>
	</div>
</aside>
<?php get_footer(); ?>
