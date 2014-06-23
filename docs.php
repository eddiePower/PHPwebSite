<?php
     ob_start();
    //start or continue a session.
    session_start();
    include("scripts/conn.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>Buckemoff Riding School Documentation.</title>
<script type="text/javascript" src="scripts/jScript.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js" ></script>
<script type="text/javascript" src="scripts/jquery.tablesorter.js"></script> 
<link rel="stylesheet" href="scripts/style.css" type="text/css" />
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<link href="scripts/bootstrap.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
<?php
if (checkLogin() == false)
{
    printf("<script>location.href='login.php'</script>");
}
else
{
	echo "<p style='background:#FFFBCC; text-align: left; width: 20%;'>User: ". $_SESSION["loginName"] . " is logged in.</p>";
?>
<div id="header">
<h4>Assignment 1 Documentation</h4>
<?php include('scripts/menu.php'); ?>
</div>
  <div id="content">
  <h4>Assignment 1 Documentation</h4>
  <table id="tblDocs" name="DocsTable" border=".5">
  <?php
     echo "<tr><th align='left'>Student Info:</th><td align='left'>Eddie Power</td></tr><tr><th align='left'>id:</th><td align='left'>22583459</td></tr>";
     echo "<tr><th align='left'>subject Name:</th><td align='left'>Web DB Interface</td></tr><tr><th align='left'>subject provider:</th><td align='left'>";
     echo "Monash University, The Faculty of Information Technology</td></tr><tr><th align='left'>Assignment number:</th><td align='left'>One</td></tr>";
     echo "<tr><th align='left'>Date of submission:</th><td align='left'>13/09/13</td></tr><tr><th align='left'>Email:</th><td align='left'>";
     echo "<a href='mailto:empow3@student.monash.edu' target='blank'>empow3@student.monash.edu</a></td></tr><tr><th align='left'>Assignment Specification:</th>";
     echo "<td align='left'><a href='http://walkabout.infotech.monash.edu.au/walkabout/fit2076/assignments/assignment1.aspx?unit=fit2076' target='blank'>Assignment Spec.</a></td></tr>";
     echo "<tr><th align='left'>Oracle login:</th><td align='left'>s22583459</td></tr><tr><th align='left'>Password:</th><td align='left'>monash00</td></tr>";
     echo "<tr><th align='left'>Create Table statements:</th><td align='left'><a href='showText.php?filename=Horsect.txt' alt='displayed using ajax on a simple html page.'>View create tables Scripts.</a>";
     echo "<br /><a href='scripts/Horsect.txt' target='blank'>Horsect.txt</a></td></tr>";
     echo "<tr><th align='left'>My Table Data:</th><td align='left'><a href='showText.php?filename=my_tables.txt' alt='Displayed using ajax on a simple page.'>View Current Table Data.</a><br />";
     echo "<a href='scripts/my_tables.txt' target='blank' alt='Download txt file from here or view txt file directly'>my_tables.txt</a></td></tr>";
     echo "<tr><th align='left'><font style='background:#FFFBCC;'>Extra Pre Written Liraries and code:</font></th><td align='left'><font style='background:#FFFBCC;'>Sort Table done with jQuery plugin jquery.tablesorter.js which also ";
     echo "<br /> requires the jQuery javascript Library which i used a link to google,<br />The Slide show also uses a jQuery plugin called jquery.cycle.lite.js.";
     echo "<br />CSS 3 generation for menu to embed image files into css somehow<br /> was done with CSS3 menu application and then customised.</font></tr>";
  ?>
  </table>
  </div>
  <div id="footer" align="center"> &copy; 2013 Barry Buckemoff.</div>
 </body>
</html>
<?php
}//end check login else!
?>