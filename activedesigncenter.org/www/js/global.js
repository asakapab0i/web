$(function(){
	/* top nav clicks */
	$(".row.top ul.nav li").on("click", function() {
		location.href = $(this).find("a").attr("href");
	});
	
	/* home hero carousel */
	$(".hero .carousel div.item").first().addClass("active");
	$(".hero ul.controller li").first().addClass("active");
	$(".hero .carousel").carousel({interval:8000, pause:"hover"});
	
	$(".hero .carousel").on("slide", function(){
		$(".hero ul.controller li.active").removeClass("active");
	});
	
	$(".hero .carousel").on("slid", function(){
		var listItem = $(this).find("div.item.active");
		var index = $(this).find("div.item").index(listItem) + 1;
		$(".hero ul.controller li.active").removeClass("active");
		$(".hero ul.controller li.option" + index).addClass("active");
	});
	
	$(".hero ul.controller li").on("click", function() {
		$(".hero .carousel").carousel("pause");
		$(this).addClass("active");
		var slidenumber = $(this).html() - 1;
		$(".hero .carousel").carousel(slidenumber);		
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
	
	/* isotope filtering on case studies */
	var $container = $("ul.case-studies");
	$container.isotope();
	$("div.case-studies-grid ul.filter a").on("click", function() {
		$(this).toggleClass('checked');
		$icon = $(this).find("i");
		if ($icon.hasClass("icon-check")) {
			$icon.removeClass("icon-check").addClass("icon-check-empty");
		} else {
			$icon.removeClass("icon-check-empty").addClass("icon-check");
		}
		var filter = new Array();
		$(this).closest("ul").find("a.checked").each(function() {
			filter[filter.length] = $(this).attr("data-filter");
		});
		if (!filter.length) filter[filter.length] = "foobar";
		$container.isotope({
			filter: filter.join(", ")
		});
		return false;
	});

	/* checklists */
	$("div.checklist li").each(function(){
		if ($(this).hasClass('highlight')) {
			$(this).html('<div class="icon"><i class="icon-check"></i></div><span class="highlight">' + $(this).html() + '</span>');		
		} else {
			$(this).html('<div class="icon"><i class="icon-check-empty"></i></div>' + $(this).html());
		}
	});

	/* cross-browser placeholder text */
	jQuery.support.placeholder = false;
	test = document.createElement('input');
	if ('placeholder' in test) jQuery.support.placeholder = true;

	if (!$.support.placeholder) { 
		var active = document.activeElement;
		$(':text').focus(function () {
			if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
				$(this).val('').removeClass('hasPlaceholder');
			}
		}).blur(function () {
			if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
				$(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
			}
		});
		$(':text').blur();
		$(active).focus();
		$('form').submit(function () {
			$(this).find('.hasPlaceholder').each(function() { $(this).val(''); });
		});
	}

});