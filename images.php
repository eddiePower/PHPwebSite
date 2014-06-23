<?php
     ob_start();
    //start or continue a session.
    session_start();
    include("scripts/conn.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>Horse Image Viewer page</title>
<script type="text/javascript" src="scripts/jScript.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js" ></script>
<script type="text/javascript" src="scripts/jquery.tablesorter.js"></script> 
<link rel="stylesheet" href="scripts/style.css" type="text/css" />
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<link href="scripts/bootstrap.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>
  <body onload="sortGo()">
  <?php
if (checkLogin() == false)
{
    printf("<script>location.href='login.php'</script>");
}
else
{
	echo "<p style='background:#FFFBCC; text-align: left; width: 20%;'>User: ". $_SESSION["loginName"] . " is logged in.</p>";
?>

  <div id="header" align="center">
    <h3>Contents of Horse_images directory.</h3>
  </div>
<?php include('scripts/menu.php'); ?>
  <div id="content" align="center">
    <h3>Contents of Horse_images directory.</h3>
    <p>To check if image is assigned to a horse please click the image title for more info.</p>
    <table id="tblImages" name="imagesList" border="1" class="tablesorter">
      <thead>
      <tr>
      <th>File Number:</th>
      <th align="center">File Name:</th>
      </thead>
      <tbody>
      </tr><tr>
<?php    

    $currdir = "horse_images";  
    $dir = opendir($currdir);
    $count = 1;

    while($file = readdir($dir))
    {
       if($file == "." || $file =="..")
       {
         continue;
       }
       if(is_dir($file))
       {
          echo "<td><b>" . $count . "</td><td>" . $file . "</b></td></tr>";
          $count++;
       }
       else
       {
          echo "<td>" . $count . "</td><td><a href='filedetails.php?filename=" . $file . "'>" . $file 
           . "</a></td></tr>";
          $count++;
       }
  }
  closedir($dir);
?>
        </tbody>
      </table>
      <br /><br />
       <table id="linxTbl" name="links" border="1" align="center">
    <tr>
      <td><ul id='randMenu' class='topmenu'><li class="topmenu">
      <a href="sshow.php" title="Click to view a slideshow of all images currently stored." style="height:32px;line-height:32px;">
	  <img src="images/blue_circle-media.png" alt=""/>View Slideshow</a>
	</li></ul></td><td><ul id='randMenu' class='topmenu'><li class="topmenu">
	<a href="#content" title="Click to go back to the top of this page." style="height:32px;line-height:32px;">
	<img src="images/blue_circle-arrow-up.png" alt=""/>Top of page</a></li></ul></td>
      <td colspan="3" align="center"><a href="javascript:showAltCode()" target="_blank"><image src="images/codebuttonimages.jpg" id="img_showHorseCode" /></a></td>
    </tr>
  </table>
    </div>
    <div id="footer" align="center"> &copy; 2013 Barry Buckemoff.</div>
  </body>
</html>
<?php
}//end check login else!
?>