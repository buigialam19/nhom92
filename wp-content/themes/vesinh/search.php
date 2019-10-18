<?php get_header(); ?>
	<div id="content" class="content">
	<main role="main">
		<!-- section -->
		<section>

			<h1 class="homepage-title"><?php echo sprintf( __( '%s kết quả với ', 'html5blank' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>

			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</section>
		<!-- /section -->
	</main>
<aside class="sidebar" role="complementary">
	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-2')) ?>
	</div>
</aside>

<?php get_footer(); ?>
