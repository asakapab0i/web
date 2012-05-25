function scrollFinished(num) {
	document.getElementById('counter').innerHTML = format_zeropad(num, 2);
}

function splashInit() {
	$('#splash').click(splashFade);
	timer = setTimeout(splashFade, 4000);
}

function splashFade() {
	clearTimeout(timer);
    $('#splash').css({opacity: 1.0}).animate({opacity: 0.0}, 1000, function() { 
		$('#splash').addClass('disappeared');
	    $('#left').css({opacity: 0.0}).animate({opacity: 1.0}, 1000, showRandom);
    });
}

function showRandom() {
	var $random = $('#random IMG');
	if ($random.width() == 593) $random.addClass('small');
	$random.css({opacity: 0.0}).animate({opacity: 1.0}, 1000, function() {});
}

function galleryInit() {
	$('#description').jScrollPane({scrollbarOnLeft:true, dragMaxHeight:20, scrollbarWidth:5 });
	$('#description').animate({opacity: 1.0}, 400);
	imageShowing = 1;
    $('#slideshow img').click(function(){ $('a.next').click(); });
    var $active = $('#slideshow IMG.active');
    if ($active.length == 0) {
    	$active = $('#slideshow IMG:first');
    	$active.addClass('active');
    }
    if ($active.width() == 593) $active.addClass('small');
    $active.css({opacity: 0.0}).animate({opacity: 1.0}, 500, function() { });
    switching = false;
}

jQuery(document).ready(function($) {
	var switching = false;
	
	//$('a[href=*.pdf]').each().attr('target', '_blank');
	
	$('a.next').click(function(e) {
		e.preventDefault();
		if (switching) return false;
	    switching = true;
	    
	    var $active = $('#slideshow IMG.active');
	    if ($active.length == 0) $active = $('#slideshow IMG:last');
	    var total = $active.siblings().length + 1;
	    if (total == 1) return;
	    if ($active.next().length) {
			imageShowing++;
	    	var $next = $active.next();
	    } else {
			imageShowing = 1;
	    	var $next = $('#slideshow IMG:first');
	    }
	    if ($next.width() == 593) $next.addClass('small');
	    $active.addClass('last-active');
		$active.css({opacity: 1.0}).removeClass('active last-active').animate({opacity: 0.0}, 500, function() {
	    	document.getElementById('gallery_counter').innerHTML = format_zeropad(imageShowing, 2);
	        $next.css({opacity: 0.0}).addClass('active').animate({opacity: 1.0}, 500, function() { switching = false; });
		});
	});
	
	$('a.back').click(function(e) {
		e.preventDefault();
		if (switching) return false;
	    switching = true;
	    
	    var $active = $('#slideshow IMG.active');
	    if ($active.length == 0) $active = $('#slideshow IMG:first');
	    var total = $active.siblings().length + 1;
	    if ($active.prev().length) {
			imageShowing--;
	    	var $next = $active.prev();
	    } else {
			imageShowing = total;
			var $next = $('#slideshow IMG:last');
	    }
	    if ($next.width() == 593) $next.addClass('small');
	    $active.addClass('last-active');
		$active.css({opacity: 1.0})
	        .removeClass('active last-active')
	        .animate({opacity: 0.0}, 500, function() {
	        	document.getElementById('gallery_counter').innerHTML = format_zeropad(imageShowing, 2);
	            $next.css({opacity: 0.0})
			        .addClass('active')
			        .animate({opacity: 1.0}, 500, function() {
					    switching = false;
			    	});
			});
	});
});


