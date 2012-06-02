<?php
include('../include.php');

echo drawFirst('Room Service');

echo draw_div('column', 
	draw_img('/images/contact/exterior.jpg')
) . 
draw_div('column span2', 
	draw_div('row',
		draw_div('column span2 big', 'We are happily established in the sunny Potrero Hill neighborhood of San Francisco and loving our new home in Los Angeles.')
	) . 
	draw_div('row',
		draw_div('column', '
			<h2>San Francisco</h2>

			<p>550 15th Street, suite M18<br>
			San Francisco, CA 94103<br>
			By appointment only</p>
			
			<p>telephone: <a class="inherit" href="tel:4152852821">415 285 2821</a><br>
			facsimile: 415 366 2241</p>
		') . 
		draw_div('column', '
			<h2>Los Angeles</h2>

			<p>3976 Witzel Drive<br>
			Los Angeles, CA 90232<br>
			By appointment only</p>
			
			<p>telephone: <a class="inherit" href="tel:3108761060">310 876 1060</a><br>
			facsimile: 310 943 0494</p>
		')
	) . 
	draw_div('row',
		draw_div('column', '
			<h2>Media</h2>

			<p>Alisa Carroll<br>
			CPR<br>
			telephone: <a class="inherit" href="tel:4156900626">415 690 0626</a><br>
			' . draw_link('mailto:alisa@carrollpr.com', false, false, 'inherit') . '<br>
			<a href="http://www.carrollpr.com/" class="inherit">www.carrollpr.com</a></p>
		') . 
		draw_div('column', '
			<h2>Email</h2>

			<p>' . draw_link('mailto:info@coddingtondesign.com', false, false, 'inherit') . '</p>
		')
	) . 
	draw_div('row',
		draw_div('column span2', '

		<p>Enter your email address below to receive our newsletter:</p>
		
		<!-- Begin MailChimp Signup Form -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
		<script type="text/javascript" src="http://downloads.mailchimp.com/js/jquery.validate.js"></script>
		<script type="text/javascript" src="http://downloads.mailchimp.com/js/jquery.form.js"></script>
		<script type="text/javascript" src="mailchimp.js"></script>
		<div id="mc_embed_signup">
			<form action="http://coddingtondesign.us1.list-manage.com/subscribe/post?u=d701356e709075c66545567e5&amp;id=a782662c28" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
				<fieldset>
					<div class="mc-field-group">
						<label for="mce-EMAIL">Email Address </label>
						<input type="text" value="" name="EMAIL" class="required email" id="mce-EMAIL"/>
					</div>
					<div id="mce-responses">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>
					<div><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn"/></div>
				</fieldset>	
			</form>
		</div>
		<!--End mc_embed_signup-->
		
		<ul class="social">
			<li>' . draw_img('/images/contact/twitter.png', 'http://twitter.com/coddington_m', true) . '</li>
			<li>' . draw_img('/images/contact/facebook.png', 'http://www.facebook.com/#!/pages/Coddington-Design/95408380822?ref=ts', true) . '</li>
			<li>' . draw_img('/images/contact/pinterest.png', 'http://pinterest.com/mcoddington/', true) . '</li>
		</ul>
		')
	)
);

echo drawLast();