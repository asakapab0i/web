$(function(){
	
	
});

function slideshowTransitionCompleted(element) {
	$('#title').html($(element).find('li.selected img').attr('alt'));
}
