<?php 
/** Ajax grab link */
add_action( 'wp_ajax_videoapi_get_link', 'videoapi_get_link' );

if( !function_exists('videoapi_get_link'))
{
	/**
	 * Get link for plugin. 
	 * Request to https://videoapi.io/api/grablink?key={key}&link={link_suport};
	 * @time   2017-04-28T13:36:53+0700
	 * @author HaiLong
	 * @return string                   
	 */
	function videoapi_get_link() {
		$link = esc_attr($_POST['link']);
		$key = esc_attr(get_option('videoapi_key_videoapi'));
		if($key)
		{
			$apiURL = 'https://videoapi.io/api/grablink?key='.$key.'&link='.$link;
			$data = curl($apiURL);
			$data = json_decode($data);
			if($data)
			{
				$status = $data->status;
				$result = $data->result;
				if($status == 1)
				{
			?>
			<ul class="nav nav-tabs" role="tablist">
				<?php 
					if($result) {
						foreach ($result as $key => $value) {
							$tabActive = ($key == 0) ? 'active' : '';
							$closeTab = ($key > 0) ? '<span> x </span>' : '';
				        	echo '<li class="'.$tabActive.'"><a href="#server_'.($key+1).'" data-toggle="tab" id="tab_title_'.($key+1).'">'.$value->title.'</a>'.$closeTab.'</li>';
				        } 
				    }else{
				    	echo '<li class="active"><a href="#server_1" data-toggle="tab" id="tab_title_1">Server #1</a></li>';
				    }
			    ?>
		        <li><a href="#" class="add-server">+</a>
		        </li>
		    </ul>
		    <div class="clear"></div>
		    <div class="tab-content">
		    	<?php 
		    		if($result) {
		    			foreach ($result as $key => $value) {
		    				$tabContentActive = ($key == 0) ? 'active' : '';
		    	?>
		        <div class="tab-pane <?php echo $tabContentActive; ?>" id="server_<?php echo ($key+1); ?>" data-server="<?php echo ($key+1); ?>">
					<div id="videoapi_episodes_<?php echo ($key+1); ?>" class="form-horizontal">
						<div class="row">
							<div class="form-group col-lg-2">
					            <label for="videoapi_server_name_<?php echo ($key+1); ?>"><h3>Server Name</h3></label>
					            <input id="videoapi_server_name_<?php echo ($key+1); ?>" class="videoapi_server_name form-control" data-server="<?php echo ($key+1); ?>" type="text" name="videoapi_server_name[<?php echo ($key+1); ?>]" value="<?php echo esc_attr( $value->title ) ?>">
					        </div>
					    </div>
						<h3>List Episode <a style="cursor: pointer;" class="add_new_ep" data-ep-total="<?php echo (count($value->items) > 1) ? count($value->items) : '1'; ?>"  data-server="<?php echo ($key+1); ?>"><span class="dashicons dashicons-plus"></span></a></h3>
						<?php 
				        	$dataServer = $value->items;
				        	if($dataServer)
				        	{
				        		foreach ($dataServer as $k => $v) {
				        		?>
								<div class="videoapi_episodes episodes_<?php echo ($k+1); ?> row" data-ep="<?php echo ($k+1); ?>" data-server="<?php echo ($key+1); ?>">
							    	<div class="form-group col-lg-8">
							            <label for="videoapi_ep_name_<?php echo ($key+1); ?>_<?php echo ($k+1); ?>">Episode Name</label>
							            <input id="videoapi_ep_name_<?php echo ($key+1); ?>_<?php echo ($k+1); ?>" type="text" class="form-control" name="videoapi_ep_name[<?php echo ($key+1); ?>][<?php echo ($k+1); ?>]" value="<?php echo esc_attr( $v->title ) ?>">
							        </div>
									<div class="form-group col-lg-8">
									    <label for="videoapi_ep_link_<?php echo ($key+1); ?>_<?php echo ($k+1); ?>">Link: </label>
									    <input class="form-control" type="text" id="videoapi_ep_link_<?php echo ($key+1); ?>_<?php echo ($k+1); ?>" name="videoapi_ep_link[<?php echo ($key+1); ?>][<?php echo ($k+1); ?>]" style="width:100%" value="<?php echo esc_attr( $v->url ) ?>" />
									</div>
									<div class="form-group col-lg-12">
									    <label>Subs: </label><a style="cursor: pointer;" class="add_new_sub" data-ep="<?php echo ($k+1); ?>"  data-server="<?php echo ($key+1); ?>"><span class="dashicons dashicons-plus"></span></a>
									    <div id="videoapi_subs_<?php echo ($key+1); ?>_<?php echo ($k+1); ?>">
									    
								    	</div>
								    </div>
								    <a style="margin-left: -1px;position: absolute;margin-top: -15px;cursor: pointer;right: 2px;" class="del_ep"><span class="dashicons dashicons-no"></span></a>
								</div>
								<?php 
								}
							}
						?>
				    </div>
		        </div>
		        <?php 
		        		} 
		        	}
		        ?>
		    </div>
		<?php
				}
			}
		}
		exit;
	}
}

/** Ajax player */

add_action( 'wp_ajax_videoapi_get_player', 'videoapi_get_player' );
add_action( 'wp_ajax_nopriv_videoapi_get_player', 'videoapi_get_player' );
if( !function_exists('videoapi_get_player'))
{
	/**
	 * get player for plugin
	 * @time   2017-04-28T13:39:11+0700
	 * @author HaiLong
	 * @return string
	 */
	function videoapi_get_player() {
		$postID = $_POST['post_id'];
		$server = $_POST['server'];
		$episode = $_POST['episode'];
		$pluginsURL = plugin_dir_url( __FILE__ );
		$key = esc_attr(get_option('videoapi_key_videoapi'));
		$result = '';
		if($key)
		{
			$api = 'https://videoapi.io/api/getlink?key='.$key.'&return=data&link=';
			$videoapiMetaPost = get_post_meta( $postID, '_videoapi', true );
			$data = json_decode($videoapiMetaPost);
			$dataPlayer = array();
			if(isset($data[$server-1]->videoapi_server_data[$episode-1]))
			{
				$dataPlayer = $data[$server-1]->videoapi_server_data[$episode-1];
			}
			else if(isset($data[0]->videoapi_server_data[0]))
			{
				$dataPlayer = $data[0]->videoapi_server_data[0];
			}
			if($dataPlayer && isset($dataPlayer->videoapi_ep_link))
			{
				$isCache =  esc_attr(get_option('videoapi_is_cache'));
				// check isset cache
				$folderCache = ABSPATH . 'wp-content/videoapi_cache';
				$timeCache = esc_attr(get_option('videoapi_time_cache'));
				if(!$timeCache)
				{
					$timeCache = 10800;
				}
				$cache = new cache($folderCache,$timeCache);
				if($isCache)
				{
					$cacheData = $cache->readCache($dataPlayer->videoapi_ep_link);
					if($cacheData)
					{
						$data = json_decode($cacheData);
					}
					else
					{
						//$apiURL = $api.$dataPlayer->videoapi_ep_link.'&cache=false'; // no cache
						$apiURL = $api.$dataPlayer->videoapi_ep_link;
						$curl = curl($apiURL);
						$data = json_decode($curl);
					}
					
				}
				else
				{
					$apiURL = $api.$dataPlayer->videoapi_ep_link;
					$curl = curl($apiURL);
					$data = json_decode($curl);
				}
				if(isset($data->sources) && $data->sources)
				{
					// set cache 
					if($isCache)
					{
						$cache->saveCache($dataPlayer->videoapi_ep_link,json_encode($data));
					}
					$sources = json_encode($data->sources);
					$poster = get_post_meta( $postID, '_videoapi_poster', true );
					$videoapi_poster = ($poster) ? $poster : '';
					$videoapi_subs = (isset($dataPlayer->videoapi_ep_subs)) ? $dataPlayer->videoapi_ep_subs : '';
					$image = '';
					if($videoapi_poster)
					{
						$image = $videoapi_poster;
					}
					elseif(wp_get_attachment_url( get_post_thumbnail_id($postID) ))
					{
						$image = wp_get_attachment_url( get_post_thumbnail_id($postID) );
					}
					elseif(isset($data->image) && $data->image)
					{
						$image = $data->image;
					}
					else
					{
						$image = esc_attr(get_option('videoapi_poster'));
					}
					$tracks = '[';
					if($videoapi_subs)
					{
						$subs = '';
						foreach ($videoapi_subs as $key => $value) {
							$subs .= '{file: "'.$pluginsURL.'read-sub.php?file='.trim($value->videoapi_ep_sub_file).'",label: "'.trim($value->videoapi_ep_sub_label).'",kind: "captions","default": '.trim($value->videoapi_ep_sub_default).' },';
						}
						if($subs)
							$tracks .= substr($subs, 0, -1);
					}
					$tracks .= ']';
					$download = '';
					if(esc_attr(get_option('videoapi_download')) == 'true')
					{
						$download = 'playerVideoAPI.addButton(
							"'.$pluginsURL.'player/jwplayer/images/icon-download.png",
							"Download Video",
							function() {
							    window.location.href = playerVideoAPI.getPlaylistItem()["file"]+"&type=video/mp4&title='.get_the_title($postID).'";
							},
							"download"
						);';
					}
					else
					{
						$download = '';
					}
					$replaceURL = '?sv='.$server.'&ep='.($episode+1);

					$result .= '<script type="text/javascript">
					jQuery(document).ready(function($) {
						jwplayer.key="'.esc_attr(get_option('videoapi_key_jwplayer')).'";
						var playerVideoAPI = jwplayer("videoapi-player");
				      	playerVideoAPI.setup({
							sources: '.$sources.',
							image: "'.$image.'",
							abouttext: "'.esc_attr(get_option('videoapi_abouttext')).'",
		    				aboutlink: "'.esc_attr(get_option('videoapi_aboutlink')).'",
							width: "'.esc_attr(get_option('videoapi_width')).'",
					        height: "'.esc_attr(get_option('videoapi_height')).'",
					        aspectratio: "16:9",
						    fullscreen: "'.esc_attr(get_option('videoapi_fullscreen')).'", 
							autostart: "'.esc_attr(get_option('videoapi_autostart')).'",
							logo: {
								"file": "'.esc_attr(get_option('videoapi_logo')).'",
								"link": "'.esc_attr(get_option('videoapi_logo_link')).'",
								"position": "top-left",
							},
							skin: {
					        	name: "videoapi",
					        	url: "'.$pluginsURL.'player/jwplayer/videoapi.min.css",
					        },
					        tracks: '.$tracks.',
						});
						'.$download.'
						playerVideoAPI.onComplete(function() {
							var autonext = $.cookie("videoapi_autonext");
							if (autonext === undefined || autonext === null) {
							    autonext = 1;
							}
							if(autonext == 1)
							{
								var position = $("#videoapi-list-server").find(".active").data("position");
								if(position != "last")
								{
									var data = {
										"action": "videoapi_get_player",
										"post_id": '.$postID.',
										"server": '.$server.',
										"episode": '.($episode+1).',
									};
									window.history.pushState("", "", "'.$replaceURL.'");
									$("html,body").animate({scrollTop: $("#videoapi-player").offset().top - 50},"slow");
									$("#videoapi-player").html("");
									$(".videoapi-btn").removeClass("active");
									$(".videoapi-info-'.$server.'-'.($episode+1).'").addClass("active");
									jQuery.post(ajax_object.ajax_url, data, function(response) {
										$("#videoapi-player").html(response);
									});
								}
							}
						});
					});	
					</script>';
				}
				else
				{
					$result .= '<div class="player-error"><p>Get API error. Please check link.</p></div>';
				}
			}
			else
			{
				$result .= '<div class="player-error><p>Get data error.</p></div>';
			}
		}
		else
		{
			$result .= '<div class="player-error"><p style="color:red">Please add key videoapi.io.</p></div>';
		}
		echo $result;
		exit();
	}
}
?>