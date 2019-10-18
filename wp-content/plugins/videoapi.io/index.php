<?php
/**
 * Plugin Name: Video API for movies website
 * Plugin URI: http://videoapi.io
 * Description: VideoAPI.io is a web service that provides you services get link from google drive, google photo, youtube, facebook,... and from many other sources. You only need to send the original link to us will return the link mp4 to add movie players like jwplayer, videojs.
 * Version: 1.1
 * Author: Hai Long
 * Author URI: http://videoapi.io
 * License:
 */
include_once('functions.php');
include_once('page-settings.php');
include_once('short-code.php');
include_once('meta-posts.php');
include_once('load-player.php');
include_once('ajax.php');
include_once('cache.php');

if( !function_exists('videoapi_register_menu'))
{
	/**
	 * register menu
	 * @time   2017-04-28T13:43:18+0700
	 * @author HaiLong
	 * @return null
	 */
	function videoapi_register_menu() 
	{

        add_menu_page('VideoAPI.io', 'VideoAPI.io', 'manage_options','videoapi-settings-page','videoapi_settings_page', 'dashicons-video-alt3', 99);
	}
	add_action('admin_menu', 'videoapi_register_menu');
}

if(!function_exists('videoapi_enqueue_scripts_frontend'))
{
	function videoapi_enqueue_scripts_frontend()
	{
		wp_enqueue_style( 'videoapi-style-list-server', plugins_url('css/videoapi-frontend.css', __FILE__) );
		wp_enqueue_script( 'videoapi-script-cookie', plugins_url( '/js/jquery.cookie.js', __FILE__ ), array('jquery') );
		wp_enqueue_script( 'videoapi-script-jwplayer', plugins_url( '/player/jwplayer/jwplayer-7.10.1.js', __FILE__ ), array('jquery') );
		wp_enqueue_script( 'videoapi-script-frontend', plugins_url( '/js/videoapi-frontend.js', __FILE__ ), array('jquery') );
		wp_localize_script( 
			'videoapi-script-frontend', 
			'ajax_object',
	        array( 
	        	'ajax_url' => admin_url( 'admin-ajax.php' ),
	        	) 
	        );
	}
	add_action( 'wp_enqueue_scripts', 'videoapi_enqueue_scripts_frontend',1 );
}
if(!function_exists('videoapi_enqueue_scripts_backend'))
{
	function videoapi_enqueue_scripts_backend()
	{
		wp_enqueue_style('videoapi-plugin-page-css-components', plugins_url('css/videoapi-backend.css', __FILE__), array(), '', 'all');
	    wp_enqueue_script( 'bootstrap-script', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' );
	    wp_enqueue_script( 'videoapi-plugin-page-script', plugins_url('js/videoapi-backend.js', __FILE__) );
	    wp_localize_script( 
			'videoapi-plugin-page-script', 
			'videoapi_ajax_object',
	        array( 
	        	'ajax_url' => admin_url( 'admin-ajax.php' ),
	        	) 
	        );
	}
	add_action( 'admin_init', 'videoapi_enqueue_scripts_backend' );
}

?>