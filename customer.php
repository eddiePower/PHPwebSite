<?php
     ob_start();
    //start or continue a session.
    session_start();
    include("scripts/conn.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>Customer page</title>
<script type="text/javascript" src="scripts/jScript.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js" ></script>
<script type="text/javascript" src="scripts/jquery.tablesorter.js"></script> 
<link rel="stylesheet" href="scripts/style.css" type="text/css" />
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<link href="scripts/bootstrap.css" rel="stylesheet" media="screen">
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
      <h3>Customer Table Details</h3>
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
    $stmt = $dbh->prepare("select * from customer order by cust_gname");
    $stmt->execute(); 
  ?>
  <?php include('scripts/menu.php'); ?>
  <p align="center">To sort the customers click on the heading you wish to sort by.</p>
   <table id="myTable" class="tablesorter" align="center" border="1">
   <thead> 
  <tr>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Street name</th>
    <th>Suburb</th>
    <th>State</th>
    <th>Post code</th>
    <th>Email Address</th>
    <th>Phone</th>
    <th>Mobile</th>
    
    <th>Delete Customer</th>
    <th>Email Customer</th>
    
  </tr>
  </thead>
  <tbody>
<?php
	
  while ($row = $stmt->fetch())
  {
    echo "<tr>";
    echo "<td><a href='editCust.php?id=" . trim($row[0]) . "'>" . trim($row[1]) . "</a></td>";
    echo "<td>" . trim($row[2]) . "</td>";
    echo "<td>" . trim($row[3]) . "</td>";
    echo "<td>" . trim($row[4]) . "</td>";
    echo "<td>" . trim($row[5]) . "</td>";
    echo "<td>" . trim($row[6]) . "</td>";
    echo "<td>" . trim($row[7]) . "</td>";
    echo "<td>" . trim($row[8]) . "</td>";
    echo "<td>" . trim($row[9]) . "</td>";

    echo "<td align='center'><a href='editCust.php?cust_id=" . trim($row[0]) . "&edit=delete'>Delete Customer</a></td>";
    echo "<form id='email_cust' method='post' action='emailCust.php'>";
    echo "<td align='center'><input type='checkbox' name='chk_email[]' value='" . trim($row[7]) . "' /></td>";
    
    echo "</tr>";
  }
?>
   </tbody>
  </table>
  <br />
  <br />  
  <table id="linxTbl" name="links" border="1" align="center">
    <tr>
      <td><input type="submit" id="sbmt_emails" class="btn btn-primary" value="Email Selected Customers" /></td>
      <td><input type="reset" id="reset_emails" class="btn btn-primary" value="clear selected" /></td>
      <td><ul id="randMenu" class="topmenu"><li class="topmenu"><a href="editCust.php" title="Create a new customer." style="height:32px;line-height:32px;">
	   <img src="images/blue_circle-man.png" alt=""/>New Customer</a></li></ul></td>
	   <td><ul id="randMenu" class="topmenu"><li class="topmenu"><a href="#content" title="Click to go back to the top of this page." style="height:32px;line-height:32px;">
	        <img src="images/blue_circle-arrow-up.png" alt=""/>Top of page</a></li></ul></td>
      <td colspan="3" align="center"><a href="javascript:showAltCode()" target="_blank"><image src="images/codebuttoncustomer.jpg" id="img_showCustCode" /></a></td>
    </tr>
  </table>
  
  
  </form>
  <?php
      $stmt->closeCursor();
  ?>
  <div id="footer" align="center"> &copy; 2013 Barry Buckemoff.</div>
</body>
</html>
<?php
}//end check login else!
?>