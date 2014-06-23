<?php
	 ob_start();
     if(!isset($_GET['action']))
    { 
      try
      {
         $dbh = new PDO($dB, $uName, $pword);
         $dbh->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
      }
      catch(PDOException $e)
      {
         echo ("Connection Error Message was: " . $e->getMessage());
      }
      $stmt1 = $dbh->prepare("select * from skill");
      $stmt1->execute() or die("Error occurred in second query execution!");
    
      if(isset($_GET['id']))
      {
         $id = $_GET['id'];
         $stmt2 = $dbh->prepare("select s.skill_id, s.skill_desc from horse h, skill s, horse_skill sk where
               h.horse_id = sk.horse_id and s.skill_id = sk.skill_id and h.horse_id = " . $id);
         $stmt2->execute() or die("An error occurred in statement 3!!");
      }
      else
      {
         $stmt2 = $dbh->prepare("select * from skill");
         $stmt2->execute() or die("An error occurred in statement 3!!");
      }
?>
<div align="center">
<h3>Horse Skills:</h3>
<form id="frmHorseSkills" action="horseSkills.php?id=<?php echo $id; ?>&action=update" method="post">

<?php   		
	
	echo "<table id='horse_skills' name='horse_skills'>";		
	//Store all skill ids to compare later
	$AllSkills;
	//Store horse specific skill ids
	$horseSkills;
	//Store all skill names for later use
	$allSkillNames;
	
	 while ($row1 = $stmt1->fetch())
     {	
        $AllSkills[] = trim($row1[0]);
	    $allSkillNames[] = trim($row1[1]);
	 }//end of inner while loop	
		
	 while ($row2 = $stmt2->fetch())
     {  
        $horseSkills[] = trim($row2[0]);
         
       $myVal = array_search(trim($row2[0]), $AllSkills);
       
       if($myVal >= 0)
       {
          echo "<tr><td align='right'><input type='checkbox' name='horseSkill_check[]' value='$AllSkills[$myVal]' checked></td><td>" . trim($row2[1]);
       	  echo "</td></tr>";
       }
	 }//end of while loop2
	
	if(isset($horseSkills))  //print out non selected skills.
	{
	   $result = array_diff($AllSkills, $horseSkills);
	 
	   foreach($result as $key => $val)
	   {
	 	  echo "<tr><td align='right'><input type='checkbox' name='horseSkill_check[]' value='" . $AllSkills[($key)] . "'></td>";
	 	  echo "<td> " . $allSkillNames[($key)] . "</td></tr>";	
	   }	
	 }
	 else //Print out all skills with no checkboxes.
	 {
	    foreach($AllSkills as $key => $val)
	    {
	 	   echo "<tr><td align='right'><input type='checkbox' name='horseSkill_check[]' value='" . $AllSkills[($key)] . "'></td>";
	 	   echo "<td> " . $allSkillNames[($key)] . "</td></tr>";	
		}
	 }
?>
<tr><td><input type="submit" class="btn btn-primary" value="Update Skills" /></td><td><input type="reset" class="btn btn-primary" value="clear all checkboxes" /></td></tr>
</form>
</table>
<br /><br />
</div>
<?php
	  $stmt->closeCursor();
    }//end of if statement for data gathering check
    else
    {
       include("scripts/conn.php");   
       try
       {
          $dbh = new PDO($dB, $uName, $pword);
          $dbh->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
       }
       catch(PDOException $e)
       {
          echo ("Error Message was: " . $e->getMessage());
       }
    
       $id = $_GET['id'];
       
       
       if(isset($_POST['horseSkill_check']))
       {
          $skillChecks = $_POST['horseSkill_check'];
           $num1 = sizeof($skillChecks) - 2; //used to get the size of array - 1
          $num2 = sizeof($skillChecks) - 1;  //Used to get size of array starting on 0.

	   $stmt = $dbh->prepare("delete from horse_skill where horse_id = " . $id);
       $stmt->execute() or die("Error occurred in skill update query no 1 execution!");
	    
	   $sql = "insert all ";
	   
	   for($i = 0; $i <= $num1; $i++)
	   {
	      //build the query including mutliple values.
          $sql .= "into HORSE_SKILL";
	      $sql .= " (\"HORSE_ID\",\"SKILL_ID\")";
	      $sql .= " values (" . $id . ", " . $skillChecks[$i] . ") ";
	   }
	   
       $sql .= "into HORSE_SKILL";
	   $sql .= " (\"HORSE_ID\",\"SKILL_ID\")";
	   $sql .= " values (" . $id . ", " . $skillChecks[$num2] . ")";
	   $sql .= " SELECT * FROM dual";
	   //echo "SQL IS NOW " . $sql;
	   $stmt1 = $dbh->prepare($sql);
       $stmt1->execute() or die("Error occurred in skill update query no 2 execution!");
	   
       //echo "<br />The values pulled in so far are " . $id . " and <br />" . var_dump($skillChecks);
          $rowCount = $stmt1->rowCount();
		if($rowCount > 0)
		{
		  echo "Skill Update worked will re direct ur butt soon";
		  header("Location: editHorse.php?id=" . $id);
		}
		else
		{
		  echo "No rows were effected by your skill update please try again.";
		}
       
     	  $stmt1->closeCursor(); 
          $stmt->closeCursor();  
           
       }
       else
       { //else if no skills are set then delete all skills from horse id.
          $stmt = $dbh->prepare("delete from horse_skill where horse_id = " . $id);
          $stmt->execute() or die("Error occurred in skill update query no 1 execution!");
          
          $stmt->closeCursor();
       }      
       
       header("Location: editHorse.php?id=" . $id);
    }//end of data processing area of if statement.

?>