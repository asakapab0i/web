<?php
include('../include.php');

echo drawFirst('Contact');

echo draw_div_class('side', 
	draw_img('/images/brushes.jpg', '/gallery/?id=19') . 
	draw_div_class('caption', 'Detail from <a href="/gallery/?id=19">Brushes</a>')
);

$f = new form('contact_form', false, 'send message');
$f->set_field(array('type'=>'text', 'name'=>'email', 'label'=>'your email address', 'class'=>'email required'));
$f->set_field(array('type'=>'textarea', 'name'=>'message', 'label'=>'message', 'class'=>'tinymce'));
echo $f->draw();

echo drawLast();