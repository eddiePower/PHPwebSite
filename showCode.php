<?php
     session_start();
	 //checks if there is now filename sent over then
	 // it will be assigned the index.php page to prevent
	 // errors.
	  if($_GET['file'])
	  {
        $file = $_GET['file'];
      }
      else
      {
        $file = "index.php";
      }
	  echo highlight_linenums($file);
	  echo "<a href='javascript:window.close()'>Close this Window</a>";

  	 function highlight_linenums($file)
  	 {
     	 //open file handle (filename) for reading.
     	 $handle = fopen($file, "r");
     	 $count = 1;
     	 $lines = "";

     	 //while there is 1 more line to read
     	 while ($thisone = fread($handle, "1")) 
     	 {
        	 //If there is another php code line after this then...
        	 if ($thisone == "\n") 
        	 {
           	    //add line number to page
           		$lines .= $count . "<br />";
           		$count++;
        	 }
     	 }    
     	 //close the file or handle
     	 fclose($handle);
     	 
     	 //highlight and print php file contents, line numbers appear OFF
     	 // as the html code is not looked for in the highlight_file PHP script.
     	 $contents = highlight_file($file, TRUE);   
     	 
     	 //print's all output (you could as well return $string to page if need be.)
     	 print '<table><tr><td><code>' . $lines . '</code></td><td>' . $contents . '</td></tr></table>';    
  	 }
?>
