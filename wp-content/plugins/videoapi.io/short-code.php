<?php 
/**
 * Short code for player
 */
if(!class_exists('videoapi_shortcode')) 
{
	class videoapi_shortcode 
	{
		function __construct() 
		{
			if(!function_exists('add_shortcode')) 
			{
				return;
			}
			add_shortcode( 'videoapi', array(&$this, 'videoapi_function_shortcode' ) );
		}

		/**
		 * register short code
		 * @time   2017-04-29T10:14:04+0700
		 * @author HaiLong
		 * @param  string                   $atts [description]
		 * @return [type]                         [description]
		 */
		function videoapi_function_shortcode($atts = '') 
		{
			$atts = shortcode_atts(
				array(
				), $atts, 'videoapi' );
			global $post;
			$videoapiMetaPost = get_post_meta( $post->ID, '_videoapi', true );
			$videoapi_content = '';
			if($videoapiMetaPost){
				$loadplayer = new Loadplayer();
				$videoapi_content = $loadplayer->index($videoapiMetaPost, $post->ID);
			}
		 	return $videoapi_content;
		}
	}
}
if(!function_exists('videoapi_load_shortcode'))
{
	function videoapi_load_shortcode() 
	{
	    global $videoapi;
	    $videoapi = new videoapi_shortcode();
	}
	add_action( 'plugins_loaded', 'videoapi_load_shortcode' );
}
?>