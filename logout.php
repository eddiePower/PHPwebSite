<?php   
     //to ensure you are using same session
     session_start(); 
     //destroy the session there for logging user out.
     session_destroy(); 
     //to redirect back to "index.php" after logging out
     header("location: index.php"); 
     exit();
?>