<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Set Permissions (admin folder)</title>
</head>

<body>
<h2>Setting TNG Permissions (admin folder)</h2>
<?php
echo "Attempting to set permissions on genlog.txt to 666...";
if( @chmod( "genlog.txt", 0666 ) )
	echo "success<br/>\n";
else
	echo "<strong>failed. Please perform this step manually.</strong><br/>\n";
?>
</body>
</html>
