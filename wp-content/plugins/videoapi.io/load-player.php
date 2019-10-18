<?php 
/**
 * class load player 
 */
class LoadPlayer
{
	
	function __construct()
	{
		$this->key = esc_attr(get_option('videoapi_key_videoapi'));
		if(!$this->key)
		{
			return;
		}
		$this->api = 'https://videoapi.io/api/getlink?key='.$this->key.'&return=data&link=';
		$this->pluginsURL = plugin_dir_url( __FILE__ );
	}

	/**
	 * show player
	 * @time   2017-04-29T10:12:52+0700
	 * @author HaiLong
	 * @param  json                   	$metaPost 
	 * @param  int                   	$postID   
	 * @return string                             
	 */
	public function index($metaPost, $postID)
	{
		$data = json_decode($metaPost);
		$sv = (isset($_GET['sv']) && $_GET['sv']) ? $_GET['sv'] : 1;
		$ep = (isset($_GET['ep']) && $_GET['ep']) ? $_GET['ep'] : 1;
		if(!is_numeric($sv) || !is_numeric($ep))
			return;
		$result = "<script type='text/javascript'>
						jQuery(document).ready(function($) {
							$('.videoapi-btn').click(function(){
								var post_id = $(this).data('post-id');
								var server = $(this).data('server');
								var episode = $(this).data('episode');
								$('.videoapi-btn').removeClass('active');
								$(this).addClass('active');
								videoapiLoadPlayer(post_id,server,episode);
							});
							function videoapiLoadPlayer(post_id,server,episode)
							{
								var data = {
									'action': 'videoapi_get_player',
									'post_id': post_id,
									'server': server,
									'episode': episode,
								};
								if(server != 1 || episode != 1)
								{
									window.history.pushState('', '', '?sv='+server+'&ep='+episode);
								}
								$('html,body').animate({scrollTop: $('#videoapi-player').offset().top - 50},'slow');
								$('#videoapi-player').html('');
								jQuery.post(ajax_object.ajax_url, data, function(response) {
									$('#videoapi-player').html(response);
								});
							}
							videoapiLoadPlayer('".$postID."','".$sv."','".$ep."');
						});
					</script>";

		$result .= '<div id="videoapi-wrap-player" style="width:'.esc_attr(get_option('videoapi_width')).' !important; height: '.esc_attr(get_option('videoapi_height')).' !important"><div id="videoapi-player"></div></div>';
		$result .='<div id="videoapi-feature">
			<div class="auto-next">
				<div class="left">Auto next: </div>
				<label class="videoapi-switch right">
					<input class="videoapi-switch-input" type="checkbox">
					<div class="slider round"></div>
				</label>
			</div>
		</div>';
		$result .='<div id="videoapi-list-server">';
		if($data)
		{
			foreach ($data as $key => $value) 
			{
				$result .= '<div class="videoapi-server">';
				$result .= '<h3 class="videoapi-server-name">'.$value->videoapi_server_name.'</h3>';
				$videoapi_server_data = $value->videoapi_server_data;
				if($videoapi_server_data)
				{
					$result .= '<ul class="videoapi-list-episode">';
					foreach ($videoapi_server_data as $k => $v) {
						if($v->videoapi_ep_name)
						{
							if($sv == ($key+1) && $ep == ($k+1))
							{
								$active = 'active';
								$linkFilm = '#';
							}
							else
							{
								$active = '';
								$linkFilm = get_the_permalink().'?sv='.($key+1).'&ep='.($k+1);
							}
							$position = '';
							if($k == 0)
							{
								$position = 'first';
							}
							if($k == count($videoapi_server_data) - 1)
							{
								$position = 'last';
							}
							$result .= '<li class="videoapi-episode"><span class="videoapi-btn '.$active.' videoapi-info-'.($key+1).'-'.($k+1).'" data-post-id="'.$postID.'" data-server="'.($key+1).'" data-episode="'.($k+1).'" data-position="'.$position.'">'.$v->videoapi_ep_name.'</span></li>';
						}
					}
					$result .= '</ul>';
				}
				$result .= '<div class="clear"></div>';
				$result .= '</div>';
			}
		}
		$result .= '</div>';
		return $result;
	}
}
?>
