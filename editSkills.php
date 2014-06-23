<?php
     ob_start();
    //start or continue a session.
    session_start();
    include("scripts/conn.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit a Skill Form</title>
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
      <h2>Edit / Add Skill Details.</h2>
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
    
    if(isset($_GET['id']) && !isset($_GET['q']))
    {
      $id = $_GET['id'];
      $stmt = $dbh->prepare("select * from skill where skill_id = " . $id . " order by skill_desc");
  	  $stmt->execute(); 
?>
<?php include('scripts/menu.php'); ?>
<div name="main_content" align="center">
<table id="breedEdit" border="1">
<form name="frmEditSkill" id="frmEditSkill" action="editSkills.php?id=<?php echo $id; ?>&q=update" method="post">
<tr><th colspan="2"><h4>Edit Skill Details:</h4></th></tr>
<tr><th><label for="txtSkill">Skill Description:</label></th>
<td>
<?php
      $row1 = $stmt->fetch()
      
?>
<input type="text" id="txtSkill" name="skillDesc" value="<?php echo trim($row1[1]); ?>" /></td>
</tr><tr>
<td><input type="submit" class="btn btn-primary" /></td><td align="right"><input type="reset" class="btn btn-primary" /></td></tr>
</table>
<?php
      $stmt->closeCursor();

      }//end if statement for id check
      else if($_GET['q'] == 'update')
      {
         echo "in update skills section!!";
         
         $id = $_GET['id'];
         $sName = $_POST['skillDesc'];
         $sName = str_replace("'", "''", $sName);
         $stmt = $dbh->prepare("update skill set skill_desc = '" . $sName . "' where skill_id = " . $id);
  	     $stmt->execute() or die("Error occurred with the skill update."); 
         $stmt->closeCursor();

         header('location: skills.php');
      }
      else if($_GET['q'] == 'create')
      {
         //echo "in create new Skill section!!!";
         $sName = $_POST['skillDesc'];
         $sName = str_replace("'", "''", $sName);
         
         $stmt = $dbh->prepare("insert into skill values(skillid_seq.nextval, '" . $sName . "')");
  	     $stmt->execute() or die("Error occurred in the update of skill"); 
  	     $stmt->closeCursor();

  	     header('location: skills.php');
      }
      else if(isset($_GET['id']) && $_GET['q'] == 'delete')
      {
         echo "in the delete area of the query<br />";
         $id = $_GET['id'];
         $sql = "delete from skill where skill_id = " . $id;
         echo "<br />SQL: " . $sql;
         $stmt = $dbh->prepare($sql);
  	     $stmt->execute() or die("Error occurred in the delete of the skill.");
  	     $stmt->closeCursor();

  	     header('location: skills.php');  
      }
      else
      {
        //echo "in the blank form for new skill creation areas";        
	include('scripts/menu.php'); 
?>
	<div name="main_content" align="center">
	  <table id="skillEdit" border="1">
      <form name="frmEditSkill" id="frmEditSkill" action="editSkills.php?q=create" method="post">
		<tr><th colspan="2"><h4>Add Skill Details:</h4></th></tr>
	    <tr><th><label for="txtSkillDesc">Skill Description:</label></th><td><input type="text" id="txtSkillDesc" name="skillDesc" size="35" /></td></tr>
	    <tr><td><input type="submit" class="btn btn-primary" value="Add New Skill" /></td><td align="right"><input type="reset" class="btn btn-primary" value="Clear" /></td></tr>
		</table>
		</form>
		</div>
<?php
      }
?>
<div id="footer" align="center"> &copy; 2013 Barry Buckemoff.</div>
</body>
</html>
<?php
      }//end of login check
?>
