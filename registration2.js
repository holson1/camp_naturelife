
function getXMLhttpObject(){
	
	var XMLhttp = null;

	if( window.XMLHttpRequest ){
		XMLhttp = new XMLHttpRequest();
	}else if( window.ActiveXObject){
		XMLhttp = new ActiveXObject("Microsoft.XMLHttp");
	}
	return XMLhttp;
}



function checkRegInfo(){
	
	
	XMLhttp = getXMLhttpObject();
	
	
	// Validate form data...
	
	// Construct Post...
	var postInfo = '';
	$("#RegistrationForm input[type!=submit]").each( function(){
		postInfo += this.name+'='+$(this).val()+'&';
	});
	
	XMLhttp.onreadystatechange=registrationComplete;
	XMLhttp.open('POST','PHP/RegisterFunctions.php',true);
	XMLhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	XMLhttp.send(postInfo);
}


function registrationComplete(){

	if( XMLhttp.readyState == 4 || XMLhttp.readyState == 'complete' ){
		document.location.href='Register.php';
	}
}



