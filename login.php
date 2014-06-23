<?php
	ob_start();
    //create MDS constants
    define("MONASH_DIR", "ldap.monash.edu.au");
    define("MONASH_FILTER","o=Monash University, c=au");
    
    session_start();
    $_SESSION['loginStatus'] = "false";
    $_SESSION['loginName'] = "noOne";
    $ref = $_SERVER['HTTP_REFERER'];    
?>
<html>
<head>
  <title>Buckemoff Stable's Login</title>
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
  if(empty($_POST["uname"]))
  {
?>
	<div id="header">
	<h2>Buckemoff Stable's Log In.</h2>
	</div>
    <form method="post" action="login.php">
      <center>Please log in using your Authcate Details
      </center><p />
      <table border="0" align="center" cellspacing="5">
      <tr>
        <td>Authcate Username</td>
        <td><input type="text" name="uname" size="15"></td>
        </tr><tr>
        <td>Authcate Password</td>
        <td><input type="password" name="pword" size="15"></td>
        <td><input type="hidden" name="ref" value="<?php echo $ref; ?>"</td>
      </tr>
      </table><p />
      <center>
        <input type="submit" class="btn btn-primary" value="Log in">
        <input type="reset" class="btn btn-primary" value="Reset">
      </center>
      </form>
      <?php include("scripts/menu.php"); ?>
      <div align="center" id="content">
  <?php
    if($ref == "http://triton.infotech.monash.edu.au/fit2076_22583459/ass1/index.php")
    {
       echo "<p>You clicked the log in button on the index/home page, Log in to continue.</p>";
    }
    else if($ref == "http://triton.infotech.monash.edu.au/fit2076_22583459/ass1/login.php")
    {
       $ref = "http://triton.infotech.monash.edu.au/fit2076_22583459/ass1/index.php";
       echo "<p>The Page you requested was $ref, you must log in to use that page.</p>";
    }
    else
    {
       echo "<p>The Page you requested was $ref, you must log in to use that page.</p>";
    }
  }
  else
  {
     $LDAPconn=@ldap_connect(MONASH_DIR);
     if($LDAPconn)
     {
        $LDAPsearch=@ldap_search($LDAPconn,MONASH_FILTER, "uid=" . $_POST["uname"]);

        if($LDAPsearch)
        {
           $LDAPinfo = @ldap_first_entry($LDAPconn,$LDAPsearch);
           if($LDAPinfo)
           {
              $LDAPresult= @ldap_bind($LDAPconn, ldap_get_dn($LDAPconn, $LDAPinfo), 
               $_POST["pword"]);
           }
           else
           {
              $LDAPresult = 0;
           }
        }
        else
        {
           $LDAPresult = 0;
        }
    }
    else
    {
       $LDAPresult = 0;
    }

    if($LDAPresult)
    {
      //echo "Valid User!";
      $_SESSION["loginStatus"] = "true";
      $_SESSION["loginName"] = $_POST["uname"];
      $ref = $_POST["ref"];
      //check to make sure refering page is not this page other wise
      // a returning to page loop occurs, so if the page refrence is the login
      // i set it to the index page so it will be returned to a functining page.
      if($ref == "http://triton.infotech.monash.edu.au/fit2076_22583459/ass1/login.php")
      {
         $ref = "http://triton.infotech.monash.edu.au/fit2076_22583459/ass1/index.php";
      }
      //echo $ref . "is the refrence point now!!  ";
      //send back to the page last loaded by header refesh code (not the best option)
      header("Location: $ref");
    }
    else
    {
      echo "<p align='center'>Invalid User Please try your Authcate details again.";
      echo "  This page will re direct to the login form automatically.</p>";
      header("refresh:3; url=login.php");
    }
  }
?>
</div>
<div id="footer" align="center"> &copy; 2013 Barry Buckemoff.</div>
</body>
</html>