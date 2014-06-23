<?php 
     ob_start();
    //start or continue a session.
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
     <body>
      <?php
          if (checkLogin() == false)
          {
             echo "<script>location.href='login.php'</script>";
   		  }
   		  else
   		  {
	  		 echo "<p style='background:#FFFBCC; text-align: left; width: 20%;'>User: ". $_SESSION["loginName"] . " is logged in.</p>";
             if(isset($_GET['filename']))
             {
  ?>
     <div id="header" align="center">
       <h3>Horse Image: <?php echo $_GET['filename']; ?> details.</h3>
     </div>
    <?php include('scripts/menu.php'); ?>
     <div id="content" align="center">
         <h3>Horse Images Detail</h3>
       <table id="tblImgFiles" name="fileTable" border="1" class="tablesorter">
       <form id="frmImages" name="imageFrm" method="post" action="fileDetails.php?imgDel=<?php echo $_GET['filename']; ?>">
       <thead>
       <tr>
       <th>File Name:</th>
       <th>File Image:</th>
       <th>Displayed on Horse ID / Horse Name: </th>
       </tr>
       </thead>
       <tbody>
       <tr>
   <?php
       $stmt = $dbh->prepare("select horse_id, horse_name from horse where horse_image='" . $_GET['filename'] . "'");
  	   @$stmt->execute();
            
	   //echo "In Image File Details Page yay!!";
	   echo "<td><label for=''>File: " . $_GET['filename'] . "</label></td>";
	   echo "<td><image src='horse_images/" . $_GET['filename'] . "' alt='' /></td>";
	   
	   echo "<td>";
  	      while ($row = $stmt->fetch())
  		  {
  		    if($row)
  	   		{ 
	         echo "Horse ID: " . trim($row['horse_id']) . ",<br />Horse Name: " . trim($row['horse_name']);
	         echo "<br /><center><a href='editHorse.php?id=" . trim($row['horse_id']) . "'>View Horse</a></center>";
	       }
	   	   else
	       {
	   	      echo "<td>Not asigned to a horse at this time.</td>";
	       }
	     }
	     echo "</td>";
	  
	   $stmt->closeCursor();
?>
       </tr>
       <tr><td align="left"><input type="submit" class="btn btn-primary" value="Delete Image" /></td>
           <td align="right" colspan="2"><input type="button" class="btn btn-primary" value="Back to ImagesList" onclick="javascript: window.location = 'images.php';" /></td></tr>
       </tbody>
       </table>
       </form>
    </div>
    <?php
        }//end of if filename isset statement.
        else
        {
            $imgName = $_GET['imgDel'];    		
            $stmt = $dbh->prepare("update HORSE set HORSE_IMAGE=null where HORSE_IMAGE='" . $imgName . "'");
  	        @$stmt->execute();   
            $stmt->closeCursor();
		  //Delete physical file from file system of web server.
	      if(unlink("horse_images/" . $imgName))
	      {
	         echo "<h1>The image name is " . $imgName . " was deleted and removed from the db if it was aligned to a horse) </h1>";
	         header("Location: horse.php");
	      }
	      else
	      {
	         echo "<h1>The image name is " . $imgName . " was not deleted :( </h1>";
	         header("Location: horse.php");
	      }
           
        }
    ?>
    <div id="footer" align="center"> &copy; 2013 Barry Buckemoff.</div>
  </body>
</html>
<?php
}
?>