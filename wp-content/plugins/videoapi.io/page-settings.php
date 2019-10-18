<?php 
if( !function_exists('videoapi_register_mysettings'))
{
	/**
	 * Enqueue file for admin page and register settings group.
	 * @time   2017-04-28T13:43:41+0700
	 * @author HaiLong
	 * @return null
	 */
	function videoapi_register_mysettings() {
	    register_setting( 'videoapi-settings-group', 'videoapi_key_videoapi' );
		register_setting( 'videoapi-settings-group', 'videoapi_key_jwplayer' );
		register_setting( 'videoapi-settings-group', 'videoapi_logo' );
		register_setting( 'videoapi-settings-group', 'videoapi_logo_link' );
		register_setting( 'videoapi-settings-group', 'videoapi_width' );
		register_setting( 'videoapi-settings-group', 'videoapi_height' );
		register_setting( 'videoapi-settings-group', 'videoapi_download' );
		register_setting( 'videoapi-settings-group', 'videoapi_fullscreen' );
		register_setting( 'videoapi-settings-group', 'videoapi_autostart' );
		register_setting( 'videoapi-settings-group', 'videoapi_abouttext' );
		register_setting( 'videoapi-settings-group', 'videoapi_aboutlink' );
		register_setting( 'videoapi-settings-group', 'videoapi_poster' );
		register_setting( 'videoapi-settings-group', 'videoapi_auto_add_post' );
		register_setting( 'videoapi-settings-group', 'videoapi_is_cache' );
		register_setting( 'videoapi-settings-group', 'videoapi_time_cache' );
	}
	add_action( 'admin_init', 'videoapi_register_mysettings' );
}

if( !function_exists('videoapi_settings_page'))
{
	/**
	 * settings page
	 * @time   2017-04-28T13:46:12+0700
	 * @author HaiLong
	 * @return string
	 */
	function videoapi_settings_page() {
		$plugins_url = plugin_dir_url( __FILE__ );
		?>
		<style type="text/css">
		#wpfooter{position: inherit !important;}
		input[type=checkbox], input[type=radio]{margin: 0!important}
		pre {white-space: pre-wrap !important;white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;word-wrap: break-word;}
		</style>
		<div class="wrap-bootstrap">
			    <div class="panel panel-border panel-primary">
			        <div class="panel-heading">
			            <h1 class="panel-title">VideoAPI.io</h1>
			        </div>
			        <div class="panel-body">
			        	<p>VideoAPI.io is a web service that provides you services get link from google drive, google photo, youtube, facebook,... and from many other sources. You only need to send the original link to us will return the link mp4 to add movie players like jwplayer, videojs... Very fast and stable is what we want to bring you.</p>
                    </div>
			        <div class="panel-body">
			        	<div class="col-lg-8">
                            <form method="post" action="options.php" >
                                <?php settings_fields( 'videoapi-settings-group' ); ?>
							    <?php do_settings_sections( 'videoapi-settings-group' ); ?>
							    <?php 
									$get_videoapi_key_videoapi =  esc_attr(get_option('videoapi_key_videoapi'));
									$get_videoapi_key_jwplayer =  esc_attr(get_option('videoapi_key_jwplayer'));
									$get_videoapi_logo =  esc_attr(get_option('videoapi_logo'));
									$get_videoapi_logo_link =  esc_attr(get_option('videoapi_logo_link'));
									$get_videoapi_width =  esc_attr(get_option('videoapi_width'));
									$get_videoapi_height =  esc_attr(get_option('videoapi_height'));
									$get_videoapi_aspectratio =  esc_attr(get_option('videoapi_download'));
									$get_videoapi_fullscreen =  esc_attr(get_option('videoapi_fullscreen'));
									$get_videoapi_autostart =  esc_attr(get_option('videoapi_autostart'));
									$get_videoapi_abouttext =  esc_attr(get_option('videoapi_abouttext'));
									$get_videoapi_aboutlink =  esc_attr(get_option('videoapi_aboutlink'));
									$get_videoapi_poster =  esc_attr(get_option('videoapi_poster'));
									$get_videoapi_auto_add_post =  esc_attr(get_option('videoapi_auto_add_post'));
									$get_videoapi_is_cache =  esc_attr(get_option('videoapi_is_cache'));
									$get_videoapi_time_cache =  esc_attr(get_option('videoapi_time_cache'));

									$videoapi_key_videoapi = ($get_videoapi_key_videoapi) ? $get_videoapi_key_videoapi : '';
									$videoapi_key_jwplayer = ($get_videoapi_key_jwplayer) ? $get_videoapi_key_jwplayer : 'XYS/ica6YQUMq9rC6J2E77obUFoIPLeM';
									$videoapi_logo = ($get_videoapi_logo) ? $get_videoapi_logo : '';
									$videoapi_logo_link = ($get_videoapi_logo_link) ? $get_videoapi_logo_link : '';
									$videoapi_width = ($get_videoapi_width) ? $get_videoapi_width : '640px';
									$videoapi_height = ($get_videoapi_height) ? $get_videoapi_height : '380px';
									$videoapi_download = ($get_videoapi_aspectratio) ? $get_videoapi_aspectratio : 'true';
									$videoapi_fullscreen = ($get_videoapi_fullscreen) ? $get_videoapi_fullscreen : 'true';
									$videoapi_autostart = ($get_videoapi_autostart) ? $get_videoapi_autostart : 'false';
									$videoapi_abouttext = ($get_videoapi_abouttext) ? $get_videoapi_abouttext : '';
									$videoapi_aboutlink = ($get_videoapi_aboutlink) ? $get_videoapi_aboutlink : '';
									$videoapi_poster = ($get_videoapi_poster) ? $get_videoapi_poster : '';
									$videoapi_auto_add_post = ($get_videoapi_auto_add_post) ? $get_videoapi_auto_add_post : '';
									$videoapi_is_cache = ($get_videoapi_is_cache) ? $get_videoapi_is_cache : '';
									$videoapi_time_cache = ($get_videoapi_time_cache) ? $get_videoapi_time_cache : '';
								?>
								<div class="card-box">
									<h3>Default Settings</h3>
						        	<div class="form-group col-lg-6">
						        		<label>VideoAPI Key - <a href="https://videoapi.io/panel/config" target="_blank">Get Key</a></label>
						        		<input class="form-control" name="videoapi_key_videoapi" value="<?php echo $videoapi_key_videoapi; ?>" placeholder="Text" />
						        	</div>
						        	<div class="form-group col-lg-12">
						        		<label>Auto add to post:</label>
						        		<input type="checkbox" class="form-control" name="videoapi_auto_add_post" value="1" <?php echo ($videoapi_auto_add_post == 1) ? "checked" : '' ?> />
						        	</div>
						        	<div class="form-group col-lg-12">
						        		<label>Cache:</label>
						        		<input type="checkbox" class="form-control" name="videoapi_is_cache" value="1" <?php echo ($videoapi_is_cache == 1) ? "checked" : '' ?> />
						        	</div>
						        	<div class="form-group col-lg-2">
						        		<label style="display: block">Time Cache:</label>
						        		<input type="text" class="form-control" name="videoapi_time_cache" value="<?php echo ($videoapi_time_cache) ? $videoapi_time_cache : '10800' ?>"/>
						        	</div>
						        	<div class="form-group col-lg-12"></div>
						        	<div class="clear"></div>
						        </div>
					        	<div class="card-box">
						        	<h3>Player Settings</h3>
						        	<div class="form-group col-lg-5" style="margin-right: 20px">
						        		<label>JWplayer Key</label>
						        		<input class="form-control" name="videoapi_key_jwplayer" value="<?php echo $videoapi_key_jwplayer; ?>" placeholder="Text" />
						        	</div>
						        	<div class="form-group col-lg-6">
						        		<label>Fullscreen</label>
						        		<input class="form-control" name="videoapi_fullscreen" value="<?php echo $videoapi_fullscreen; ?>" placeholder="true/false"  />
						        	</div>
						        	<div class="form-group col-lg-5" style="margin-right: 20px">
						        		<label>Width</label>
						        		<input class="form-control" name="videoapi_width" value="<?php echo $videoapi_width; ?>" placeholder="px or %" />
						        	</div>
						        	<div class="form-group col-lg-6">
						        		<label>Height</label>
						        		<input class="form-control" name="videoapi_height" value="<?php echo $videoapi_height; ?>" placeholder="px or %" />
						        	</div>
						        	<div class="form-group col-lg-5" style="margin-right: 20px">
						        		<label>Download Button</label>
						        		<input class="form-control" name="videoapi_download" value="<?php echo $videoapi_download; ?>" placeholder="true/false" />
						        	</div>
						        	<div class="form-group col-lg-6">
						        		<label>Auto Start</label>
						        		<input class="form-control" name="videoapi_autostart" value="<?php echo $videoapi_autostart; ?>" placeholder="true/false" />
						        	</div>
						        	<div class="form-group col-lg-5" style="margin-right: 20px">
						        		<label>Logo File URL</label>
						        		<input class="form-control" name="videoapi_logo" value="<?php echo $videoapi_logo; ?>" placeholder="URL" />
						        	</div>
						        	<div class="form-group col-lg-6">
						        		<label>Logo Link</label>
						        		<input class="form-control" name="videoapi_logo_link" value="<?php echo $videoapi_logo_link; ?>" placeholder="URL" />
						        	</div>
						        	<div class="form-group col-lg-5" style="margin-right: 20px">
						        		<label>About Text</label>
						        		<input class="form-control" name="videoapi_abouttext" value="<?php echo $videoapi_abouttext; ?>" placeholder="Text" />
						        	</div>
						        	<div class="form-group col-lg-6">
						        		<label>About Link</label>
						        		<input class="form-control" name="videoapi_aboutlink" value="<?php echo $videoapi_aboutlink; ?>" placeholder="URL" />
						        	</div>
						        	<div class="form-group col-lg-5">
						        		<label>Poster Default</label>
						        		<input class="form-control" name="videoapi_poster" value="<?php echo $videoapi_poster; ?>" placeholder="URL" />
						        	</div>
							        <div class="form-group col-lg-8">
				                		<?php submit_button('Save Settings', 'btn btn-primary btn-custom waves-effect w-md waves-light m-b-5'); ?>
				                	</div>
				                	<div class="clear"></div>
				                </div>
							</form>
						</div>
		                <div class="col-lg-4">
		                	<div class="card-box">
			                	<h3>About</h3>
			               		<p>Version: 1.1</p>
			               		<p>This plugins wordpress by <a target="_blank" href="https://videoapi.io">VideoAPI.io</a></p>
			               		<p><a href="https://docs.videoapi.io/#plugin_wordpress" target="_blank">Documentation</a></p>
			               		<hr>
								<pre>Short code: [videoapi]</pre>
								<pre>PHP:<br>&lt;?php echo do_shortcode('[videoapi]'); ?&gt;</pre>
								<p>Please disable <strong>Auto add to post</strong> when using short code.</p>
							</div>
							<div class="card-box">
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
													$title = '<h4 class="text-primary">VIP '.$key.'</h5>';
													break;
												case 2:
													$class = 'success';
													$title = '<h4 class="text-primary">VIP '.$key.'</h5>';
													break;
												case 3:
													$class = 'danger';
													$title = '<h4 class="text-primary">VIP '.$key.'</h5>';
													break;
												
												default:
													$class = 'default';
													$title = '<h4 class="text-primary">Free</h5>';
													break;
											}
											echo $title;
											foreach ($value as $k => $v) {
												echo '<p class="label label-'.$class.'">'.$v.'</p> ';
											}
										}
									}
								?>
							</div>
		                </div>
		                <div class="clear"></div>
			        </div>
                </div>
		</div>
		<?php
	}
}
?>