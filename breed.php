<?php
     ob_start();
    //start or continue a session.
    session_start();
    include("scripts/conn.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>Breeds Page</title>
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
<div id="content" align="center">
      <h3>Breed Table Details</h3>
    </div>
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
    $stmt = $dbh->prepare("select * from breed order by breed_name");
    $stmt->execute(); 
    include('scripts/menu.php'); 
  ?>
   <table id="breedTable" class="tablesorter">
   <thead>
  <tr>
    <th>Breed Name</th>
    <th>Delete Breed</th>
  </tr>
  </thead>
  <tbody>
<?php
  while ($row = $stmt->fetch())
  {
    echo "<tr>";
    echo "<td><a href='editBreed.php?id=$row[0]'>$row[1]</a></td>";
    echo "<td><a href='editBreed.php?id=$row[0]&q=delete'>Delete Breed</a></td>";
    echo "</tr>";
  }
?>
  </tbody>
  </table>
 <br /><br />
  <table id="linxTbl" name="links" border="1" align="center">
    <tr>
      <td><ul id='randMenu' class='topmenu'><li class="topmenu">
	      <a href="editBreed.php?q=createNew" title="Add new Breed" style="height:32px;line-height:32px;">
	      <img src="images/new.png" alt=""/>Breed</a>
	</li></ul></td><td><ul id='randMenu' class='topmenu'><li class="topmenu">
	<a href="#content" title="Click to go back to the top of this page." style="height:32px;line-height:32px;">
	<img src="images/blue_circle-arrow-up.png" alt=""/>Top of page</a></li></ul></td>
      <td colspan="3" align="center"><a href="javascript:showAltCode()" target="_blank"><image src="images/codebuttonbreed.jpg" id="img_showHorseCode" /></a></td>
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