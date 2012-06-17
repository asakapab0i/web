<html>
	<head>
		<title>Contact Erik Sanko</title>
		<style type="text/css">
			<!--
			body { margin:0px; background-color:#FFFFFF; text-align:center; }
			//-->
		</style>
		<map name="homemap">
			<area shape="rect" href="/" coords="136,70 184,86">
		</map>
	</head>
	<body>
	<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td align="center" valign="middle">
<? if ($_POST) {
	$_POST["email"] = preg_replace("/\r/", "", $_POST["email"]); 
	$_POST["email"] = preg_replace("/\n/", "", $_POST["email"]);
	mail("castironuterus@yahoo.com", "message from your website", $_POST["message"], "From: " . $_POST["email"] . "\n\n");
	//mail("josh@joshreisner.com", "message from your website", $_POST["message"], "From: " . $_POST["email"] . "\n\n");
?>
<img src="thankyou.gif" width="300" height="100" border="0" ismap usemap="#homemap">

<?}else{?>

	<table>
	<form method="post" action="/contact/">
	<tr><td><img src="email.gif" width="111" height="13" border="0"><br>
	<input type="text" class="field" name="email"  style="width:320;">
	<br><br>
	<img src="message.gif" width="111" height="13" border="0"><br>
	<textarea style="width:320; height:220;" name="message"></textarea>
	<br><br>
	<input type="submit" class="field" value="contact erik">
	</td></tr>
	</form>
	</table>
<?}?>
			</td>
		</tr>
	</table>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-80350-4";
urchinTracker();
</script>
</body>
</html>