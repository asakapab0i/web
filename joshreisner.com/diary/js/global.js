$(function(){
	/* initialize editor */
	var editor = new wysihtml5.Editor("textarea", {
		toolbar:      "toolbar",
		stylesheets:  "/css/editor.css",
		parserRules:  wysihtml5ParserRules
	});
	
});