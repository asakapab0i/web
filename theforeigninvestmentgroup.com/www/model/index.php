<?php
include('../include.php');
echo drawTop();

?>

<form>

<div class="field">
	Risk Perception Multiplier
	<?=draw_form_radio_set('risk_perception', array('1.15'=>'cultures are similar', '1'=>'cultures are moderately different', '.85'=>'cultures are very different'))?>
</div>

<div class="field">
	Investor Country:
	<?=draw_form_select('investor_country', 'SELECT id, title FROM user_countries WHERE is_published = 1', false, false)?>
</div>

<div class="field">
	Host Country:
	<?=draw_form_select('host_country', 'SELECT id, title FROM user_countries WHERE is_published = 1', false, false)?>
</div>

</form>

<?php
echo drawBottom();