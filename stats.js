

function getXMLhttpObject(){
	var objXMLHttp=null;
	if (window.XMLHttpRequest){
		objXMLHttp=new XMLHttpRequest();
	}
	else if (window.ActiveXObject){
		objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return objXMLHttp;
}


function statsSelection(choice){

	XMLhttp = getXMLhttpObject();
	choice = $("#statsCtrl option:selected").attr("name");


	url="./PHP/StatsFunctions.php";
	url+="?requestType="+choice;

	if(choice == "byAge"){
		choice = "Camps by Age";
	}else if(choice == "byMoney"){
		choice = "Camps by Camper Financial Enthusiasm";
	}else{
		choice = "Campers by location";
	}

	XMLhttp.onreadystatechange = loadVisualization;
	XMLhttp.open("GET",url,true);
	XMLhttp.send();
}

function loadVisualization(){
	if( XMLhttp.readyState == 4 || XMLhttp.readyState=="complete" ){
//		alert( XMLhttp.responseText );
//		$("#statsBoard").html(XMLhttp.responseText);
		var response = XMLhttp.responseText.split("&");
		$("#statsBoard").html(response[0]);
		$("#statsDescription h3").html(response[1]);
		$("#statsDescription p").html(response[2]);
	}
}







