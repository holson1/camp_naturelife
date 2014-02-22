<?php

function getCSVItems($file){

	$line = "";
	$items = array();
	$itemList = array();

	$fp=fopen($file,"r");


	while( !feof($fp) ){
		$line = fgets($fp);
		if( $line[0] == "#"){
			continue;
		}
		$items = explode("&",$line);
		array_push( $itemList, $items );
	}

	fclose($fp);
	return $itemList;
}



function loadStore($type){
	if( $type == "csv"){
		$itemList = getCSVItems("./db/items.txt");
	}else{
		echo "broke";
		return;
	}

	foreach( $itemList as $items){
		echo "<tr>";
		foreach( $items as $item){
			echo "<td>";
			echo $item;
			echo " </td>";
		}
		echo "</tr>";
	}
}

test();

function test(){

	for( $i=0; $i<3; $i++ ){
		echo "<tr>";
		echo "<td> Test </td>";
		echo "</tr>";
	}
}

?>