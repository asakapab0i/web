<?php
include('../../include.php');

echo drawFirst('Price List');

cms_bar_link('/login/object/?id=8', 'Services List');
echo '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">';

$services = db_table('SELECT id, title, price, ' . db_updated() . ' FROM user_services WHERE is_active = 1 AND is_published = 1 ORDER BY precedence');
foreach ($services as &$s) {
	$s = draw_div('column', 
		draw_img(file_dynamic('user_services', 'image', $s['id'], 'jpg', $s['updated'])) . 
		draw_p($s['title'] . ' &gt; $' . $s['price'] . 
		'
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
<input type="image" class="image" src="http://coddington.joshreisner.com/images/add-to-cart.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
'
	));
}

echo draw_div('column span3', 
	draw_div('row prices',
		implode('', $services)
	) . 
	draw_div('row',
		draw_div('column', '
			<h2>Price List</h2>
			<p>You can also mail a check to our San Francisco office.  Inquire about discounts for more than one room. Please note that at the start of the design process, you will have the opportunity to indicate your budget (guidelines below) to help inform our design</p>
		') . 			
		draw_div('column bump', '
			<p>process and selections. You will have the opportunity to implement the specifications as designed or to substitute items on your own to meet your specific budget requirements. You retain control of what you purchase and when.</p>
		') . 			
		draw_div('column bump', '
			<p>Savvy Budget - up to $7500,<br>
Smart budget - up to $15,000,<br>
Posh budget - $25,000 and up.<br>
All rooms must be under 500 square feet, if your room is larger please ' . draw_link('mailto:roomservice@coddingtondesign', 'contact us') . '.</p>
		')
	)
);

echo '</form>';
echo drawLast();