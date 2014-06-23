<?php
     ob_start();
    //start or continue a session.
    session_start();
    include("scripts/conn.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit a Horse Form</title>
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
	<div id="content" align="center">
      <h2>Edit / Add Horse Details.</h2>
    </div>
    <br /><br />
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
    
    if(isset($_GET['id']))
    {
      $id = $_GET['id'];
      $stmt = $dbh->prepare("select * from horse where horse_id = " . $id);
  	  $stmt->execute(); 
  	  $stmt1 = $dbh->prepare("select * from breed order by breed_name");
  	  $stmt1->execute(); 
  	   
  	  //Outer while loop
  	  while ($row = $stmt->fetch())
  	  {
?>
<?php include('scripts/menu.php'); ?>
<div name="main_content" align="center">
<table id="hrsEdit" border="1">
<form name="frmEditHorse" id="frmEditHorse" action="addData.php?id=<?php echo $id ?>&status=update">
<tr><th colspan="2"><h4>Edit Horse Details:</h4></th></tr>
<td><label for="txtHorseName">Horse Name:</label></td><td><input type="text" name="txtHorseName" id="txtHorseName" size="25" value="<?php echo trim($row[1]) ?>" /></td></tr>
<tr><td><label for="horseGender">Horse Gender:</label></td>
<td align="right"><input type="radio" id="horseGender" name="horseGender" value="M" <?php echo checkChecked($row[2], 'M'); ?> >Male 
<input type="radio" name="horseGender" id="horseGender" value="F" <?php echo checkChecked($row[2], 'F'); ?> >Female</td></tr>				
<tr><td><label for="txtHorseHeight">Horse Height:</label></td><td><input type="text" name="txtHorseHeight" id="txtHorseHeight" size="5" value="<?php echo trim($row[3]) ?>" /></td></tr>
<tr><td><label for="txtHorseImage">New Horse image:</label></td><td><input type="file" id="txtHorseImage" name="txtHorseImage" size="40" value="<?php echo trim($row[4]) ?>" /></td></tr>
<input type='hidden' name='oldImageName' id='oldImageName' value='<?php echo trim($row[4]); ?>' />
<tr><td>Image Name:  </td><td>
<?php
    if($row[4] != NULL)
    {
       echo trim($row[4]);
    }
    else
    {
       echo "<input type='hidden' name='oldImageName' id='oldImageName' value='No Image set' />";
       echo "No Image set";
    }
?>
</td></tr>
<tr><td><label for="breedSelect">Horse Breed:</label></td>
<td><select name="breedSelect" id="breedSelect">
<option value="none">Please choose an option</option>
<?php
      while ($row1 = $stmt1->fetch())
      {
?>
<option value="<?php echo trim($row1[0]); ?>"  <?php echo checkSelect($row1[0], $row[5]); ?>><?php echo trim($row1[1]); ?></option>
<?php
      }//end while loop
?>
</td></tr>
<?php
    if(trim($row[4]) != NULL && trim($row[4]) != "No Image set")
    {
      echo "<tr><td><label for='txtHorseImage'>Current image:</label></td><td><image src='horse_images/" . trim($row[4]) . "' id='txtHorseImage' value='" . trim($row[4]) . "' name='txtHorseImage' /></td></tr>"; 
    }
    else
    {
       echo "<tr><td><label>Current image:</label></td><td>No Image</td></tr>";
    }
   echo "<tr><td colspan='2' align='center'><ul id='randMenu' class='topmenu'><li class='topmenu'><a href='fileDetails.php?imgDel=" . trim($row[4]) . "' title='Delete current Horse Image' style='height:32px;line-height:32px;'><img src=''images/blue_circle-trash.png' alt='' />Delete Image</a></li></ul></td></tr>";
}// end outer while loop 
?>
<tr><td><input type="button" class="btn btn-primary" value="Edit Horse" onclick="valiCheck()" /></td><td align="center">
<input type="button" class="btn btn-primary" value="Clear Form" onclick="javascript:window.location='editHorse.php'" /></td>
</tr>
</form>
</table>
<?php include("horseSkills.php"); ?>
</div>


<?php
	  $stmt->closeCursor();
      $stmt1->closeCursor();
  	 //echo "the id no is " . $id;
   }
    else
    {
      $stmt = $dbh->prepare("select * from breed order by breed_name");
  	  $stmt->execute(); 


?>
<?php include('scripts/menu.php'); ?>
<div name="content" align="center">
<table id="hrsAdd" border="1">
<form name="frmAddHorse" id="frmEditHorse" action="addData.php">
<tr><th colspan="2"><h4>New Horse Details:</h4></th></tr>
<td><label for="txtHorseName">Horse Name:</label></td><td><input type="text" name="txtHorseName" id="txtHorseName" size="25" /></td></tr>
<tr><td><label for="horseGender">Horse Gender:</label></td><td align="right"><input type="radio" name="horseGender" id="horseGender" value="M" checked>Male 
<input type="radio" name="horseGender" id="horseGender" value="F" >Female</td></tr>
<tr><td><label for="txtHorseHeight">Horse Height:</label></td><td><input type="text" name="txtHorseHeight" id="txtHorseHeight" size="5" /></td></tr>
<tr><td><label for="txtHorseImage">Horse image:</label></td><td><input type="file" name="txtHorseImage" id="txtHorseImage" size="50" /></td></tr>
<tr><td><label for="breedSelect">Horse Breed:</label></td>
<td><select name="breedSelect" id="breedSelect">
<option value="none" selected>Please choose an option</option>
<?php
      while ($row = $stmt->fetch())
      {
?>
<option value="<?php echo trim($row[0]); ?>"><?php echo trim($row[1]); ?></option>
<?php
      }//end while loop
?>
</td></tr>
</table>
<br /><br />
<table id="newHorseSkills" name="newHorseSkillTbl">
<?php
      $stmt3 = $dbh->prepare("select * from skill order by skill_desc");
  	  $stmt3->execute() or die("error occurred with the new skills query"); 
  	  
  	  while ($row1 = $stmt3->fetch())
      {
?>
<tr><td><label><?php echo trim($row1[1]); ?></label></td><td><input type="checkbox" name="newHorseSkills[]" value="<?php echo trim($row1[0]); ?>" /></td></tr>
<?php
      }
?>
<tr><td><input type="button" class="btn btn-primary" value="Add Horse" onclick="valiCheck()" /></td><td align="center"><input type="reset" class="btn btn-primary" /></td></tr>
</form>
</table>
<br />
</div>
<?php
   }//end of else statment from line 20.
      $stmt->closeCursor();
?>
<div id="footer" align="center"> &copy; 2013 Barry Buckemoff.</div>
</body>
</html>
<?php
      }//end of login check
?>