<?php
    //start or continue a session.
    session_start();
    include("scripts/conn.php");
?>
<!DOCTYPE html>
<head>
<title>Horse Image Slideshow</title>
<script type="text/javascript" src="scripts/jScript.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js" ></script>
<script src="scripts/jquery.cycle.lite.js" type="text/javascript"></script>
<link rel="stylesheet" href="scripts/style.css" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body onload="playImages()">
<?php
   if (checkLogin() == false)
   {
      printf("<script>location.href='login.php'</script>");
   }
   else
   {
	  echo "<p style='background:#FFFBCC; text-align: left; width: 20%;'>User: ". $_SESSION["loginName"] . " is logged in.</p>";
?>
<div id="header"> <h3>Buckemoff Horse Image Slideshow</h3></div>
<?php include('scripts/menu.php'); ?>
<p align="center">Feel free to enjoy our slideshow, it shows all image files 
 of horses from our stables over the past few years. To STOP the slide show Click the Image.</p>
<div id="content">
<?php
  $directory = 'horse_images'; 	
  try 
  {    	
	    // Styling for images	
	    echo '<div id="myslides">';	
	    foreach ( new DirectoryIterator($directory) as $item ) 
	    {			
		   if ($item->isFile()) 
		   {
			  $path = $directory . '/' . $item;	
			  echo '<img src="' . $path . '"/>';	
		   }
	    }	
	    echo '</div>';
  }	
  catch(Exception $e) 
  {
     echo 'No images found for this slideshow.<br />';	
  }
?>
</div>
<div id="footer" align="center"> &copy; 2013 Barry Buckemoff.</div>
</body>
</html>
<?php
  }//end check login else!
?>