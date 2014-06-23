<?php
    ob_start();
    session_start();
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
    
    if(isset($_GET['status']) && isset($_GET['id']))
    {  //if updating a current horse then do this.
       $id = $_GET['id'];
       $horse_name = $_POST['txtHorseName'];
	   $horse_gender = $_POST['horseGender'];
	   $horse_height = $_POST['txtHorseHeight'];
	   $horse_breed = $_POST['breedSelect'];
	   if(isset($_POST['oldImageName']))
	   {
	     $oldImage = $_POST['oldImageName'];
	   }
	   //Allow for single quotes/apostrophes
       $horse_name = str_replace("'", "''", $horse_name);
	   
	   if(isset($_FILES["txtHorseImage"]["name"]) && $_FILES["txtHorseImage"]["name"] != "")
	   {
	      $horse_image = $_FILES['txtHorseImage']["name"];
	      //echo "In first update horse if statement, used for getting horse image";
	      //echo "<br />File name for the database.  ";
	   }
	   else if(isset($oldImage) && $oldImage != " ")
	   {
	      //Deletes horse image relationship in db and sets it to null
	      // by being called in the update horse sql below.
	      $_FILES['txtHorseImage']["name"] = $oldImage;
	      $horse_image = $oldImage;
	      //echo "in update horse else if and setting file to null and file name to old image.  ";
	   }

       $stmt = $dbh->prepare("update HORSE set HORSE_NAME = '" .
       $horse_name . "', HORSE_GENDER = '" . $horse_gender . "', HORSE_HEIGHT = "  . $horse_height . 
       ", HORSE_IMAGE = '" . $horse_image . "', HORSE_BREED = '" . $horse_breed . "' where HORSE_ID = " . $id); 
          
       @$stmt->execute() or die("Error occurred on update horse, please consult web admin"); 
	 }
	 else if($_GET['q'] == 'delete' && isset($_GET['id']))
	 {  //else if deleting a horse then do this.
	    //echo "in the delete horse area peoples!!";
	    $id = $_GET['id'];
	    
	    //Used to find a image file if it exsists and then remove it.
	    $stmt1 = $dbh->prepare("select horse_image from horse where horse_id = " . $id);
        $stmt1->execute() or die("Error occurred on delete horse image file, please consult web admin");     
		while ($row = $stmt1->fetch())
  		{
		  if(unlink("horse_images/" . trim($row[0])))
	      {
	         echo "<h1>The image name is " . trim($row[0]) . " was deleted and removed from the db if it was aligned to a horse) </h1>";
	      }
	      else
	      {
	         echo "<h1>The image name is " .trim($row[0]) . " was not deleted :( </h1>";
	      }
	    }//end while loop through remove horse image
	    
	    $stmt = $dbh->prepare("delete from horse where horse_id = " . $id);
        $stmt->execute() or die("Error occurred on delete horse, please consult web admin");   
        
        $stmt->closeCursor();
        $stmt1->closeCursor();
	 }
	 else
	 {  //if creating a new horse then do this.
	 	$horse_name = $_POST['txtHorseName'];
	    $horse_gender = $_POST['horseGender'];
	    $horse_height = $_POST['txtHorseHeight'];
	    $horse_breed = $_POST['breedSelect'];
	  	$skillChecks  = $_POST['newHorseSkills'];
	  	$num1 = sizeof($skillChecks) - 2; //used to get the size of array - 1
        $num2 = sizeof($skillChecks) - 1;  //Used to get size of array starting on 0.
        //Allow for single quotes/apostrophes
        $horse_name = str_replace("'", "''", $horse_name);
        
	    if(isset($_FILES['txtHorseImage']['name']))
	    {
	       $horse_image = $_FILES['txtHorseImage']['name'];
	    }
	    else
	    {
	      //Deletes horse image relationship in db and sets it to null
	      $_FILES['txtHorseImage'] = NULL;
	    }
       
	    //echo "!!!!!!!!!!IM IN THE SECONDS INSERT NEW HORSE IF STATMENT new skills is " . var_dump($skillChecks);
	    $stmt = $dbh->prepare("insert into horse values(horseid_seq.nextval, '" . $horse_name . "', '"
        . $horse_gender . "'," . $horse_height .",'" . $horse_image ."', " . $horse_breed . ")");
          
      $stmt->execute() or die("Error occurred on update horse, please consult web admin"); 
    
      $sql = "insert all ";
	   
	   for($i = 0; $i <= $num1; $i++)
	   {
	      //build the query including mutliple values.
          $sql .= "into HORSE_SKILL";
	      $sql .= " (\"HORSE_ID\",\"SKILL_ID\")";
	      $sql .= " values (horseid_seq.currval, " . $skillChecks[$i] . ") ";
	   }
	   
       $sql .= "into HORSE_SKILL";
	   $sql .= " (\"HORSE_ID\",\"SKILL_ID\")";
	   $sql .= " values (horseid_seq.currval, " . $skillChecks[$num2] . ")";
	   $sql .= " SELECT * FROM dual";
	   
	   //echo "SQL IS NOW " . $sql;
	   $stmt1 = $dbh->prepare($sql);
       $stmt1->execute() or die("Error occurred in skill update query no 2 execution!");
       
       $stmt->closeCursor();
       $stmt1->closeCursor();
	 }
	 
	 echo var_dump($_FILES["txtHorseImage"]);
	 
	 if(isset($_FILES["txtHorseImage"]) && $_FILES["txtHorseImage"]["name"] != $oldImage)
	 {
	    $upfile = "horse_images/".$_FILES["txtHorseImage"]["name"];
	  
      if(!move_uploaded_file($_FILES["txtHorseImage"]["tmp_name"], $upfile))
      {
        echo "ERROR: Could Not Move File into Directory";
      }
      else if($_FILES["txtHorseImage"]["size"] == 0)
      {
         echo "Error with file upload, your file was too small";  
      }
      else if($_FILES["txtHorseImage"]["type"] != "image/gif" && $_FILES["txtHorseImage"]["type"] != "image/pjpeg" && 
    $_FILES["txtHorseImage"]["type"] != "image/jpeg" && $_FILES["txtHorseImage"]["type"] != "image/jpg")
      {
         echo "ERROR: File upload must be of type .jpeg/.jpg or .gif files.";
      }
	 }
	 
	 header('Location: horse.php');
      
?>
