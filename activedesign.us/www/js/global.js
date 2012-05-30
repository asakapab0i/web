function slideshowTransitionStarted($el) {
	$("div.facts div.inner").fadeOut(200, function() {
		var caption = $el.find("li.selected img").attr("alt");
		$(this).html(caption).fadeIn(200);	
	});
}

$(function(){
	/* home hero carousel */
	$(".hero .carousel div.item").first().addClass("active");
	$(".hero ul.controller li").first().addClass("active");
	$(".hero .carousel").carousel({interval:5000, pause:"hover"});
	
	$(".hero .carousel").on("slid", function(){
		var listItem = $(this).find("div.item.active");
		var index = $(this).find("div.item").index(listItem) + 1;
		$(".hero ul.controller li.active").removeClass("active");
		$(".hero ul.controller li.option" + index).addClass("active");
		var caption = $(".hero .carousel div.active img").attr("alt");
		//alert(caption);
		$(".facts .inner").html(caption);
	});
	
	$(".hero ul.controller li").on("click", function() {
		$(".hero .carousel").carousel("pause");
		$(this).addClass("active");
		var slidenumber = $(this).html() - 1;
		$(".hero .carousel").carousel(slidenumber);		
	});

	$(".hero .facts").on("click", function(){
		location.href = $("div.carousel div.item.active a").attr("href");
	});
	
	/* gallery carousel */
	$(".gallery.carousel div.item").first().addClass("active");
	$(".gallery.carousel").carousel();
	
	/* in the news filter */
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