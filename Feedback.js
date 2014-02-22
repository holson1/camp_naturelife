

function getXMLHttpObject(){
	var XMLHttpObj = null;
	if( window.XMLHttpRequest){
		XMLHttpObj = new XMLHttpRequest();
	}else if(window.ActiveXObject){
		XMLHttpObj = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return XMLHttpObj;
}




function updateForum(){
	if( XMLhttp.readyState==4 || XMLhttp.readyState=="complete"){
		if(XMLhttp.responseText == "notACamper"){
			alert("Someone's not a camper! We don't host forums for just ANYONE! Register or login to join the party!");
		}else{
			$('#FeedbackDisplay').prepend(XMLhttp.responseText);
		}
	}
}


function submitPost(){
	XMLhttp = getXMLHttpObject();

	var postCheck = checkPost();

	if( postCheck==true ){
	}else{
		if( postCheck == "empty"){
			alert("Please include words in your submission");
			return;
		}
		alert("Careful, you almost yelled "+postCheck+" load enough for everyone reading this to hear. Please rephrase your submission");
		return;
	}

	var postInfo="requestType=forumPost&";
	$("#forumForm :input[type!=submit]").each(function(){
		postInfo += this.name+"="+ $(this).val()+"&";
	});

	XMLhttp.onreadystatechange=updateForum;
	XMLhttp.open("POST", "./PHP/FeedbackFunctions.php",true);
	XMLhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	// XMLhttp.setRequestHeader("Content-length", postInfo.length);
	// XMLhttp.setRequestHeader("Connection", "close");
	XMLhttp.send(postInfo);
}


function checkPost(){

	var post = $("#forumForm textarea").val();

	var notEmpty = /[\w]/;
	if( !notEmpty.test(post) ){
		return "empty";
	}

	var Profanities = new RegExp(getProfanityRegex(),'i');
	var badWord = Profanities.exec(post);

	if ( badWord != null){
		return badWord;
	}

	return true;
}



function getProfanityRegex(){

	Pregex = 'Fuck|';
	Pregex += 'Shit|';
	Pregex += 'Ass|';
	Pregex += 'Bitch|';
	Pregex += 'Dike|';
	Pregex += 'Cunt|';
	Pregex += 'Slut|';
	Pregex += 'Fag|';
	Pregex += 'Whore';
	
	return Pregex;

}
















