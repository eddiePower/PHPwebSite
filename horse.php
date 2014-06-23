<?php
     ob_start();
    //start or continue a session.
    session_start();
    include("scripts/conn.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>Horse's Page</title>
<script type="text/javascript" src="scripts/jScript.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js" ></script>
<script type="text/javascript" src="scripts/jquery.tablesorter.js"></script> 
<link rel="stylesheet" href="scripts/style.css" type="text/css" />
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
	<div id="content" name="content" align="center">
      <h2><u><i><b>Our Current Horse's LiveSearch.</b></i></u></h2>
      <div id="horseSearch" align="center">
        <h3>Horse Search Utility: </h3>
            Horse Name :  <input type="text" id="txtsearch" onkeyup="horseSearch()" /><input type="button" style="background-color: blue; color: white;" value="Clear Search" onclick="clean()" />
	 <p>To begin your search just type in the horse name your looking for.</p>
	 </div>
	  <div id="searchResults" align="center">
	  </div>
    </div>
    <br /><br />
    <h4 align="center">All our Horse's housed currently.</h4>
  <?php
    try
    {
      $dbh = new PDO($dB, $uName, $pword);
      $dbh->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
    }
    catch(PDOException $e)
    {
      echo ("Error Message was: " . $e->getMessage());
    }
    
    
    $stmt = $dbh->prepare("select h.horse_id, h.horse_name, h.horse_gender, h.horse_height, h.horse_image, 
    b.breed_name from horse h, breed b where h.horse_breed = b.breed_id order by horse_name");
    $stmt->execute() or die("There was a problem with the database query, please contact admin.");
  ?>
  <?php include('scripts/menu.php'); ?>
  <br />
    <p align="center">To <i>View / Edit</i> a horse's details Click on the horse name,
      To <i>Delete</i> a horse click on the Delete horse link in the last column,</p>
  <p align="center">To sort the Horse details click on the heading you wish to sort by.</p>
   <table id="myHorseTable" class="tablesorter">
   <thead>
  <tr>
    <th>Horse Name</th>
    <th>Horse Gender</th>
    <th>Horse Height</th>
    <th>Horse Image</th>
    <th>Horse Breed</th>
    <th>Delete Horse</th>
  </tr>
  </thead>
  <tbody>
<?php

  while ($row = $stmt->fetch())
  {
    echo "<tr>";
    echo "<td><a href='editHorse.php?id=" . trim($row[0]) . "'>" . trim($row[1]) . "</a></td>";
    echo "<td>" . trim($row[2]) . "</td>";
    echo "<td>" . trim($row[3]) . " Hands</td>";
    if(trim($row[4]) != NULL && trim($row[4]) != "No Image set")
    {
      echo "<td><image src='horse_images/" . trim($row[4]) . "' name='hrsImage' height='100' width='200' /></td>";
    }
    else
    {
       echo "<td>No Image</td>";
    }
    echo "<td>" . trim($row[5]) . "</td>";
    echo "<td align='center'><a href='addData.php?id=" . trim($row[0]) . "&q=delete'>Delete Horse</a></td>";
    echo "</tr>";
  }
?> 
   </tbody>
  </table>
  <br /><br />
  <table id="linxTbl" name="links" border="1" align="center">
    <tr>
      <td><ul id='randMenu' class='topmenu'><li class="topmenu"><a href="editHorse.php" title="Add a new Horse" style="height:32px;line-height:32px;">
	<img src="images/new.png" alt=""/>Horse</a></li></ul></td>
	<td><ul id='randMenu' class='topmenu'><li class="topmenu">
	<a href="#content" title="Click to go back to the top of this page." style="height:32px;line-height:32px;">
	<img src="images/blue_circle-arrow-up.png" alt=""/>Top of page</a></li></ul></td>
      <td colspan="3" align="center"><a href="javascript:showAltCode()" target="_blank"><image src="images/codebuttonhorse.jpg" id="img_showHorseCode" /></a></td>
    </tr>
  </table>
  <?php
     $stmt->closeCursor();
  ?>
  <div id="footer" align="center"> &copy; 2013 Barry Buckemoff.</div>
</body>
</html>
<?php
}//end check login else!
?>