function slideshowTransitionStarted($el) {
	var alt = $el.find("li.selected img").attr("alt");
	$("div.caption").html(alt);
}