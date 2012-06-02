<?php
include('include.php');

echo drawFirst();

//header
echo _div('row', 
	_div('span12', _h1(false, $app_name))
);

echo _div('row',
	_div('span12', '<a class="btn btn-small refresh"><i class="icon-refresh"></i> Refresh</a>')
);

echo _div('row', _div('span12 errors_container', drawErrors()));

echo drawLast();