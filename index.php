<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Buckemoff Riding School.</title>
<script type="text/javascript" src="scripts/jScript.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js" ></script>
<script type="text/javascript" src="scripts/jquery.tablesorter.js"></script> 
<link rel="stylesheet" href="scripts/style.css" type="text/css" />
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<link href="scripts/bootstrap.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
<div id="header">
<image src="images/BukOffLogoBanner.png" id="imgLogo" alt="Buckemoff Riding School Logo.">
<?php include('scripts/menu.php'); ?>
</div>
  <div id="content">
  <h3>Home Page</h3>
  <?php   
    if(isset($_SESSION["loginName"]))
    {
       echo "<p style='background:#FFFBCC; text-align: left; width: 20%;'>User: " . $_SESSION["loginName"] . " is logged in.</p><p>";
    }
    else
    {
       echo "<p>";
    }
  ?>
  To review a Customer, Horse, Skill or Breed on this site just click the view item(item being a horse or customer etc)
  and then select the specific item you wish to edit. To create a new instance of a horse, customer etc then select the
   Add item option and enter all the required details as asked.  
  </p><p>The Customers page is a little different in it also has the ability to email either multiple or single Customers
   this is done by again viewing all customers and selecting which one/s you wish to email via a checkbox on the screen,
     you are then taken to a send email form that you can use html code to write great customer emails or newsletters.</p>
     <p>Off course all item deletions are similar you will first view all items and then click the link Delete Horse/Customer/Breed/Skill 
     which will then automatically remove the selected item from your database.  If you have any questions feel free to contact me 
     either via email or by the details we already exchanged at our initial meetings.</p>
  <p><q><i>Buckemoff Riding School is a Stable and Riding school out on the lovely property named <i>"I won a Lawsuit Ranch"</i>
  in the pictures' surrounds of the death mountain range.</i></q></p>
  <p>copyright &copy; Barry Buckemoff.</p>
  <form id="frm_showCode" name="frm_showCode">
  <input type='button' id='btn_code' name='btn_code' class='btn btn-primary' value='Show Code' onclick='showCode()' />
  </form>
  </div>
  <div id="footer" align="center"> &copy; 2013 Barry Buckemoff.</div>
 </body>
</html>