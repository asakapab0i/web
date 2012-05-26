jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery('div.fancy a').wrap('<div class="white" />');
	jQuery('body.home').click(function() {
		location.href='/about/';
	});
});