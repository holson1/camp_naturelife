<?php

session_start();


// Request Handling

//	Adding an Item To the Cart
if($_GET["requestType"] == "updateCart"){
	$itemID = $_GET["itemID"];
	$cartInfo = addToCart($itemID);
	echo $cartInfo;

	$total = getTotalPrice();
	echo "&".$total;

	$totalItems = getTotalItems();
	$sticker = makeCartSticker($totalItems);
	echo "&".$sticker;

//	Removing an Item From the Cart
}elseif($_GET["requestType"] == "removeItem"){
	$checkedItems = $_GET["item"];
	$removedItems = removeFromCart($checkedItems);

	echo $removedItems;

	$total = getTotalPrice();
	echo "&".$total;

	$totalItems = getTotalItems();
	$sticker = makeCartSticker($totalItems);
	echo "&".$sticker;

//	Final Purchase Button Pressed
}elseif($_GET["requestType"] == "loadRecipt"){

	$user = $_SESSION['uid'];
	$total = getTotalPrice();
	$total = (float)$total;

	updateStoreInfo();
	updateUserInfo($user, $total);
	$recipt = loadRecipt();
	echo $recipt;
}



function getMySQLItems($server, $uname, $pass, $db){

	$link = mysqli_connect($server, $uname , $pass ,$db);
	$items = mysqli_query($link,"SELECT * FROM store ORDER BY price");
	$item = mysqli_fetch_row($items);
	$itemList = array();

	while( $item!= null ){
		array_push($itemList, $item);
		$item = mysqli_fetch_row($items);
	}
	
	mysqli_close($link);

	return $itemList;

}





function getCSVItems($file){

	$fp=fopen($file,"r");

	$line = "";
	$items = array();
	$itemList = array();
	while(!feof($fp)){
		$line = fgets($fp);
		if( strlen($line)<5 ) continue;
		if( $line[0] == "#") continue;
		$items = explode("&",$line);
		array_push( $itemList, $items );
	}

	fclose($fp);
	return $itemList;
}




function getTotalPrice(){

	$totalPrice = 0;

	if(isset($_SESSION["cart"])){
		$cart = $_SESSION["cart"];
	}else{
		return 0;
	}

	foreach( $cart as $cartItem){
		$totalPrice += (float)$cartItem["Price"];
	}

	$totalPrice = number_format($totalPrice,2,".",",");

	return $totalPrice;

}


function getTotalItems(){

	$totalCount = 0;

	if( isset($_SESSION['cart'])){
		$cart = $_SESSION['cart'];
	}else{
		return 0;
	}
	
	foreach( $cart as $cartItem ){
		$totalCount += (int)$cartItem['Qty'];
	}

	return $totalCount;
}







function loadCart(){

	
	echo "<tr id='cartTop'>",PHP_EOL;
		echo "<th></th>",PHP_EOL;
		//	Alternate /\ with \/ to test icons in cartTrash.svg
		// echo "<th> <embed id='cartTrash' src='Images/cartTrash.svg' onclick='removeFromCart()'/></th>",PHP_EOL;
		echo "<th> Item </th>",PHP_EOL;
		echo "<th> Qty </th>",PHP_EOL;
		echo "<th> Price </th>",PHP_EOL;
	echo "</tr>",PHP_EOL;

	if(isset($_SESSION["cart"])){
		$cart = $_SESSION["cart"];
	}

	$totalPrice = 0;

	foreach( $cart as $cartItem){
		echo "<tr id='cartItem".$cartItem["ID"]."'>",PHP_EOL;
			echo "<td class='cartItemLeft'> <input class='cartCheckbox' type='checkbox' name='".$cartItem["ID"]."' /> </td>",PHP_EOL;
			echo "<td class='cartItemName'>".$cartItem["Name"]."</td>",PHP_EOL;
			echo "<td class='cartItemQty'>".$cartItem["Qty"]."</td>",PHP_EOL;
			echo "<td class='cartItemPrice'>$".$cartItem["Price"]."</td>",PHP_EOL;
		echo "</tr>",PHP_EOL;
		$totalPrice += (float)$cartItem["Price"];
	}
	
	
	echo "<tr id='cartInfo'>",PHP_EOL;
		echo "<td class='cartItemLeft'> <input class='checkALL' type='checkbox' name='checkAll' onclick='toggle(this)' /> </td>",PHP_EOL;
		echo "<td colspan='2' style='text-align:right'> TOTAL : </td>",PHP_EOL;
		echo "<td id='totalCartPrice'>$".$totalPrice."</td>",PHP_EOL;
	echo "</tr>",PHP_EOL;

	echo "<tr id='cartControl'>",PHP_EOL;
		echo "<td class='cartItemLeft'>",PHP_EOL;
		//	SVG TRASH CAN  //

			echo "<svg id='cartTrashButton' width='33' height='33' version='1.1' xmlns='http://www.w3.org/2000/svg' onclick='removeFromCart()'>",PHP_EOL;
				echo "<rect x='7.5' y='6' rx='1' ry='1' width='20' height='4' style='fill:#777;stroke:#777;'/>",PHP_EOL;
				echo "<polyline stroke='#777' stroke-width='3' fill='#777' points=' 10,11 11,27 24,27 25,11 ' />",PHP_EOL;
				echo "<line stroke='#555' stroke-width='2' x1='22.5' y1='28' x2='22.5' y2='11' />",PHP_EOL;
				echo "<line stroke='#555' stroke-width='2' x1='17.5' y1='28' x2='17.5' y2='11' />",PHP_EOL;
				echo "<line stroke='#555' stroke-width='2' x1='13' y1='28' x2='13' y2='11' />",PHP_EOL;
				echo "<line stroke='#555' stroke-width='3' x1='13.5' y1='4' x2='21' y2='4' />",PHP_EOL;
			echo "</svg>",PHP_EOL;
		//	END TRASH CAN//
		echo "</td>",PHP_EOL;
		echo "<td colspan='3' style='text-align:right'>",PHP_EOL;
			echo "<input type='button' value='Checkout' onClick='location.href=\"purchase.php\"'/>",PHP_EOL;
		echo "</td>",PHP_EOL;
	echo "</tr>",PHP_EOL;

}













function loadStore($type){
	if( $type == "csv"){
		$itemList = getCSVItems("./db/Items.txt");
	}else if($type == "mysql"){
		$itemList = getMySQLItems("dbserver.engr.scu.edu","holson","00000755449","test");
	}


	foreach( $itemList as $item){

		$itemImage = $item[4];
		$itemName = $item[0];
		$itemDescription = $item[2];
		$itemID = $item[5];
		if(isset($_SESSION["uid"])){
			$itemPrice = $item[1]-(.15*$item[1]);
			$fullPrice = $item[1];
			$fullPrice = number_format($fullPrice,2,'.',',');
		}else{
			$itemPrice = $item[1];
		}
		$itemPrice = number_format($itemPrice,2,".",",");

		echo "<div class='storeItem'>",PHP_EOL;

			// Image
			echo "<img src='".$itemImage."' />",PHP_EOL;

			//Content
			echo "<div class='itemInfo'>",PHP_EOL;
				echo "<h3>".$itemName." </h3>",PHP_EOL;
				echo "<p>".$itemDescription."</p>",PHP_EOL;
			echo "</div>",PHP_EOL;

			echo "<form class='itemPurchase'>",PHP_EOL;
	
				if( isset($_SESSION["uid"]) ){
					echo "<h3>$<strike>".$fullPrice."</strike></h3>",PHP_EOL;
					echo "<h3>$".$itemPrice."</h3>",PHP_EOL;
				}else{
					echo "<h3>$".$itemPrice."</h3>",PHP_EOL;
				}

				echo "<input id='".$itemID."' type='button' onclick='updateCart(this.id)' value='Add to cart'/>",PHP_EOL;
			echo "</form>",PHP_EOL;
			echo "<div class='shadowdiv'></div>",PHP_EOL;
		echo "</div>",PHP_EOL;
	}
}







function addToCart($itemID){

//		$itemList = getCSVItems("./db/Items.txt");
		$itemList = getMySQLItems("dbserver.engr.scu.edu","holson","00000755449","test");

	//	get the specific Item's info
	foreach( $itemList as $itemInfo){
		if( $itemInfo[5] == (int)$itemID ){
			$Iname = $itemInfo[0];
			$Iprice = $itemInfo[1];
		}
	}

	if(isset($_SESSION["uid"])){
		$Iprice = $Iprice - (.15*$Iprice);
	}

	$Iprice = number_format($Iprice,2,".",",");

	//	update Cart session variable
	if(isset($_SESSION["cart"])){
		$cart = $_SESSION["cart"];

		// Cart Exists, Item is in it
		if( isset($cart[$itemID])){
			$cart[$itemID]["ID"] = $itemID;
			$cart[$itemID]["Qty"] += 1; // update Qty
			$Iqty = $cart[$itemID]["Qty"];
			$totalItemPrice = $Iprice * $Iqty;
			$totalItemPrice = number_format($totalItemPrice,2,".",",");
			$cart[$itemID]["Price"] = $totalItemPrice;
			$_SESSION["cart"] = $cart;
			$total = getTotalPrice(); // uses session, be sure to update first
			$cartInfo = $itemID."&".$cart[$itemID]["Qty"]."&".$cart[$itemID]["Price"];
			return $cartInfo;

		// Cart Exists, item isn't in it 
		}else{
			$cart[$itemID]["ID"] = $itemID;
			$cart[$itemID]["Name"] = $Iname;
			$cart[$itemID]["Qty"] = 1;
			$cart[$itemID]["Price"] = $Iprice;
		}

	//	No Cart exists, make one
	}else{
		$cart = array();
		$cart[$itemID]["ID"] = $itemID;
		$cart[$itemID]["Name"] = $Iname;
		$cart[$itemID]["Qty"] = 1;
		$cart[$itemID]["Price"] = $Iprice;
	}

	$_SESSION["cart"] = $cart;

	//	make HTML cartItem element
	$cartInfo = "<tr id='cartItem".$itemID."'>";
	$cartInfo .= "<td class='cartItemLeft'> <input class='cartCheckbox' type='checkbox' name='".$itemID."' /> </td>";
	$cartInfo .= "<td class='cartItemName'>".$cart[$itemID]["Name"]."</td>";
	$cartInfo .= "<td class='cartItemQty'>".$cart[$itemID]["Qty"]."</td>";
	$cartInfo .= "<td class='cartItemPrice'>$".$cart[$itemID]["Price"]."</td>";
	$cartInfo .= "</tr>";

	return $cartInfo;
}









function removeFromCart($items){
	
	$deadItems = "";

	foreach( $items as $item ){
		unset($_SESSION["cart"][$item]);
		$deadItems .= $item."&";
	}
	return $deadItems;
}




function makeCartSticker($itemCount){
	
	if($itemCount == 0){
		return "";
	}

	$sticker = '<svg  id="cartSticker" width="40" height="40" version="1.1" xmlns="http://www.w3.org/2000/svg" >';
	$sticker .= '<circle cx="20" cy="10" r="10" fill="#1A5014" />';
	$sticker .= '<text text-anchor="middle" dominant-baseline="middle" fill="white" x="20" y="10">'.$itemCount.' </text>';
	$sticker .= '</svg>';
	
	return $sticker;
}




//	FOR CHECKOUT AND PURCHASING
function loadCheckout(){

	if(isset($_SESSION) ){
		$cart = $_SESSION["cart"];
	}else{
		return;
	}

	echo "<h2> Your Order </h2>",PHP_EOL;
	echo "<div id='orderInfo'>";
	foreach( $cart as $item ){
		$itemName = $item["Name"];
		$itemID = $item["ID"];
		$itemPrice = $item["Price"];
		$itemQty = $item["Qty"];

		$itemPrice = number_format($itemPrice,2,".",",");
		
		echo "</br>",PHP_EOL;
		echo "<p class='checkoutItemLeft'>".$itemName."  x".$itemQty. "</p>",PHP_EOL;
		echo "<p class='checkoutItemRight'>$".$itemPrice."</p>",PHP_EOL;
	}
		$total = getTotalPrice();
		echo "<br><hr>";
		echo "<p class='checkoutItemRight' style='font-weight:bold; font-size:1.5em;'> Total: $".$total."</p>";
	echo "</div>";

}









function loadRecipt(){
	if(isset($_SESSION["cart"] )){
		$cart = $_SESSION["cart"];	
	}else{
		return;
	}

	echo "<h2> Thank You for Ordering! </h2>",PHP_EOL;
	echo "<div id='orderInfo'>";
	foreach( $cart as $item ){
		$itemName = $item["Name"];
		$itemID = $item["ID"];
		$itemPrice = $item["Price"];
		$itemQty = $item["Qty"];
		
		if($itemName == "" ){
			continue;
		}
		
		echo "</br>",PHP_EOL;
		echo "<p class='checkoutItemLeft'>".$itemName."  x".$itemQty. "</p>",PHP_EOL;
		echo "<p class='checkoutItemRight'>$".$itemPrice."</p>",PHP_EOL;
	}
		$total = getTotalPrice();
		echo "<br><hr>";
		echo "<p class='checkoutItemRight' style='font-weight:bold; font-size:1.5em;'> Total: $".$total."</p>";
	echo "</div>";

	unset($_SESSION["cart"]);


}



function updateUserInfo($id, $total){

	$link = mysqli_connect("dbserver.engr.scu.edu","holson","00000755449","test");
	
	$q = $link->prepare("UPDATE user_info SET spent_at_store=spent_at_store+? WHERE user_id=?");
	$q->bind_param("di",$total, $id);
	$q->execute();
	
	mysqli_close($link);
}


function updateStoreInfo(){

	if(isset($_SESSION["cart"] )){
		$cart = $_SESSION["cart"];	
	}else{
		return;
	}
	
	$link = mysqli_connect("dbserver.engr.scu.edu","holson","00000755449","test");
	$q = $link->prepare("UPDATE store SET total_sold = total_sold+? WHERE pid=?");

	foreach( $cart as $item ){
		$itemName = $item["Name"];
		$itemID = $item["ID"];
		$itemPrice = $item["Price"];
		$itemQty = $item["Qty"];
	
		$q->bind_param("ii",$itemQty, $itemID);
		$q->execute();
	}
		
	mysqli_close($link);

}



?>



