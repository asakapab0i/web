function slideshowTransitionStarted($el) {
	$("div.facts div.inner").fadeOut(200, function() {
		var caption = $el.find("li.selected img").attr("alt");
		$(this).html(caption).fadeIn(200);	
	});
}

$(function(){
	$("div.facts").on("click", function(){
		location.href = $("div.carousel ul.slideshow li.selected a").attr("href");
	});
	
	$("div.in-the-news ul.dropdown-menu a").on("click", function(){
		$("ul.dropdown-menu li").removeClass("active");
		$(this).parent().addClass("active");
		$.ajax({
			url		: "/ajax/in-the-news.php",
			type	: "POST",
			data	: { category_id : $(this).attr('data-id') },
			success	: function(data){
				$("div.in-the-news div.wrapper").html(data);
			}
		});
	});
});