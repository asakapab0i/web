<?php
include('../include.php');

if ($posting) {
	email_post();
	url_change('thankyou/');
}

echo drawTop();

echo draw_div('left', draw_img('/contact/prospect-house-hotel.jpg') . draw_div_class('caption', 'The Prospect House Hotel, after its decline.'));

$f = new form('contact', false, 'Send Message');
$f->set_field(array('type'=>'text', 'name'=>'email', 'label'=>'your email address'));
$f->set_field(array('type'=>'textarea', 'name'=>'message', 'label'=>'your message', 'class'=>'mceEditor'));
echo draw_div('page_right', draw_div_class('inner', $f->draw()));

echo drawBottom();
?>