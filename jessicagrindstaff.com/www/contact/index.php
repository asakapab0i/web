<?php include("../include.php");
drawTop("Contact Jessica");
?>
<h1>Contact Jessica</h1>
<?php if ($_POST) {
	$_POST["email"] = preg_replace("/\r/", "", $_POST["email"]); 
	$_POST["email"] = preg_replace("/\n/", "", $_POST["email"]);
	mail("jessicagrindstaff@gmail.com", "message from your website", $_POST["message"], "From: " . $_POST["email"] . "\n\n");
	//mail("josh@joshreisner.com", "message from your website", $_POST["message"], "From: " . $_POST["email"] . "\n\n");
?>
	You've just sent me an email.  Thank you!  I'll get back to you shortly.<br><br>
	- Jessica
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php }else{?>	
	<input type="text" class="field" name="email">(your email address)
	<br><br>
	<textarea class="field" name="message"></textarea>
	<br><br>
	<input type="submit" class="button" value="  contact jessica  ">
	<br><br><br><br>
<?php }
drawBottom(); 
?>