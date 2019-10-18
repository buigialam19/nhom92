<?php 

/*

Plugin Name: System

Plugin URI: http://1234.com.vn

Description: Hệ thống Quản trị

Author: Nguyễn Đình Nguyên

Version: 1.0

Author URI: http://1234.com.vn

*/

/** Remove title Wordpress**/

add_filter('admin_title', 'my_admin_title', 10, 2);



function my_admin_title($admin_title, $title)

{

    return $title.' &lsaquo; '.get_bloginfo('name').' &lsaquo; '.'Mã Số Xanh';

}

/** Footer **/

function remove_footer_admin () {

    echo 'Phát triển bởi Mã Số Xanh';

}

add_filter('admin_footer_text', 'remove_footer_admin');

/** **/ 

add_action('admin_init', 'rw_remove_dashboard_widgets');

    function rw_remove_dashboard_widgets() {

        remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); // right now

        remove_meta_box('dashboard_activity', 'dashboard', 'normal');// WP 3.8

        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // recent comments

        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); // incoming links

        remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); // plugins

         

        remove_meta_box('dashboard_quick_press', 'dashboard', 'normal'); // quick press

        remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal'); // recent drafts

        remove_meta_box('dashboard_primary', 'dashboard', 'normal'); // wordpress blog

        remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); // other wordpress news

}

/** Remove  WordPress Welcome Panel **/

remove_action('welcome_panel', 'wp_welcome_panel');



/** Ẩn Menu **/

add_action( 'admin_menu', 'my_remove_menu_pages' );

	function my_remove_menu_pages() {

		remove_menu_page('edit-comments.php');

        remove_menu_page('tools.php');

        remove_menu_page('');   	

	}

    

function remove_admin_bar_links() {

    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('wp-logo');          /** Remove the WordPress logo **/

    $wp_admin_bar->remove_menu('about');            /** Remove the about WordPress link **/

    $wp_admin_bar->remove_menu('wporg');            /** Remove the WordPress.org link **/

    $wp_admin_bar->remove_menu('documentation');    /** Remove the WordPress documentation link **/

    $wp_admin_bar->remove_menu('support-forums');   /** Remove the support forums link **/

    $wp_admin_bar->remove_menu('feedback');         /** Remove the feedback link **/

    //$wp_admin_bar->remove_menu('site-name');      /** Remove the site name menu **/

    $wp_admin_bar->remove_menu('view-site');        /** Remove the view site link **/

    $wp_admin_bar->remove_menu('updates');          /** Remove the updates link **/

    $wp_admin_bar->remove_menu('comments');         /** Remove the comments link **/

    $wp_admin_bar->remove_menu('new-content');      /** Remove the content link **/

    $wp_admin_bar->remove_menu('w3tc');             /** If you use w3 total cache remove the performance link **/

    //$wp_admin_bar->remove_menu('my-account');     /** Remove the user details tab **/

}

add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

add_action( 'admin_menu', 'my_remove_menus', 999 );



function my_remove_menus() {



	remove_submenu_page( 'themes.php', 'themes.php' );


    remove_submenu_page( 'themes.php', 'customize.php' );

    remove_submenu_page( 'plugins.php', 'plugin-editor.php' );

    remove_submenu_page( 'index.php', 'update-core.php' );

    remove_submenu_page( 'options-general.php', 'options-discussion.php' );

}

/** Ẩn MenuBar **/

add_filter('show_admin_bar', '__return_false');

/** Thay doi duong dan logo admin **/

function wpc_url_login(){

return "http://Mã Số Xanh/";

}

add_filter('login_headerurl', 'wpc_url_login');

/** Thay doi logo admin wordpress **/

function login_css() {

wp_enqueue_style( 'login_css', plugin_dir_url( __FILE__ ) . '/login.css' );

}

add_action('login_head', 'login_css');



/** Thêm cột để chứa ảnh cho cả post và page **/

if (function_exists( 'add_theme_support' )){

    add_filter('manage_posts_columns', 'posts_columns', 5);

    add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);

    add_filter('manage_pages_columns', 'posts_columns', 5);

    add_action('manage_pages_custom_column', 'posts_custom_columns', 5, 2);

}

function posts_columns($defaults){

    $defaults['wps_post_thumbs'] = __('Thumbs');

    return $defaults;

}

function posts_custom_columns($column_name, $id){

        if($column_name === 'wps_post_thumbs'){

        echo the_post_thumbnail( array(125,80) );

    }

}

/** Welcome **/

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

	  

	function my_custom_dashboard_widgets() {

	global $wp_meta_boxes;

	 

	wp_add_dashboard_widget('custom_help_widget', 'Giới thiệu', 'custom_dashboard_help');

	}

	 

	function custom_dashboard_help() { ?>

    <p>Chào mừng Quý khách đến với hệ thống Quản Trị Website.<p>

    <p><strong>THÔNG TIN WEBSITE</strong></p>

    <P><?php echo bloginfo( 'name' ); ?> | <?php echo bloginfo( 'description' ); ?></p>

    <p><strong></strong><?php echo $info;  ?></p>

    <p><strong>Địa chỉ: </strong><?php echo get_settings('address'); ?></p>

    <p><strong>Điện thoại: </strong><?php echo get_settings('tel');  ?></p>

    <p><strong>Email: </strong><?php echo bloginfo( 'admin_email' ); ?></p>

	<p><strong style="color: #ff0000;">NHÀ PHÁT TRIỂN</strong></p>

    <p>Hệ thống được phát triển bởi <strong style="color: #0083E0;">Công ty TNHH Mã Số Xanh</strong> trên nền <strong> Wordpress <?php echo bloginfo("version") ; ?> </strong>.</p>

    <p>Mọi thắc mắc, lỗi trong quá trình sử dụng Quý khách hàng có thể liên hệ Kỹ Thuật <strong style="color: #0083E0;">Mã Số Xanh</strong></p>

    <p><strong>Nguyễn Đình Nguyên </strong> 

    <p> Web Developer</p> 

    <p><strong>Phone</strong>: 0935 935 422<strong> Skype</strong>: tech.dana</p> 

    <p><strong>Email</strong>: info@1234.com.vn <strong>Website</strong>: <a href="https://1234.com.vn">www.1234.com.vn</a></p> 

    <p style="color: #0083E0;">  Cảm ơn quý khách đã tin tưởng và sử dụng sản phẩm của công ty TNHH Mã Số Xanh.</p>

	<?php }

/** This theme allows users to set a custom background. **/

add_theme_support( 'custom-background', apply_filters( 'kinmedia_custom_background_args', array(

		'default-color' => 'f5f5f5',

	) ) );

/** Add Setting **/    

$new_general_setting = new new_general_setting();

class new_general_setting {

    function new_general_setting( ) {

        add_filter( 'admin_init' , array( &$this , 'register_fields' ) );

    }

    function register_fields() {

        register_setting( 'general', 'info', 'esc_attr' );

        add_settings_field('info', '<label for="info">'.__('Name' , 'info' ).'</label>' , array(&$this, 'print_info_field') , 'general' );



        register_setting( 'general', 'address', 'esc_attr' );

        add_settings_field('address', '<label for="address">'.__('Address' , 'address' ).'</label>' , array(&$this, 'print_address_field') , 'general' );



        register_setting( 'general', 'tel', 'esc_attr' );

        add_settings_field('tel', '<label for="tel">'.__('Tel & Fax' , 'tel' ).'</label>' , array(&$this, 'print_tel_field') , 'general' );



        register_setting( 'general', 'email', 'esc_attr' );

        add_settings_field('email', '<label for="tel">'.__('Email' , 'email' ).'</label>' , array(&$this, 'print_email_field') , 'general' );     

    }

    function print_tel_field() {

        $value = get_option( 'tel', '' );

        echo '<input type="text" id="tel" style="width: 45%;" name="tel" value="' . $value . '" />';

    }

    function print_email_field() {

        $value = get_option( 'email', '' );

        echo '<input type="text" id="email" style="width: 45%;" name="email" value="' . $value . '" />';

    }

    function print_address_field() {

        $value = get_option( 'address', '' );

        echo '<input type="text" id="address" style="width: 45%;" name="address" value="' . $value . '" />';

    }

    function print_info_field() {

        $value = get_option( 'info', '' );

        echo '<input type="text" id="info" style="width: 45%;" name="info" value="' . $value . '" />';

    }

}

?>