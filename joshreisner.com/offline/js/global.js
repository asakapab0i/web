$(function(){

	//update online / offline status
	$(window).bind('online offline', changeStatus());

	function changeStatus() {
		if (window.navigator.onLine) {
			$("div#status").removeClass("offline").addClass("online").html("online");
		} else {
			$("div#status").removeClass("online").addClass("offline").html("offline");
		}	
	}
});


