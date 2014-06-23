<?php
    /* 
        Email customers script. 

    */
     ob_start();
    //start or continue a session.
    session_start();
    include("scripts/conn.php");
     
    
       if(isset($_POST['chk_email']))
       {
          $emailList = $_POST['chk_email'];
          
          $num1 = sizeof($emailList) - 2; //used to get the size of array - 1 
  								       //this is so we can build a multiline var with a end.
          $num2 = sizeof($emailList) - 1; //Used to get size of array starting on 0.
          $to="";
    
          for($i = 0; $i <= $num1; $i++)
	      {
	         //Loads to variable with possible multiple email addresses.
	         $to .= $emailList[$i] . ", ";
	      }
	      //closes the to variable with the ending email address minus the coma.
	      $to .= $emailList[$num2];
       }
       else
       {
       	  $to = "";
       }
       //echo "To variable is now " . $to;
?>
<!DOCTYPE html>
<html>
<head>
<title>Email Customers.</title>
<script type="text/javascript" src="scripts/jScript.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js" ></script>
<script type="text/javascript" src="scripts/jquery.tablesorter.js"></script> 
<link rel="stylesheet" href="scripts/style.css" type="text/css" />
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
   	  if(!isset($_GET['action']))
      {  
   ?>
<div id="content" name="content" align="center">
      <h2><b>Email Our Customer's</b></h2>
	  </div><br /><br />
<?php include('scripts/menu.php'); ?>
  <div align="center">
  <note>We should really limit access to email addresses linked to customers only, as if a malicious
  user got access to the system they could use this page to send out spam email in your name.  We can
  update this page after you have had some time to look it over and check functionality.</note>
    <form name="emailCustomers" id="frmEmailCust" action="emailCust.php?action=send" method="post">
      <table name="emailCustomers" id="tblEmailCust" border="1">
      <tr><th><label for='txtTo'>To:</label></th>
      <td><input type="text" id="txtTo" name="sendTo" size="100" value="<?php echo $to; ?>" /></td></tr>
      <tr><th><label for='txtsubject'>Subject:</label></th>
      <td><input type="text" size="35" id="txtSubject" name="emailSubject" /></td></tr>
      <tr><th><label for='txtMessage'>Message:</label></th>
      <td><textarea name="emailMessage" id="txtMessage" rows="25" cols="60"></textarea></td></tr>
      <tr><td><input type="reset" style="background-color: blue; color: white;" /></td><td align="center"><input type="submit" style="background-color: blue; color: white;" /></td></tr>
      </table>
    </form>
  </div>
  <?php
  }
  else if($_GET['action'] == "send")
  {
      // To send HTML mail, the Content-type header must be set
      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

      // Additional headers
      $headers .= 'From: Barry Buckemoff <eddie.power@icloud.com>' . "\r\n";
      $to = $_POST["sendTo"];
      
      $msg = '<!DOCTYPE html><html><head>
				<title>Email From Barry Buckemoff</title>
				<link rel="stylesheet" href="scripts/style.css" type="text/css" />
				<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"></head><body>';
      $msg .=  $_POST["emailMessage"];
      $msg .= '</body></html>';
      $subject = $_POST["emailSubject"];
      
      //echo "In area where form will be sent!<br />To: " . $to . "<br />Subject: " . $subject . "<br />Message: " . $msg;
      
      if(mail($to, $subject, $msg, $headers))
      {
        echo "Mail Sent has been sent.";
        header('Location: customer.php');
      }
      else
      {
        echo "Error Sending Mail";
      }
    
  }
?>
<div id="footer" align="center"> &copy; 2013 Barry Buckemoff.</div>
</body>
</html>
<?php
      }//end of login check
?>