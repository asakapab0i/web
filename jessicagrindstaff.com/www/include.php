<?php
$purple  = "#BBA9B7";

function drawTop($title="jessica grindstaff") {
	global $purple;
	?><html>
	<head>
		<title><?=$title?></title>
		<link rel="stylesheet" href="/styles/screen.css"/>
		<script type="text/javascript" src="/_site/lightbox/js/prototype.js"></script>
		<script type="text/javascript" src="/_site/lightbox/js/scriptaculous.js?load=effects,builder"></script>
		<script type="text/javascript" src="/_site/lightbox/js/lightbox.js"></script>
		<link rel="stylesheet" href="/_site/lightbox/css/lightbox.css" type="text/css" media="screen" />
		<map name="navmap">
			<area shape="rect" coords="14,134   73,149" href="/">
			<area shape="rect" coords="95,134  164,149" href="/about/">
			<area shape="rect" coords="181,134 277,149" href="/artwork/">
			<area shape="rect" coords="297,134 363,149" href="/prizes/">
			<area shape="rect" coords="384,134 511,149" href="/exhibitions/">
			<area shape="rect" coords="533,134 592,149" href="/press/">
			<area shape="rect" coords="609,134 670,149" href="/links/">
			<area shape="rect" coords="691,134 783,149" href="/contact/">
		</map>			
	</head>
	<body>
		<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td rowspan="3" bgcolor="#eeeeee" width="49%"></td>
				<td rowspan="3" width="3" bgcolor="#dddddd"><img src="/spacer.gif" width="3" height="1" border="0"></td>
				<td rowspan="3" width="3" bgcolor="#cccccc"><img src="/spacer.gif" width="3" height="1" border="0"></td>
				<td width="740" bgcolor="<?=$purple?>"><img src="/top.jpg" width="800" height="150" border="0" ismap usemap="#navmap"></td>
				<td rowspan="3" width="3" bgcolor="#cccccc"><img src="/spacer.gif" width="3" height="1" border="0"></td>
				<td rowspan="3" width="3" bgcolor="#dddddd"><img src="/spacer.gif" width="3" height="1" border="0"></td>
				<td rowspan="3" bgcolor="#eeeeee" width="49%"></td>
			</tr>
			<form method="post" action="/contact/">
			<tr>
				<td height="99%" valign="top" bgcolor="#FFFCF9">
					<table width="100%" cellpadding="25" cellspacing="0" border="0"><tr><td>
<?php
}

function drawBottom() {?>
			<br><br>
			
			
						</td></tr>
					</table>
				</td>
			</tr>
			</form>
			<tr>
				<td align="center" height="40" bgcolor="#FFFCF9" class="caption">copyright &copy; <?php echo date("Y")?> jessica grindstaff</font></td>
			</tr>
		</table>
		<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
		<script type="text/javascript">
			_uacct = "UA-80350-3";
			urchinTracker();
		</script>
	</body>
</html>
<?php } ?>