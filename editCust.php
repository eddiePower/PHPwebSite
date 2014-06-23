<?php
     ob_start();
    //start or continue a session.
    session_start();
    include("scripts/conn.php");
?>
<!DOCTYPE html>
 <html>
  <head>
   <title>Edit Customer</title>
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
      <h2>Edit / Add Customer Details.</h2>
    </div>
    <br /><br />
<?php
    include('scripts/menu.php');
    try
    {
      $dbh = new PDO($dB, $uName, $pword);
      $dbh->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
    }
    catch(PDOException $e)
    {
      echo ("Error Message was: " . $e->getMessage());
    }
    
    if(isset($_GET['id']) && !isset($_GET['edit']))
    {
       $id = $_GET['id'];
       $stmt = $dbh->prepare("select * from customer where cust_id = " . $id);
       $stmt->execute() or die(); 
        	      
      echo "<form name='frm_editCustomer' action='editCust.php?id=$id&edit=yes' method='post'>";
  	  echo "<table border='1' align='center'>";
  	  while ($row = $stmt->fetch())
  	  {   
    	echo "<tr><th><label for='txt_fname'>First Name</label></th>";
    	echo "<td><input type='textbox' id='txt_fname' name='txt_fname' size='25' value='" . str_replace("'", "&#39", trim($row[1])) . "' /></td></tr>";
    	echo "<tr><th><label for='txt_lname'>Last Name</label></th>";
    	echo "<td><input type='textbox' id='txt_lname' name='txt_lname' size='35' value='" . str_replace("'", "&#39", trim($row[2])) . "' /></td></tr>";
    	echo "<tr><th><label for='txt_street'>Street name</label></th>";
    	echo "<td><input type='textbox' id='txt_street' name='txt_street' size='35' value='" . trim($row[3]) . "' /></td></tr>";
    	echo "<tr><th><label for='txt_suburb'>Suburb</label></th>";
    	echo "<td><input type='textbox' id='txt_suburb' name='txt_suburb' size='25' value='" . trim($row[4]) . "' /></td></tr>";
    	echo "<tr><th><label for='txt_state'>State</label></th>";
    	echo "<td><input type='textbox' id='txt_state' name='txt_state' size='3' value='" . trim($row[5]) . "' /></td></tr>";
    	echo "<tr><th><label for='txt_pcode'>Post code</label></th>";
    	echo "<td><input type='textbox' id='txt_pcode' name='txt_pcode' size='4' value='" . trim($row[6]) . "' /></td></tr>";
    	echo "<tr><th><label for='txt_email'>Email Address</label></th>";
    	echo "<td><input type='textbox' id='txt_email' name='txt_email' size='40' value='" . trim($row[7]) . "' /></td></tr>";
    	echo "<tr><th><label for='txt_phone'>Phone</label></th>";
    	echo "<td><input type='textbox' id='txt_phone' name='txt_phone' size='10' value='" . trim($row[8]) . "' /></td></tr>";
    	echo "<tr><th><label for='txt_mobile'>Mobile</label></th>";
    	echo "<td><input type='textbox' id='txt_mobile' name='txt_mobile' size='15' value='" . trim($row[9]) . "' /></td></tr>";
        echo "<tr><td><input type='submit' class='btn btn-primary' value='Update' /></td><td><input type='button' class='btn btn-primary' value='Cancel' onclick='javascript:history.back()' /></td></tr>";
      }
      echo "</table></form>";
    }
    else if(isset($_GET['edit']) && isset($_GET['id']))
    {
    	$fname = $_POST['txt_fname'];
    	$lname = $_POST['txt_lname'];
    	$street = $_POST['txt_street'];
    	$suburb = $_POST['txt_suburb'];
    	$state = $_POST['txt_state'];
    	$pcode = $_POST['txt_pcode'];
    	$email = $_POST['txt_email'];
    	$phone = $_POST['txt_phone'];
    	$mobile = $_POST['txt_mobile'];
    	
    	$fname = str_replace("'", "''", $fname);
    	$lname = str_replace("'", "''", $lname);
    	
    	$id = $_GET['id'];
    	
    	$sql = "update customer set cust_id = custid_seq.nextval, cust_gname = '" .
        $fname . "', cust_fname = '" . $lname . "', cust_street = '"  . $street . 
      "', cust_suburb = '" .$suburb . "', cust_state = '" . $state . "', cust_postcode = '" .$pcode . 
      "', cust_email = '" . $email . "', cust_phone = '" . $phone . "', cust_mobile = '" . $mobile .
      "' where cust_id = " . $id;

        //echo $sql;
        
        $stmt = $dbh->prepare($sql); 
          
        @$stmt->execute() or die("There was a problem with the update customer details process, please contact website admin."); 
  	      
        $stmt->closeCursor();      
        header('Location: customer.php');
    }
    else if(isset($_GET['edit']) && $_GET['edit'] == 'add')
    {
    	$fname = $_POST['txt_fname'];
    	$lname = $_POST['txt_lname'];
    	$street = $_POST['txt_street'];
    	$suburb = $_POST['txt_suburb'];
    	$state = $_POST['txt_state'];
    	$pcode = $_POST['txt_pcode'];
    	$email = $_POST['txt_email'];
    	$phone = $_POST['txt_phone'];
    	$mobile = $_POST['txt_mobile'];
    	
       // echo "!!!!!!!!!!IN ADD CUSTOMER AREA OF IF STATEMENT!!!!!!!!@#@!!!";
		//echo "And the name sent was " . $fname . " " . $lname ." and the street was " . $street;
		
      $stmt = $dbh->prepare("insert into customer values(CUSTID_SEQ.nextval, '" . addslashes($fname) . "', '" . addslashes($lname) . 
      "', '". $street . "', '" . $suburb . "', '" . $state . "',  '" . $pcode . "' , '" .$email . "', '" . $phone . "', '" . $mobile . "')");
  	  $stmt->execute() or die(); 
  	      
      $stmt->closeCursor();
      header('Location: customer.php');
    }
    
    else if(isset($_GET['cust_id']) && $_GET['edit'] == 'delete')
    {
    	$id = $_GET['cust_id'];
    	//echo "IN THE DELETE FUNCTION";
        $stmt = $dbh->prepare("delete from customer where cust_id=" . $id);
	    $stmt->execute() or die(); 
	      
	    $stmt->closeCursor();
        header('Location: customer.php');	    
    }
 
    else
    {
    ?>     
    <table border="1" align="center">
     <form name='frm_AddCustomer' action='editCust.php?edit=add' method='post'>
     <tr><th><label for='txt_fname'>First Name</label></th>
     <td><input type='textbox' id='txt_fname' name='txt_fname' size='25' value='' /></td></tr>
     <tr><th><label for='txt_lname'>Last Name</label></th>
     <td><input type='textbox' id='txt_lname' name='txt_lname' size='35' value='' /></td></tr>
     <tr><th><label for='txt_street'>Street name</label></th>
     <td><input type='textbox' id='txt_street' name='txt_street' size='35' value='' /></td></tr>
     <tr><th><label for='txt_suburb'>Suburb</label></th>
     <td><input type='textbox' id='txt_suburb' name='txt_suburb' size='25' value='' /></td></tr>
     <tr><th><label for='txt_state'>State</label></th>
     <td><input type='textbox' id='txt_state' name='txt_state' size='3' value='' /></td></tr>
     <tr><th><label for='txt_pcode'>Post code</label></th>
     <td><input type='textbox' id='txt_pcode' name='txt_pcode' size='4' value='' /></td></tr>
     <tr><th><label for='txt_email'>Email Address</label></th>
     <td><input type='textbox' id='txt_email' name='txt_email' size='40' value='' /></td></tr>
     <tr><th><label for='txt_phone'>Phone</label></th>
     <td><input type='textbox' id='txt_phone' name='txt_phone' size='10' value='' /></td></tr>
     <tr><th><label for='txt_mobile'>Mobile</label></th>
     <td><input type='textbox' id='txt_mobile' name='txt_mobile' size='15' value='' /></td></tr>
     <tr><td><input type='submit' class="btn btn-primary" value='Update' /></td><td><input type='reset' class="btn btn-primary" value='Cancel' /></td></tr>    
<?php      
    }
?>
	</form>
  </table>
  <div id="footer" align="center"> &copy; 2013 Barry Buckemoff.</div>
  </body>
</html>
<?php
      }//end of login check
?>