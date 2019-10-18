<?php get_header(); ?>
	<div id="content" class="content">
	<main role="main">
		<!-- section -->
		<section>

			<h1 class="homepage-title"><?php _e( '', 'html5blank' ); single_cat_title(); ?></h1>

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
