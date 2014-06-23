<?php
	include("scripts/conn.php");
	session_start();
	$hrsName = $_GET['txtsearch'];
	
    try
    {
      $dbh = new PDO($dB, $uName, $pword);
      $dbh->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
    }
    catch(PDOException $e)
    {
      echo ("Error Message was: " . $e->getMessage());
    }
    
	//$sql = "select * from horse where horse_name like '%" . trim($hrsName) . "%' order by horse_name";
	$sql = "select h.horse_id, h.horse_name, h.horse_gender, h.horse_height, h.horse_image, 
    b.breed_name from horse h, breed b where h.horse_name like '%" . trim($hrsName) . "%' and 
    h.horse_breed = b.breed_id order by horse_name";
   	$stmt = $dbh->prepare($sql);
  	$stmt->execute() or die("There was an error with the horse search query, please contact web administrator.");
  	
  
   if ($result = $dbh->query($sql)) 
   {
    /* Check the number of rows that match the SELECT statement */
    if ($result->fetchColumn() > 0) 
    {
 ?>
 	<table border="1" align="center">
  <tr>
    <!--<th>Horse Id</th> -->
    <th>Horse Name</th>
    <th>Horse Gender</th>
    <th>Horse Height</th>
    <th>Horse Image</th>
    <th>Horse Breed</th>
  </tr>
  <?php
     while ($row = $stmt->fetch())
     {
        echo "<tr>";
        echo "<td><a href='editHorse.php?id=" . trim($row[0]) . "'>" . trim($row[1]) . "</a></td>";
        echo "<td>" . trim($row[2]) . "</td>";
        echo "<td>" . trim($row[3]) . " Hands.</td>";
        if($row[4] != NULL)
        {
           echo "<td><image src='horse_images/" . trim($row[4]) . "' name='hrsImage' height='100' width='200' /></td>";
        }
        else
        {
           echo "<td>No Image</td>";
        }
        echo "<td>" . trim($row[5]) . "</td>";
        echo "</tr>";
     }
   }
   else
   {
      echo "Horse Name " . $hrsName . " was not found, please try refine your search terms.";
      echo "<br />Please be specific in your search term";
   }
  }	

 $stmt->closeCursor();
 $result->closeCursor();
?>
  </table>