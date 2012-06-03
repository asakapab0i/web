<?php
include('include.php');

echo drawFirst();

echo draw_div('row',
	draw_div('span3', 'Date goes here') . 
	draw_div('span7', drawForm('wysihtml5-321')) .
	draw_div('span2', '&nbsp;')
);

echo draw_div('row',
	draw_div('span3', 'Monday, Feburary 7') . 
	draw_div('span7', '
		<p>Rutrum eros arcu lorem eros arcu enim ultricies bibendum magna ultricies ipsum porta ornare odio mauris diam. Et donec porttitor ultricies et mauris massa gravida lorem bibendum ipsum sem cursus porta rutrum eu ultricies. Quisque porttitor diam amet lorem sapien lectus commodo nibh orci eu ut eget sit curabitur pellentesque massa auctor sapien integer leo. Tempus sodales adipiscing eu nibh auctor quam elementum eros lorem metus leo at quisque ut lectus molestie vulputate ultricies massa sed nam massa ut. Eros elementum nibh ligula donec ultricies ornare adipiscing tellus integer pharetra sapien sagittis sapien sed vitae ut porttitor amet sapien enim in at. Ligula at lorem rutrum amet enim rutrum diam sit nulla lorem sed non sed proin eros mattis porttitor proin duis diam.</p>
		<p>Molestie proin ornare sed enim risus sed auctor donec enim elementum. Curabitur eu vivamus massa nam mauris orci eros nulla vivamus pharetra. Nam metus lectus vulputate gravida molestie vivamus orci cursus molestie proin sagittis nam sed quam adipiscing nam morbi nec malesuada leo at lorem. Malesuada sapien lorem gravida sed lorem magna adipiscing nam sem sapien.</p>
		<p>Ultricies morbi maecenas mauris amet et integer massa curabitur enim magna gravida ut proin ornare eu quam odio proin justo sit orci. Sem auctor orci porttitor auctor eu sodales a integer pharetra odio in magna adipiscing auctor sem non ut at sed vivamus molestie eget elementum. Integer rutrum lorem nec et rutrum odio enim tempus morbi. Ultricies rutrum risus eros ligula diam adipiscing sed maecenas ipsum adipiscing at sit. Quam eros diam auctor cursus pellentesque at vivamus porttitor sapien ipsum tellus risus rutrum maecenas pellentesque ut vivamus leo odio vivamus nam magna nec nibh.</p>	
	') . 
	draw_div('span2', '&nbsp;')
);
echo drawLast();