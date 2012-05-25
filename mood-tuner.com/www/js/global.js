$(function(){

	var $container = $("div.wrapper");
	
	$container.isotope({
		itemSelector : "div.module",
		animationEngine: 'jquery',
		masonry : {
			columnWidth : 332
		}
	});
	
	$container.delegate("div.expandable", "click", function(){
		$("div.module.expanded").addClass("expandable").removeClass("expanded");
		$(this).addClass("expanded").removeClass("expandable");
		$container.isotope("reLayout");
		$(this).find('.jscrollpane').jScrollPane({showArrows:false});
	});
	
	$("div.module.signup form").submit(function(){
		var email = $(this).find("input#email").val();
		if (email.length) {
			$.ajax({
				url 		: "/ajax/signup.php",
				type		: "POST",
				data		: { email : email },
				success	: function(){
					$("div.module.signup form").html('<div class="result">Thank you</div>');
				}
			});
		}
		return false;
	});
});