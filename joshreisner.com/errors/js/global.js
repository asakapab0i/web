$(function(){
	$("a.refresh").on("click", errors_refresh);
	
	function errors_refresh() {
		$.ajax({
			url : '/ajax/refresh.php',
			success : function(data) {
				$("div.errors_container").html(data);
			}
		});
	}
});