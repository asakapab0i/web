<?php
include('../../include.php');

echo drawFirst('Price List');

function drawPayPalButton($title, $price) {
	return '
	<form class="paypal" target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_cart">
	<input type="hidden" name="business" value="melanie@coddingtondesign.com">
	<input type="hidden" name="lc" value="US">
	<input type="hidden" name="item_name" value="' . $title . '">
	<input type="hidden" name="amount" value="' . $price . '.00">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="button_subtype" value="products">
	<input type="hidden" name="add" value="1">
	<input type="hidden" name="bn" value="PP-ShopCartBF:add-to-cart.png:NonHosted">
	<input type="submit" class="submit" name="submit" value="Add to Cart">
	<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
	';
}

cms_bar_link('/login/object/?id=8', 'Services List');

$services = db_table('SELECT id, title, price, ' . db_updated() . ' FROM user_services WHERE is_active = 1 AND is_published = 1 ORDER BY precedence');
foreach ($services as &$s) {
	$s = draw_div('column', 
		draw_img(file_dynamic('user_services', 'image', $s['id'], 'jpg', $s['updated'])) . 
		draw_div('p', $s['title'] . ' &gt; $' . $s['price'] . drawPayPalButton($s['title'], $s['price']))
	);
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

echo drawLast();