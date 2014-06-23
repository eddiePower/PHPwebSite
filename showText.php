<!DOCTYPE html>
<html>
<head>
<title>Show Text Page</title>
<script type="text/javascript" src="scripts/jScript.js"></script>
<link rel="stylesheet" href="scripts/style.css" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>
<?php
	if(isset($_GET['filename']))
	{
	   $text = $_GET['filename'];
	?>
      <body onload="loadurl('scripts/<?php echo $text; ?>')">
      <div align="center"><a href="docs.php">Back to Documentation.</a></div>
<?php
	   
	}
	else
	{
?>
<body>
Sorry There was a problem with the loading of the text please try right click on the link and 
download it or Save As to your local machine.
<?php
}//end else from if text name is set!
?>
<pre>
<div id="output" align="center"></div>
</pre>
<div align="center"><a href="docs.php">Back to Documentation.</a></div>
</body>
</html>