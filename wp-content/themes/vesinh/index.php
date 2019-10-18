<?php get_header(); ?>
  <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:1300px;height:450px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position:absolute;top:0px;left:0px;background-color:rgba(0,0,0,0.7);">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url('<?php bloginfo('template_directory');?>/img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1300px;height:500px;overflow:hidden;">
		  <?php $new = new WP_Query();$x=0;
				$new->query('showposts=9&meta_key=slider&meta_value=co');
				while ($new->have_posts()): $x++;$new->the_post();?>
            <div>
                <a href="<?php the_permalink();?>"><img data-u="image" src="<?php the_field('anh_slider');?>" /></a>
                <div class="info-phim">
                    <span class="info-title"><?php the_title(); ?> <br> <?php the_field('ten_tieng_anh');?></span>
                    <span class="info-content"><?php html5wp_excerpt('html5wp_index');?></span>
                    <div class="info-description">
                        <span class="info-year"> <?php the_terms( $post->ID, 'the-loai', '<strong>Thể loại</strong>: ', ', ' ) ?></span>
                        <span class="info-year"><strong>Thời lượng</strong>: <?php the_field('thoi_luong');?></span>
                        <span class="info-year"><strong>Năm sản xuất</strong>: <?php the_field('nam_san_xuat');?></span>
                        <span class="info-year"><strong>Đánh giá IMDB</strong>: <?php the_field('diem_imdb');?></span>
                    </div>
                    <div class="info-watch-more">
                        <a href="<?php the_permalink();?>" class="btn-watch-movie">Xem thêm</a>
                    </div>
                </div>
            </div>
			<?php endwhile;?>	
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">
            <!-- bullet navigator item prototype -->
            <div data-u="prototype" style="width:16px;height:16px;"></div>
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora22l" style="top:0px;left:8px;width:40px;height:58px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora22r" style="top:0px;right:8px;width:40px;height:58px;" data-autocenter="2"></span>
    </div>
    <script type="text/javascript">
        jssor_1_slider_init();
    </script>
    <!-- #endregion Jssor Slider End -->

	<div id="content" class="content">
	<main role="main">
		<!-- section -->
		<section>
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-page')) ?>
	
		</section>
		<!-- /section -->
		
	</main>

<aside class="sidebar" role="complementary">
	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-2')) ?>
	</div>
</aside>
<?php get_footer(); ?>
