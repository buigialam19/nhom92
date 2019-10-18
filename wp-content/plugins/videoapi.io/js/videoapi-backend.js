jQuery(function ($) {
	$(document).on('keyup','.videoapi_server_name', function(){
		var server = $(this).data("server");
		var value = $(this).val();
		console.log(value);
		$('#tab_title_'+server).html(value);
	})
	
	$(".nav-tabs").on("click", "a", function (e) {
        e.preventDefault();
        if (!$(this).hasClass('add-server')) {
            $(this).tab('show');
        }
    })
    .on("click", "span", function () {
        var anchor = $(this).siblings('a');
        $(anchor.attr('href')).remove();
        $(this).parent().remove();
        $(".nav-tabs li").children('a').first().click();
    });
    // add new server
	$('.add-server').click(function (e) {
	    e.preventDefault();
	    var server = $(".nav-tabs").children().length;
	    var tabId = 'server_' + server;
	    $(this).closest('li').before('<li><a href="#server_' + server + '" id="tab_title_'+server+'">Server #'+server+'</a> <span> x </span></li>');
	    var ep = 1;
	    var new_server = '<div class="tab-pane active" id="'+tabId+'" data-server="'+server+'"><div id="videoapi_episodes_'+server+'" class="row form-horizontal"><div class="row"><div class="form-group col-lg-2"><label for="videoapi_server_name_'+server+'"><h3>Server Name</h3></label><input id="videoapi_server_name_'+server+'" type="text" class="videoapi_server_name form-control" name="videoapi_server_name['+server+']" value="Server #'+server+'" data-server="'+server+'"></div></div><h3>List Episode <a style="cursor: pointer;" class="add_new_ep" data-ep-total="1" data-server="'+server+'"><span class="dashicons dashicons-plus"></span></a></h3><div class="videoapi_episodes episodes_'+ep+' row" data-ep="'+ep+'" data-server="'+server+'"><div class="form-group col-lg-2" style="margin-right: 10px"><label for="videoapi_ep_name_'+server+'_'+ep+'">Episode Name</label><input id="videoapi_ep_name_'+server+'_'+ep+'" name="videoapi_ep_name['+server+']['+ep+']" type="text" class="form-control" value=""></div><div class="form-group col-lg-9"><label for="videoapi_ep_link_'+server+'_'+ep+'">Link: </label><input class="form-control" type="text" id="videoapi_ep_link_'+server+'_'+ep+'" name="videoapi_ep_link['+server+']['+ep+']" style="width:100%" value="" /></div><div class="form-group col-lg-12"><label>Subs: </label><a style="cursor: pointer;" class="add_new_sub" data-ep="'+ep+'" data-server="'+server+'"><span class="dashicons dashicons-plus"></span></a><div id="videoapi_subs_'+server+'_'+ep+'"></div></div></div></div></div>';
	    $('.tab-content').append('<div class="tab-pane" id="' + tabId + '" data-server="'+server+'">'+new_server+'</div>');
	   $('.nav-tabs li:nth-child(' + server + ') a').click();
	});
	
	// add new ep
	$(document).on("click", ".add_new_ep", function(){
		var ep_total = $(this).data("ep-total");
		var ep = ep_total + 1;
		$(this).data('ep-total',ep);
		var server = $(this).data("server");
		var new_ep = '<div class="videoapi_episodes episodes_'+ep+' row" data-ep="'+ep+'" data-server="'+server+'"><div class="form-group col-lg-2" style="margin-right: 10px"><label for="videoapi_ep_name_'+server+'_'+ep+'">Episode Name</label><input id="videoapi_ep_name_'+server+'_'+ep+'" name="videoapi_ep_name['+server+']['+ep+']" type="text" class="form-control" value=""></div><div class="form-group col-lg-9"><label for="videoapi_ep_link_'+server+'_'+ep+'">Link: </label><input class="form-control" type="text" id="videoapi_ep_link_'+server+'_'+ep+'" name="videoapi_ep_link['+server+']['+ep+']" style="width:100%" value="" /></div><div class="form-group col-lg-12"><label>Subs: </label><a style="cursor: pointer;" class="add_new_sub" data-ep="'+ep+'" data-server="'+server+'"><span class="dashicons dashicons-plus"></span></a><div id="videoapi_subs_'+server+'_'+ep+'"></div></div><a style="margin-left: -1px;position: absolute;margin-top: -15px;cursor: pointer;right: 2px;" class="del_ep"><span class="dashicons dashicons-no"></span></a><div class="clearfix"></div></div>';
		$('#server_'+server).find( '#videoapi_episodes_'+server ).append( new_ep );
	});
	$(document).on("click", ".del_ep", function(){
	   $(this).parent('.videoapi_episodes').remove();
	});
	// add new sub
	$(document).on("click", ".add_new_sub", function(){
		var server = $(this).data("server");
		var ep = $(this).data("ep");
		var new_sub = '<div class="videoapi_subs" style="margin-bottom: 10px"><label>Label: </label> <input  type="text" name="videoapi_ep_sub_label['+server+']['+ep+'][]" style="width:15%" value="" /><label style="margin-left: 5%;">File: </label> <input type="text" name="videoapi_ep_sub_file['+server+']['+ep+'][]" style="width:60%" value="" /><a style="margin-left: 5px;position: absolute;margin-top: 10px;cursor: pointer;" class="del_sub"><span class="dashicons dashicons-no"></span></a></div>';
		$('#server_'+server).find( '#videoapi_episodes_'+server ).find('.episodes_'+ep).find( "#videoapi_subs_"+server+"_"+ep ).append( new_sub );
	});
	$(document).on("click", ".del_sub", function(){
	   $(this).parent('.videoapi_subs').remove();
	});
	// get link
	$("#videoapi_getlink").click(function(){
		$('#enter_link_note').html('');
		var link = $('#enter_link').val();
		if(link)
		{
			$('#enter_link_note').html('<span class="text-info">Loading...</span>');
			var data = {
				'action': 'videoapi_get_link',
				'link': link
			};
			jQuery.post(videoapi_ajax_object.ajax_url, data, function(response) {
				if(response)
				{
					$("#enter_link_note").html('<span class="text-primary">Complete.</span>');
					$("#videoapi-player-data").html(response);
				}
				else
				{
					$("#enter_link_note").html('<span class="text-danger">Error.</span>');
				}
			});
		}
		else
		{
			$('#enter_link_note').html('<span class="text-danger">Please enter link.</span>');
		}
	});
});
