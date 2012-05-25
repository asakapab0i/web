<?php
include('../../include.php');
echo drawTop('E-Consulting Room Service');
?>
<div class="big">Room Service by Coddington Design empowers clients with the expertise needed to successfully take a do-it-yourself approach to interior design.</div>

<div class="column">
	<h3>The Process</h3>
	<ol>
		<li>Please email us at <?=draw_link('mailto:roomservice@coddingtondesign.com')?></li>
		<li>We will respond with a questionnaire, one that helps us to learn more about your personal style and space.  We will also provide instructions on how to measure and photograph your room.</li>
		<li>Based on the info you provide, Coddington Design will create a custom design package for your room, to include:
			<ul>
			<li>A detailed, scaled floor plan with furniture locations and dimensions</li>
			<li>Recommendations on furniture to be purchased on-line or in retail stores in your area</li>
			<li>Recommended paint colors and fabric swatches where appropriate</li>
			<li>A detailed shopping list</li>
			<li>Advice on what to keep and what to toss/donate.</li>
			</ul>
	</ol>
</div>

<div class="column">
	<h3>Details &amp; Fee</h3>
	<p>Your plan can be delivered by mail or email.</p>
	<p>Our design fee of $975 per room (excluding kitchens and baths) includes phone or e-mail support follow up with one of our designers up to 30 minutes.</p>
	
	<h3>Payment Options</h3>
	<p>Mail a check payable to Coddington Design or pay through our secure check out below.</p>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
		<input type="image" src="/images/paypal.png" width="51" height="31" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	</form>
</div>
<?=drawBottom();?>