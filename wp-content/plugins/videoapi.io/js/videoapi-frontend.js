jQuery(document).ready(function($) {
	var autonext = $.cookie("videoapi_autonext");
	if (autonext === undefined || autonext === null) {
		$.cookie('videoapi_autonext', 1, { expires: 7 });
	    autonext = $.cookie("videoapi_autonext");
	}
	if(autonext == 1)
	{
		$('.videoapi-switch-input').attr("checked","checked");
	}
	$('.videoapi-switch').attr("data-autonext",autonext);
	$('.videoapi-switch').click(function(){
		var current_autonext = $('.videoapi-switch').data('autonext');
		if(current_autonext == 1)
		{
			change_autonext = 2;
		}
		else
		{
			change_autonext = 1;
		}
		$.cookie('videoapi_autonext', change_autonext, { expires: 7 });
		$('.videoapi-switch').attr("data-autonext", change_autonext);
	});
	var width_videoapi_player = $("#videoapi-wrap-player").width();
    var height_videoapi_player = (width_videoapi_player*9)/16;
    $("#videoapi-wrap-player").css({'height': height_videoapi_player});
    $(".player-error").css({'height': height_videoapi_player});
});