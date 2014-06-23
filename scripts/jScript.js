/*
 * includes validation for all forms and also the function to fire off the 
 * show code page as required.
 *
*/

function sortGo()
{
	//Uses pre written jQuery code to call the add in
	// function of tablesorter() which allows for super easy 
	// implementation of a table column sorter/filter.
    $(document).ready(function() 
     { 
     	//runs table sorter function against the 
     	// table names required.
        $("#myTable").tablesorter({ 
        headers: { 
            9: { 
                // disable sorting by setting the property sorter to false 
                sorter: false 
            }, 
            10: { 
                // disable sorting by setting the property sorter to false 
                sorter: false 
            } 
        } 
    }); 
        $("#myHorseTable").tablesorter({ 
        headers: { 
            3: { 
                  // disable sorting by setting the property sorter to false 
                  sorter: false 
               },
            5: { 
                  // disable sorting by setting the property sorter to false 
                  sorter: false 
               }
        }
    }); 
        $("#breedTable").tablesorter({ 
        headers: { 
            1: { 
                  // disable sorting by setting the property sorter to false 
                  sorter: false 
               }
        }
    });  
        $("#skillTable").tablesorter({ 
        headers: { 
            1: { 
                  // disable sorting by setting the property sorter to false 
                  sorter: false 
               }
        }
    }); 
        $("#tblImages").tablesorter({ 
        headers: { 
            0: { 
                  // disable sorting by setting the property sorter to false 
                  sorter: false 
               }
        }
    }); 
     } 
    );
}
function playImages()
{
   $(document).ready(function(){
	  $('#myslides').cycle({
		  fit: 1, pause: 1, timeout: 3000
	  });
   });
}
//---------------HORSE FORM INPUT VALIDATION------------------
function valiCheck()
{
	var horseFrm = document.getElementById("frmEditHorse");
	var name = document.getElementById("txtHorseName").value;	
	var gend = document.getElementById("horseGender").value;  //validation not needed?
	var height = document.getElementById("txtHorseHeight").value;
	var img = $('input[type="file"]').val();	
	var breed = document.getElementById("breedSelect").value;
	
	if(name == "")
	{
	  alert("Your horse name can not be blank please try again.");
	  document.getElementById("txtHorseName").focus();
	  return 0;
	}
	else if(name.length < 2)
	{
	  alert("Is your horse name really that short?");
	  document.getElementById("txtHorseName").focus();
	  return 0;
	}
	else if(!isNaN(name))
	{
	  alert("Horse name must be made up of letters only please?");
	  document.getElementById("txtHorseName").focus();
	  return 0;
	}
	
	if(breed == "none")
	{
	  alert("Your horse breed can not be blank please try again.");
	  return 0;
	}

	
	
	if(height == "")
	{
	  alert("Your horse height can not be blank please try again.");
	  document.getElementById("txtHorseHeight").focus();
	  return 0;
	}
	else if(height.length < 2)
	{
	  alert("Is your horse height really that short?");
	  document.getElementById("txtHorseHeight").focus();
	  return 0;
	}
	else if(isNaN(height))
	{
	  alert("Horse height must be made up of numbers only please?");
	  document.getElementById("txtHorseHeight").focus();
	  return 0;
	}
	
	//alert("Horse name is " + name);
	//alert("Horse gender is " + gend);
	//alert("Horse height is " + height);
	//alert("Horse image is " + img);
	//alert("Horse breed is " + breed);
	//console.log('The form name is called ' + horseFrm.name);
	
	horseFrm.enctype = "multipart/form-data";
	horseFrm.method = "post";
	
	horseFrm.submit();
}

function clean()
{
   document.getElementById("searchResults").innerHTML = "";
   document.getElementById("txtsearch").value = "";
   document.getElementById("txtsearch").focus();
}

function loadurl(dest)
  {
    try
    {
      xmlhttp = 
        window.XMLHttpRequest?new XMLHttpRequest(): 
        new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch (e)
    {
      // browser doesn't support ajax. 
      //Some error handling would go here
    }

    xmlhttp.onreadystatechange = triggered;

    xmlhttp.open("GET", dest);

    xmlhttp.send(null);
  }

  function triggered()
  {
    if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
    {
      document.getElementById("output").innerHTML = 
        xmlhttp.responseText;
    }
  }

function horseSearch()
{
   //console.log("IN search Function!!");
   var theCommand;
   horseName = document.getElementById('txtsearch').value;
   //console.log(horseName + " is the horse name to be sent!");
   
   if (horseName == "")
   {
      document.getElementById("txtsearch").focus();
      return false;
   }
   else
   {
      theCommand = "liveSearch.php?txtsearch=";
      theCommand += horseName + "&r=" + Math.random();
      //console.log(theCommand + " is the command or page name and flag to be sent via ajax.");
   }
   request(theCommand);
}

function request(command)
{
   var XMLHttpRequestObject;
   //console.log("in request");

   if (window.XMLHttpRequest)
   {
      //console.log("in if 1");
      XMLHttpRequestObject = new XMLHttpRequest();
   }
   else if (window.ActiveXObject)
   {
      //console.log("in if 2");
      XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
   }
      //console.log(" about to configure");
      XMLHttpRequestObject.open('GET',command);
      //console.log(" about to do callback");

   XMLHttpRequestObject.onreadystatechange = function()
   {
      //console.log("readyState is now " + XMLHttpRequestObject.readyState);
	  if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
      {
	     document.getElementById("searchResults").innerHTML = XMLHttpRequestObject.responseText;
      }
   }//end of anonymous callback function
   XMLHttpRequestObject.send(null);
}

function delImage() 
{
   var myForm = document.getElementById('frmEditHorse');

   myForm.method = "post";
   myForm.submit();
}

function showCode()
{
	var myForm = document.getElementById('frm_showCode');
	var url = window.location.pathname;
	var file = url.substring(url.lastIndexOf('/')+1);
	
	//console.log("inside showCode now" + myForm.name);
	myForm.action = "showCode.php?file=" + file;
	//Used the form target to allow it to also open in a new instance of the browser
	myForm.target="_blank";
	myForm.method = "post";
	//console.log("inside showCode now" + myForm.method + " and the action is " + myForm.action);
	//console.log("File name is " + file);
	myForm.submit();
}

function showAltCode()
{
	var url = window.location.pathname;
	var file = url.substring(url.lastIndexOf('/')+1);

	// used window.open for a new window as required just needed second parameter of target.
	window.open('showCode.php?file=' + file,'_blank' );
}