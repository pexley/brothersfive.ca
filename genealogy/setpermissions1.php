<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Set Permissions</title>
</head>

<body>
<h2>Setting TNG Permissions</h2>
<?php
echo "Attempting to set permissions on genlog.txt to 666...";
if( @chmod( "genlog.txt", 0666 ) )
	echo "success<br/>\n";
else
	echo "<strong>failed. Please perform this step manually.</strong><br/>\n";

echo "Attempting to set permissions on config.php to 666...";
if( @chmod( "config.php", 0666 ) )
	echo "success<br/>\n";
else
	echo "<strong>failed. Please perform this step manually.</strong><br/>\n";

echo "Attempting to set permissions on importconfig.php to 666...";
if( @chmod( "importconfig.php", 0666 ) )
	echo "success<br/>\n";
else
	echo "<strong>failed. Please perform this step manually.</strong><br/>\n";

echo "Attempting to set permissions on logconfig.php to 666...";
if( @chmod( "logconfig.php", 0666 ) )
	echo "success<br/>\n";
else
	echo "<strong>failed. Please perform this step manually.</strong><br/>\n";

echo "Attempting to set permissions on pedconfig.php to 666...";
if( @chmod( "pedconfig.php", 0666 ) )
	echo "success<br/>\n";
else
	echo "<strong>failed. Please perform this step manually.</strong><br/>\n";
?>
</body>
</html>
