<?php
// Them css va javascript vao giua the head
function sw_styles_and_scripts() {
	wp_register_style('html5blank-custom-style', get_template_directory_uri().'/child/custom-style.css');
	wp_enqueue_style('html5blank-custom-style');
}
add_action('wp_enqueue_scripts', 'sw_styles_and_scripts');
// Them vao cac chuc nang ho tro cua giao dien
if (function_exists('add_theme_support'))
{
	// Khai bao kich thuoc cho hinh anh thumbnail khi xem bai viet
	add_image_size('custom-single-size', 300, 175, true);
	
	// Khai bao kich thuoc cho hinh anh thumbnail khi duyet danh sach bai viet
	add_image_size('custom-home-size', 1004, 477, true);
	
	// Khai bao kich thuoc cho hinh anh thumbnail khi duyet danh sach bai viet
	add_image_size('custom-bv-size', 95, 65, true);
}
/* REMOVE NOTICE UPDATE WP */
add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );
/* END REMOVE NOTICE UPDATE WP */
# REMOVE UPDATE PLUGIN
remove_action( 'load-update-core.php', 'wp_update_plugins' );
add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );
# END REMOVE UPDATE PLUGIN
/*===================================================================================
 *  Tao thong tin mang xa hoi cho tai khoan
 * =================================================================================*/
function add_to_author_profile( $contactmethods ) {
	
	$contactmethods['google_profile'] = 'Google Profile URL';
	$contactmethods['twitter_profile'] = 'Twitter Profile URL';
	$contactmethods['facebook_profile'] = 'Facebook Profile URL';
	$contactmethods['linkedin_profile'] = 'Linkedin Profile URL';
	
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'add_to_author_profile', 10, 1);
 register_sidebar(array(
    'name' => 'Home page',
    'id' => 'home-page',
    'description' => 'Khu vực sidebar hiển thị ngay chổ góc khách hàng đó mà',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="homepage-title">',
    'after_title' => '</h3>'
));
add_filter( 'user_contactmethods', 'add_to_author_profile', 10, 1);
 register_sidebar(array(
    'name' => 'Góc Khách Hàng',
    'id' => 'goc-khach-hang',
    'description' => 'Khu vực sidebar hiển thị ngay chổ góc khách hàng đó mà',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>'
));
 register_sidebar(array(
    'name' => 'Tin Tức',
    'id' => 'tin-tuc',
    'description' => 'Khu vực sidebar hiển thị ngay chổ tin tức đó mà',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>'
));
 register_sidebar(array(
    'name' => 'Liên Hệ',
    'id' => 'lien-he',
    'description' => 'Khu vực sidebar hiển thị ngay chổ liên hệ đó mà',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>'
));
function quocgia_taxonomy() {
        $labels = array(
                'name' => 'Quốc Gia',
                'singular' => 'Quốc Gia',
                'menu_name' => 'Quốc Gia'
        );
        $args = array(
                'labels'                     => $labels,
                'hierarchical'               => false,
                'public'                     => true,
                'show_ui'                    => true,
                'show_admin_column'          => false,
                'show_in_nav_menus'          => true,
                'show_tagcloud'              => true,
        );
        register_taxonomy('quoc-gia', 'post', $args);
 
}
add_action( 'init', 'quocgia_taxonomy', 0 );
function dienvien_taxonomy() {
        $labels = array(
                'name' => 'Diễn Viên',
                'singular' => 'Diễn Viên',
                'menu_name' => 'Diễn Viên'
        );
        $args = array(
                'labels'                     => $labels,
                'hierarchical'               => false,
                'public'                     => true,
                'show_ui'                    => true,
                'show_admin_column'          => false,
                'show_in_nav_menus'          => true,
                'show_tagcloud'              => true,
        );
        register_taxonomy('dien-vien', 'post', $args);
 
}
add_action( 'init', 'dienvien_taxonomy', 0 );
function theloai_taxonomy() {
        $labels = array(
                'name' => 'Thể loại',
                'singular' => 'Thể loại',
                'menu_name' => 'Thể loại'
        );
        $args = array(
                'labels'                     => $labels,
                'hierarchical'               => false,
                'public'                     => true,
                'show_ui'                    => true,
                'show_admin_column'          => false,
                'show_in_nav_menus'          => true,
                'show_tagcloud'              => true,
        );
        register_taxonomy('the-loai', 'post', $args);
 
}
add_action( 'init', 'theloai_taxonomy', 0 );
?>