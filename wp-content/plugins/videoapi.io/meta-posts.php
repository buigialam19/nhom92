<?php 
if(!function_exists('videoapi_meta_box'))
{
	/**
	 * add meta box
	 * @time   2017-04-29T10:09:43+0700
	 * @author HaiLong
	 * @return null
	 */
	function videoapi_meta_box()
	{
	 	add_meta_box( 'videoapi', 'VideoAPI.io', 'videoapi_meta_box_output', '' );
	}
	add_action( 'add_meta_boxes', 'videoapi_meta_box' );
}

if(!function_exists('videoapi_meta_box_output'))
{
	/**
	 * meta box output
	 * @time   2017-04-29T10:09:14+0700
	 * @author HaiLong
	 * @return string
	 */
	function videoapi_meta_box_output()
	{
		wp_nonce_field( 'videoapi_save_meta_posts', 'videoapi_link_nonce' );
		global $post;
		$videoapi = get_post_meta( $post->ID, '_videoapi', true );
		$videoapiPoster = get_post_meta( $post->ID, '_videoapi_poster', true );
		$videoapiGetLink = get_post_meta( $post->ID, '_videoapi_get_link', true );
		$data = json_decode($videoapi);
		$videoapi_add_link = get_post_meta( $post->ID, '_videoapi_link', true );
		$videoapi_add_subs = get_post_meta( $post->ID, '_videoapi_subs', true );
		if(!$data)
		{
			if($videoapi_add_link)
			{
				$data[0]['videoapi_server_name'] = 'Server #1';
				$data[0]['videoapi_server_data'][0]['videoapi_ep_name'] = 'Full';
				$data[0]['videoapi_server_data'][0]['videoapi_ep_link'] = $videoapi_add_link;
				if($videoapi_add_subs)
				{
					$videoapi_add_subs = json_decode($videoapi_add_subs);
					if($videoapi_add_subs)
			    	{
			    		foreach ($videoapi_add_subs as $key => $value) 
			    		{
			    			$data[0]['videoapi_server_data'][0]['videoapi_ep_subs'][$key]['videoapi_ep_sub_file'] = $value->file;
			    			$data[0]['videoapi_server_data'][0]['videoapi_ep_subs'][$key]['videoapi_ep_sub_label'] = $value->label;
			    		}
			    	}
				}
				
			}
			if($data)
			{
				$data = json_decode(json_encode($data), false);
			}
		}
		?>
		<div id="videoapi-form">
			<div class="videoapi-title"><h2>Get Link</h2></div>
			<div class="form-horizontal">
				<div class="form-group">
				    <label for="enter_link" style="display: block;">Enter Link: </label>
				    <div class="col-lg-8">
				    	<input class="form-control" type="text" id="enter_link" name="videoapi_get_link" value="<?php echo esc_attr( $videoapiGetLink ) ?>" />
				    </div>
				    <div class="col-lg-2">
				    	<input type="button" name="videoapi_getlink" id="videoapi_getlink" class="button btn btn-primary btn-custom waves-effect w-md waves-light m-b-5" value="Get Link">
				    </div>
				    <div class="col-lg-8">
				    	<span id="enter_link_note"></span>
				    </div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="videoapi-title"><h2>Poster</h2></div>
			<div class="form-horizontal">
				<div class="form-group">
				    <label for="videoapi_ep_poster" style="display: block;">Poster URL: </label>
				    <div class="col-lg-8">
				    	<input class="form-control" type="text" id="videoapi_poster" name="videoapi_poster" style="width:100%" value="<?php echo esc_attr( $videoapiPoster ) ?>" />
				    </div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="videoapi-title"><h2>Player Data</h2></div>
			<div id="videoapi-player-data">
				<ul class="nav nav-tabs" role="tablist">
					<?php 
						if($data) {
							foreach ($data as $key => $value) {
								$tabActive = ($key == 0) ? 'active' : '';
								$closeTab = ($key > 0) ? '<span> x </span>' : '';
					        	echo '<li class="'.$tabActive.'"><a href="#server_'.($key+1).'" data-toggle="tab" id="tab_title_'.($key+1).'">'.$value->videoapi_server_name.'</a>'.$closeTab.'</li>';
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
			    		if($data) {
			    			foreach ($data as $key => $value) {
			    				$tabContentActive = ($key == 0) ? 'active' : '';
			    	?>
			        <div class="tab-pane <?php echo $tabContentActive; ?>" id="server_<?php echo ($key+1); ?>" data-server="<?php echo ($key+1); ?>">
						<div id="videoapi_episodes_<?php echo ($key+1); ?>" class="form-horizontal">
							<div class="row">
								<div class="form-group col-lg-2">
						            <label for="videoapi_server_name_<?php echo ($key+1); ?>"><h3>Server Name</h3></label>
						            <input id="videoapi_server_name_<?php echo ($key+1); ?>" class="videoapi_server_name form-control" data-server="<?php echo ($key+1); ?>" type="text" name="videoapi_server_name[<?php echo ($key+1); ?>]" value="<?php echo esc_attr( $value->videoapi_server_name ) ?>">
						        </div>
						    </div>
							<h3>List Episode <a style="cursor: pointer;" class="add_new_ep" data-ep-total="<?php echo (count($value->videoapi_server_data) > 1) ? count($value->videoapi_server_data) : '1'; ?>"  data-server="<?php echo ($key+1); ?>"><span class="dashicons dashicons-plus"></span></a></h3>
							<?php 
					        	$dataServer = $value->videoapi_server_data;
					        	if($dataServer)
					        	{
					        		foreach ($dataServer as $k => $v) {
					        		?>
									<div class="videoapi_episodes episodes_<?php echo ($k+1); ?> row" data-ep="<?php echo ($k+1); ?>" data-server="<?php echo ($key+1); ?>">
								    	<div class="form-group col-lg-2" style="margin-right: 10px">
								            <label for="videoapi_ep_name_<?php echo ($key+1); ?>_<?php echo ($k+1); ?>">Episode Name</label>
								            <input id="videoapi_ep_name_<?php echo ($key+1); ?>_<?php echo ($k+1); ?>" type="text" class="form-control" name="videoapi_ep_name[<?php echo ($key+1); ?>][<?php echo ($k+1); ?>]" value="<?php echo esc_attr( $v->videoapi_ep_name ) ?>">
								        </div>
										<div class="form-group col-lg-9">
										    <label for="videoapi_ep_link_<?php echo ($key+1); ?>_<?php echo ($k+1); ?>">Link: </label>
										    <input class="form-control" type="text" id="videoapi_ep_link_<?php echo ($key+1); ?>_<?php echo ($k+1); ?>" name="videoapi_ep_link[<?php echo ($key+1); ?>][<?php echo ($k+1); ?>]" style="width:100%" value="<?php echo esc_attr( $v->videoapi_ep_link ) ?>" />
										</div>
										<div class="form-group col-lg-12">
										    <label>Subs: </label><a style="cursor: pointer;" class="add_new_sub" data-ep="<?php echo ($k+1); ?>"  data-server="<?php echo ($key+1); ?>"><span class="dashicons dashicons-plus"></span></a>
										    <div id="videoapi_subs_<?php echo ($key+1); ?>_<?php echo ($k+1); ?>">
										    <?php 
										    	if(isset($v->videoapi_ep_subs) && $v->videoapi_ep_subs)
										    	{
										    		foreach ($v->videoapi_ep_subs as $s => $sub) 
										    		{
										    			?>
										    			<div class="videoapi_subs" style="margin-bottom: 10px">
														    <label>Label: </label> <input type="text" name="videoapi_ep_sub_label[<?php echo ($key+1); ?>][<?php echo ($k+1); ?>][<?php echo $s; ?>]" style="width:15%" value="<?php echo esc_attr( $sub->videoapi_ep_sub_label ) ?> " />
														    <label style="margin-left: 5%;">File: </label> <input type="text" name="videoapi_ep_sub_file[<?php echo ($key+1); ?>][<?php echo ($k+1); ?>][<?php echo $s; ?>]" style="width:60%" value="<?php echo esc_attr( $sub->videoapi_ep_sub_file ) ?> " /><a style="margin-left: 5px;position: absolute;margin-top: 10px;cursor: pointer;" class="del_sub"><span class="dashicons dashicons-no"></span></a>
														</div>
										    			<?php
										    		}
										    	}
										    ?>
									    	</div>
									    </div>
									    <a style="margin-left: -1px;position: absolute;margin-top: -15px;cursor: pointer;right: 2px;" class="del_ep"><span class="dashicons dashicons-no"></span></a>
									</div>
									<?php 
									}
								}
								else
								{
									?>
									<div class="videoapi_episodes episodes_1 row" data-ep="1" data-server="<?php echo ($key+1); ?>">
								    	<div class="form-group col-lg-2" style="margin-right: 10px">
								            <label for="videoapi_ep_name_1">Episode Name</label>
								            <input id="videoapi_ep_name_1" type="text" class="form-control" name="videoapi_ep_name[<?php echo ($key+1); ?>][1]" value="">
								        </div>
										<hr>
										<div class="form-group col-lg-9">
										    <label for="videoapi_ep_link_1_1">Link: </label>
										    <input class="form-control" type="text" id="videoapi_ep_link_1_1" name="videoapi_ep_link[<?php echo ($key+1); ?>][1]" style="width:100%" value="" />
										</div>
										<div class="form-group col-lg-12">
										    <label>Subs: </label><a style="cursor: pointer;" class="add_new_sub" data-ep="1" data-server="1"><span class="dashicons dashicons-plus"></span></a>
										    <div id="videoapi_subs_<?php echo ($key+1); ?>_1">
									    	</div>
									    </div>
									</div>
									<?php
								}
							?>
					    </div>
			        </div>
			        		<?php 
			        		} 
			        	}
			        	else
			        	{
			        		?>
			        		<div class="tab-pane active" id="server_1" data-server="1">
								<div id="videoapi_episodes_1" class="form-horizontal">
									<div class="form-group">
							            <label for="videoapi_server_name"><h3>Server Name</h3></label>
							            <input id="videoapi_server_name_1" type="text" class="videoapi_server_name" name="videoapi_server_name[1]" data-server="1" value="Server #1">
							        </div>
									<h3>List Episode <a style="cursor: pointer;" class="add_new_ep" data-ep-total="1"  data-server="1"><span class="dashicons dashicons-plus"></span></a></h3>
									<div class="videoapi_episodes episodes_1 row" data-ep="1" data-server="1">
								    	<div class="form-group col-lg-2" style="margin-right: 10px">
								            <label for="videoapi_ep_name_1_1">Episode Name</label>
								            <input id="videoapi_ep_name_1_1" type="text" class="form-control" name="videoapi_ep_name[1][1]" value="">
								        </div>
										<div class="form-group col-lg-9">
										    <label for="videoapi_ep_link_1_1">Link: </label>
										    <input class="form-control" type="text" id="videoapi_ep_link_1_1" name="videoapi_ep_link[1][1]" style="width:100%" value="" />
										</div>
										<div class="form-group col-lg-12">
										    <label>Subs: </label><a style="cursor: pointer;" class="add_new_sub" data-ep="1" data-server="1"><span class="dashicons dashicons-plus"></span></a>
										    <div id="videoapi_subs_1_1">
									    	</div>
									    </div>
									</div>
								</div>
							</div>
			        		<?php
			        	}
			        ?>
			    </div>
			</div>
		</div>
		<div class="wrap-bootstrap">
			<h3>Server Lists Support</h3>
			<?php 
				$getListServer = curl('https://videoapi.io/api/getListServer');
				$listServer = json_decode($getListServer);
				if($listServer)
				{
					foreach ($listServer as $key => $value) {
						switch ($key) {
							case 1:
								$class = 'primary';
								$title = '<h4 class="text-primary" style="margin:10px 0 0 0">VIP '.$key.'</h5>';
								break;
							case 2:
								$class = 'success';
								$title = '<h4 class="text-primary" style="margin:10px 0 0 0">VIP '.$key.'</h5>';
								break;
							case 3:
								$class = 'danger';
								$title = '<h4 class="text-primary" style="margin:10px 0 0 0">VIP '.$key.'</h5>';
								break;
							
							default:
								$class = 'default';
								$title = '<h4 class="text-primary" style="margin:10px 0 0 0">FREE</h5>';
								break;
						}
						echo $title;
						foreach ($value as $k => $v) {
							echo '<p class="label label-'.$class.'">'.$v.'</p> ';
						}
					}
				}
			?>
			<p class="text-danger">The difference of Google Drive Default and Google Drive VIP: Google Drive VIP hasn't got 403 errors on some networks (using IPv6). Google Drive Default crashed in some networks.</p>
		</div>
	 	<?php
	}
}
if(!function_exists('videoapi_meta_post_save'))
{
	/**
	 * save meta post
	 * @time   2017-04-29T10:10:16+0700
	 * @author HaiLong
	 * @param  int                   $post_id
	 * @return                             
	 */
	function videoapi_meta_post_save( $post_id )
	{
		if(isset($_POST['videoapi_link_nonce']))
			$videoapi_link_nonce = $_POST['videoapi_link_nonce'];
		if( !isset( $videoapi_link_nonce ) ) {
		  	return;
		}
		if( !wp_verify_nonce( $videoapi_link_nonce, 'videoapi_save_meta_posts' ) ) {
		  	return;
		}
		$videoapi_server_name = (isset($_POST['videoapi_server_name'])) ? $_POST['videoapi_server_name'] : '';
		$videoapi_ep_name = (isset($_POST['videoapi_ep_name'])) ? $_POST['videoapi_ep_name'] : '';
		$videoapi_ep_link = (isset($_POST['videoapi_ep_link'])) ? $_POST['videoapi_ep_link'] : '';
		$videoapi_ep_sub_label = (isset($_POST['videoapi_ep_sub_label'])) ? $_POST['videoapi_ep_sub_label'] : '';
		$videoapi_ep_sub_file = (isset($_POST['videoapi_ep_sub_file'])) ? $_POST['videoapi_ep_sub_file'] : '';

		$videoapi_poster = (isset($_POST['videoapi_poster'])) ? $_POST['videoapi_poster'] : '';
		$videoapi_get_link = (isset($_POST['videoapi_get_link'])) ? $_POST['videoapi_get_link'] : '';
		$input = array();
		if($videoapi_server_name)
		{
			foreach ($videoapi_server_name as $key => $value) {
				if(!$value)
				{
					$value = 'Server #'.$key;
				}
				$var['videoapi_server_name'] = esc_attr($value);
				$var['videoapi_server_data'] = array();
				if(isset($videoapi_ep_link[$key]) && $videoapi_ep_link[$key])
				{
					foreach ($videoapi_ep_link[$key] as $k => $v) 
					{
						$varData['videoapi_ep_name'] = (isset($videoapi_ep_name[$key][$k])) ? $videoapi_ep_name[$key][$k] : '';
						$varData['videoapi_ep_link'] = $v;
						$varData['videoapi_ep_subs'] = array();
						if(isset($videoapi_ep_sub_file[$key][$k]) && $videoapi_ep_sub_file[$key][$k])
						{
							$countSub = 0;
							foreach ($videoapi_ep_sub_file[$key][$k] as $s => $sub) 
							{
								$countSub++;
								$varSub['videoapi_ep_sub_file'] = trim($sub);
								$varSub['videoapi_ep_sub_label'] = (isset($videoapi_ep_sub_label[$key][$k][$s])) ? trim($videoapi_ep_sub_label[$key][$k][$s]) : '';
								$varSub['videoapi_ep_sub_kind'] = 'captions';
								$varSub['videoapi_ep_sub_default'] = ($countSub == 1) ? 'true' : 'false';
								array_push($varData['videoapi_ep_subs'], $varSub);
							}
						}
						array_push($var['videoapi_server_data'], $varData);
					}
				}
				array_push($input, $var);
			}
		}
	 	update_post_meta( $post_id, '_videoapi', json_encode($input, JSON_UNESCAPED_UNICODE));
	 	update_post_meta( $post_id, '_videoapi_get_link', $videoapi_get_link);
	 	update_post_meta( $post_id, '_videoapi_poster', $videoapi_poster);
	 	
	}
	add_action( 'save_post', 'videoapi_meta_post_save' );
}

if(!function_exists('videoapi_update_content'))
{
	/**
	 * update content wordpress
	 * @time   2017-04-29T10:11:04+0700
	 * @author HaiLong
	 * @param  [type]                   $content [description]
	 * @return [type]                            [description]
	 */
	function videoapi_update_content($content) {
		global $post;
		$videoapiMetaPost = get_post_meta( $post->ID, '_videoapi', true );
		$videoapi_content = '';
		if($videoapiMetaPost){
			$loadplayer = new LoadPlayer();
			$videoapi_content = $loadplayer->index($videoapiMetaPost, $post->ID);
		}
	 	return $videoapi_content.$content;
	}
	$get_videoapi_auto_add_post =  esc_attr(get_option('videoapi_auto_add_post'));
	if($get_videoapi_auto_add_post)
	{
		add_filter( 'the_content', 'videoapi_update_content' );
	}
}

?>