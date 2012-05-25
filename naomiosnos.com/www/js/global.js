$(function(){
	$('ul.gallery').isotope({
		itemSelector : 'li',
		masonry: {
			columnWidth : 230
		}
	});
});

function submit_contact_form(form) { 

	$.ajax({
		url  : "/ajax/contact.php",
		type : "POST",
		data : form.serialize(),
		success : function(data) {
			$("form#contact_form").html(data);
		}
	});
	
}