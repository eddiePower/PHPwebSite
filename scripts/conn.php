<?php
  $uName = "s22583459";
  $pword = "monash00";
  $dB = "oci:dbname=fit2076";

	function checkSelect($val1, $val2)
    {
      $mySelect = "";
      if($val1 == $val2)
      {
         $mySelect = " selected";
      }
      return $mySelect;
    }
  
  	function checkChecked($val1, $val2)
    {
      $myCheck = "";
      
      if($val1 == $val2)
      {
         $myCheck = " checked";
      }
      
      return $myCheck;
    }

    function checkLogin()
    {
       if(!isset($_SESSION["loginStatus"]) || $_SESSION["loginStatus"] == "false")
       {
          return false;
       }
       else
       {
          return true;
       }
    }
?>