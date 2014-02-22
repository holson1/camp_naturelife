
function GetXmlHttpObject(){ 
	var objXMLHttp=null;
	if (window.XMLHttpRequest){
		objXMLHttp=new XMLHttpRequest();
	}
	else if (window.ActiveXObject){
		objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return objXMLHttp;
}




function addWhenReady() { 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ 
		if( xmlHttp.responseText.substring(0,3) == "<tr"){
			var itemInfo = xmlHttp.responseText.split("&");			
			$("#cartTop").after(itemInfo[0]);
			$("#cartInfo > #totalCartPrice").html("$"+itemInfo[1]);
			var cartSticker = itemInfo[2];
			$("#cartStickerHolder").html(cartSticker);
		}else{
			var itemInfo = xmlHttp.responseText.split("&");
			$("#cartItem"+itemInfo[0]+"> .cartItemQty").html(itemInfo[1]);
			$("#cartItem"+itemInfo[0]+"> .cartItemPrice").html("$"+itemInfo[2]);
			$("#cartInfo > #totalCartPrice").html("$"+itemInfo[3]);
			var cartSticker = itemInfo[4];
			$("#cartStickerHolder").html(cartSticker);
		}
	} 
} 


function updateCart(id){

	//	Make XML object
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null){
		alert ("Browser does not support HTTP Request");
		return;
	}

	var url = "./PHP/StoreFunctions.php";
	url += "?requestType=updateCart&itemID="+id;

	//	Send XML object
	xmlHttp.onreadystatechange = addWhenReady;
	xmlHttp.open("GET",url,true);
	xmlHttp.send();
}





function removeWhenReady(){
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ 
		var deadItems = xmlHttp.responseText.split("&");
		for(var i=0; i<=deadItems.length-1; i++ ){
			$("#cartItem"+deadItems[i]).remove();
			if( i == deadItems.length-2){
				$("#cartInfo > #totalCartPrice").html("$"+deadItems[i]);
			}
		}
		var cartSticker = deadItems[deadItems.length-1];
		$("#cartStickerHolder").html(cartSticker);
	}
}	


function removeFromCart(){

	xmlHttp = GetXmlHttpObject();
	if (xmlHttp==null){
		alert ("Browser does not support HTTP Request");
		return;
	}

	var url = "./PHP/StoreFunctions.php";
	url += "?requestType=removeItem";
	var i=0;

	$(".cartCheckbox:checked").each(function(){
		url += "&item["+i+"]="+this.name;
		i+=1;
	});

	xmlHttp.onreadystatechange = removeWhenReady;
	xmlHttp.open("GET",url,true);
	xmlHttp.send();
}

function toggle(source) {
	$(".cartCheckbox").each(function(){
		this.checked = source.checked;
	});
}


$(window).scroll(function(){
  $("#cart").stop().animate({"marginTop": ($(window).scrollTop()) + "px", "marginLeft":($(window).scrollLeft()) + "px"}, "medium" );
});


function loadRecipt(){

	xmlHttp = GetXmlHttpObject();
    if (xmlHttp==null){
        alert ("Browser does not support HTTP Request");
        return;
    }   

	xmlHttp.onreadystatechange = updateCheckout;
    xmlHttp.open("GET","./PHP/StoreFunctions.php?requestType=loadRecipt",true);
    xmlHttp.send();	

}

function updateCheckout(){
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
   		$("#Checkout").html(xmlHttp.responseText);
	}
}















