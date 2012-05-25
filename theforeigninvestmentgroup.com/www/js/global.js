/* nested menus in FAQ */
jQuery.fn.fadeSliderToggle = function(settings) {
	settings = jQuery.extend({ speed:600, easing:"swing" }, settings);
	caller = this;
 	if ($(caller).css("display") == "none"){
		$(caller).animate({ opacity:1, height:'toggle' }, settings.speed, settings.easing);
	} else {
		$(caller).animate({ opacity:0, height:'toggle' }, settings.speed, settings.easing);
	}
};


$(document).ready(function(){

	$("body.faqs ul li span.heading").click(function(){ $(this).next().fadeSliderToggle(); });
	
	$("body.model select").change(function(){ recalculate(); });
	$("body.model input").change(function(){ recalculate(); });
	
});

function recalculate() {
	$form = $("body.model form");
	if (
		$form.find("select[name=investor_country]").val() &&
		$form.find("select[name=host_country]").val() &&
		$form.find("input[name=risk_perception]").val()
	) {
		$.ajax({
			url 	: "/ajax/distance.php",
			type	: "POST",
			data	: $form.serialize(),
			success : function(data){
				alert(data)
			}
		});
	}
}