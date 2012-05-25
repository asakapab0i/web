$(function(){

	//not a mobile device
	if ($(window).width() > 480) {	
		var offset = 9;
		drawColumns();
		
		//handle window resizing 
		resize_timeout = false;
		$(window).resize(function(){ 
			$('body').addClass('resizing');
			if (resize_timeout !== false) clearTimeout(resize_timeout);
			resize_timeout = setTimeout(drawColumns, 100);
		});
	}

	setupEvents();
	
	$('a.close_all').click(function(){
		$('div.image').detach();
		$(this).hide();
	});

	var shifted = false;
	
	//key capture
	$(document).keydown(function(e){
		var current = $(document).scrollLeft();
		//alert(e.which);
		if (e.which == 39) {
			//scrolling right
			e.preventDefault();
			$('div#target div.column').each(function(){
				if ($(this).offset().left - offset > current) {
					scrollToPos($(this).offset().left - offset);
					return false;
				}
			});
		} else if (e.which == 37) {
			//scrolling left
			e.preventDefault();
			var last = 0;
			$('div#target div.column').each(function(){
				if ($(this).offset().left - offset >= current) {
					scrollToPos(last);
					return false;
				} else {
					last = $(this).offset().left - offset;
				}
			});
		} else if (e.which == 38) {
			//scroll to front
			scrollToPos(0);
		} else if (e.which == 40) {
			//scroll to back
			scrollToPos($(document).width() - $(window).width());
		} else if ((e.which == 27) || (e.which == 88)) {
			//x (or esc) to close, X to close all
			if (shifted) {
				$('a.close_all').click();
			} else {
				if ($('div#target div.image:hover').size()) {
					var image = $('div#target div.image:hover');
				} else if ($('div#target div.image.active').size()) {
					var image = $('div#target div.image.active');
				} else {
					var image = $('div#target div.image').last();
				}
	        	image.detach();
	        	if (!$('div.image').size()) $('a.close_all').hide();
			}
		} else if (e.which == 16) {
			shifted = true;
		} else {
			//alert(e.which);
		}
	}).keyup(function(evt) {
		if (e.which == 16) {
			shifted = true;
		}
	});	

	function addCol() {
		$('div#target div.column').removeClass('active');
		$('div#target').css('width', 431 * ($('div#target div.column').size() + 1)); //width = 20 left padding + 390 + 20 right padding + 1 border = 431px
		$('div#target').append('<div class="active column"></div>');
		return $('div#target div.column.active');
	}
	
	function drawColumns() {
		$('body').removeClass('resizing');
		$('div#target div.column').detach();
		var windowHeight = $(window).height() - 40;
		$currentCol = addCol(); //first column
		$('div#source').children().each(function(){
			if ((($(this).attr('id') != 'intro') && $(this).height() + $currentCol.height()) > windowHeight) {
				//widow control
				var insert = false
				if ($currentCol.children().last().hasClass('date')) {
					insert = $currentCol.children().last().clone();
					$currentCol.children().last().detach();
				}
				$currentCol = addCol(); //don't overflow, start a new column
				if (insert) $currentCol.append(insert);
			}
			$currentCol.append($(this).clone());
		});
		$currentCol.removeClass('active');
		if ($.browser.msie) $('div.column').css('height', windowHeight); //vertical scrolling fix for ie
		setupEvents();
	}
	
	function getPost(id) {
		$.ajax({
			url : '/ajax/post.php',
			type : 'POST',
			data : { id : id },
			success : function(data) {
				$('div#source').html('<div id="intro">' + $('div#intro').html() + '</div>' + data);
				drawColumns(true);
				setupEvents();
			}
		});	
	}

	function scrollToPos(x) {
		//window.scrollTo(x, 0);
		if (x < 0) x = 0;
		$.scrollTo(x, 400, {axis:'x', easing:'swing'} );
	}
	
	function setupEvents() {
		$('a.search').unbind('click');
		$('a.search').click(function(e){
			e.preventDefault();
			$('body').addClass('resizing');
			var terms = prompt('What are you looking for?', '');
			if (terms && terms.trim().length) {
				$('body').addClass('searching');
				$('a.close_all').click();
				$.ajax({
					url : '/ajax/search.php',
					type : 'POST',
					data : { terms : terms },
					success : function(data) {
						$('div#source').html('<div id="intro">' + $('div#intro').html() + '</div>' + data);
						drawColumns();
						setupEvents();
					}
				});				
			}
			$('body').removeClass('resizing');
		});
		
		/* $('#intro span.clear').click(function(e){
			e.preventDefault();
			$('body').addClass('resizing');
			$('a.close_all').click();
			$.ajax({
				url : '/ajax/clear.php',
				type : 'GET',
				success : function(data) {
					$('div#source').html('<div id="intro">' + $('div#intro').html() + '</div>' + data);
					drawColumns();
					setupEvents();
				}
			});				
			$('body').removeClass('searching');
			$('body').removeClass('resizing');
		});
		
		$('p.meta a.permalink').click(function(e){
			getPost($(this).attr('rel'));
		}); */
		
		$('p.meta a.images').unbind('click');
		$('p.meta a.images').click(function(e){
			e.preventDefault();
		    $.ajax({
		        type: 'GET',
				data : { id : $(this).attr('name') },
		        url: '/ajax/images.php',
				dataType: 'xml',
		        success: function(data) {
				    $(data).find('image').each(function () {
				    	id = $(this).find('id').text();
				    	
				    	if (!$('#image_' + id).size()) { //don't reopen a duplicate of an image
					    	width = $(this).find('width').text();
					    	height = $(this).find('height').text();
					    	
					    	width_ceiling = $(window).width() * .8;
					    	height_ceiling = $(window).height() * .8;
					    	
					    	//size images to a max of 60% of available screen real estate
					    	area = width * height;
					    	window_area = $(window).width() * $(window).height();
					    	percentage = area / window_area * 100;
					    	if (percentage > 60) {
					    		diff = 60 / percentage;
					    		width = Math.round(diff * width);
					    		height = Math.round(diff * height);
					    	}
					    						    	
					    	if (height > height_ceiling) {
					    		width = width * (height_ceiling / height);
					    		height = height_ceiling;
					    	}
	
					    	if (width > width_ceiling) {
					    		height = height * (width_ceiling / width);
					    		width = width_ceiling;
					    	}
	
					    	//draw box within area of screen, pos
					    	x = Math.floor(Math.random() * ($(window).width() - width - 40)) + 20 + $(document).scrollLeft();
							y = Math.floor(Math.random() * ($(window).height() - height - 40)) + 20 + $(window).scrollTop();
							//alert('left is ' + x + ' and top is ' + y);
					    	
					    	if ('#target') {
						    	$('#target').append('<div id="image_' + id + '" class="image" style="width:' + width + 'px; height:' + height + 'px; top:' + y + 'px; left:' + x + 'px;"><img src="' + $(this).find('filename').text() + '" width="' + width + '" height="' + height + '" border="0" alt="' + $(this).find('title').text() + '"/><img src="/assets/images/div_close.png" width="12" height="12" border="0" class="close"/></div>');
					    	} else {
						    	$('#source').append('<div id="image_' + id + '" class="image" style="width:' + width + 'px; height:' + height + 'px; top:' + y + 'px; left:' + x + 'px;"><img src="' + $(this).find('filename').text() + '" width="' + width + '" height="' + height + '" border="0" alt="' + $(this).find('title').text() + '"/><img src="/assets/images/div_close.png" width="12" height="12" border="0" class="close"/></div>');
					    	}
					    	
					        $('div.image').draggable();
					        
					        $('a.close_all').show();
					        
					        //close popup
					        $('div.image img.close').click(function(){
					        	$(this).closest('div.image').detach();
					        	if (!$('div.image').size()) $('a.close_all').hide();
					        });
					        
					        //steal focus
					        $('div.image').mousedown(function(){
						        $('div.image').removeClass('active');
					        	$(this).addClass('active');
					        });
				    	}
				    });
				}
		    });
		});	
	}
	
	/* function scrollToPost(id) {
		scrollToPos($('p.post_' + id).closest('div.column').offset().left - offset);
	} */
});