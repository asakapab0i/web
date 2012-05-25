<?php
include("../include.php");
echo drawTop("Contact");
?>
<div class="column"><?=draw_img("/contact/image1.jpg")?></div>
<div class="big2">We are happily established in the sunny Potrero Hill neighborhood of San Francisco and loving our new home in Los Angeles.</div>

<ul class="contact_methods">
	<li>
	<h3>San Francisco</h3>
	
	1434 Kansas Street<br/>
	San Francisco, CA 94107<br/>
	By appointment only<br/><br/>
	
	telephone:  415 285 2821<br/>
	facsimile: 415 366 2241
	</li>
	<li>
		<h3>Los Angeles</h3>
		
		3976 Witzel Drive<br/>
		Los Angeles, CA 90232<br/>
		By appointment only<br/><br/>
		
		telephone:  310 876 1060<br/>
		facsimile: 310 943 0494
	</li>
	<li>
		<h3>Email</h3>
		<?=draw_link('mailto:info@coddingtondesign.com')?>
	</li>
</ul>


<div class="form">
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
	
	<p>Follow us online:</p>
	<p>
	<?=draw_img('twitter.png', 'http://twitter.com/coddington_m', array('class'=>'twitter'))?>
	<?=draw_img('facebook.png', 'http://www.facebook.com/#!/pages/Coddington-Design/95408380822?ref=ts', array('class'=>'facebook'))?>
	</p>
</div>
<?=drawBottom();?>