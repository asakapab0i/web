/*
(function($) {
	$(document).ready( function() {
		var supportsAudio = !!document.createElement('audio').canPlayType, audio;
		if (supportsAudio) $("a.mp3").each(function(){ audio_player($(this)) });
		var playing = false;
		
		function audio_player($element) {
		
			//check if file exists
			var file = $element.attr('href').replace('.mp3', '');
			if (!urlExists(file + '.ogg') || !urlExists(file + '.mp3') || !urlExists(file + '.wav')) return false;
			
			//create element
			$('<i id="play" class="icon-play player" style="cursor:pointer;"><audio preload="metadata"><source src="' + file + '.ogg" type="audio/ogg"></source><source src="' + file + '.mp3" type="audio/mpeg"></source><source src="' + file + '.wav" type="audio/x-wav"></source></audio></i>').insertAfter($element);
			var audio = $element.next().find('audio').get(0);
			
			//actions on the audio element
			$(audio).bind('play',function(){
				playing = audio;
				$(this).parent().removeClass('icon-play').addClass('icon-pause');		
			}).bind('pause ended', function() {
				playing = false;
				$(this).parent().removeClass('icon-pause').addClass('icon-play');		
			});		
			
			//attach more actions
			$element.next().click(function() {	
				if (playing && playing != audio) playing.pause();
				if (audio.paused) {	audio.play(); } else { audio.pause(); }			
			});
		}

		function urlExists(url) {
		    var http = new XMLHttpRequest();
		    http.open('HEAD', url, false);
		    http.send();
		    return http.status!=404;
		}	
	});
})(jQuery);
*/