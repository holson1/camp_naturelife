<?php

loadVisualization();


function loadVisualization(){

	if($_GET["requestType"]=="byAge"){
		$html = loadAgeStats();
		$html .= "&Campers by Age";
		$html .= "&Ever wonder what age of campers enjoy are camps the most? The answer is ALL OF THEM!! and hidden in the chart above is the real answer.";
		echo $html;
	}elseif( $_GET["requestType"]=="bySpent"){
		$html = loadMoneyStats();
		$html .= "&Camp by Camper Financial Enthusiasm";
		$html .= "&Here you can see the financial disparities between campers!";
		echo $html;
	}elseif( $_GET["requestType"]=="byCamp"){
		$html = loadCampStats();
		$html .= "&Campers Per Camp";
		$html .= "&Above you can look at which camps are more popular and which are less. All of Camp Nature Life's locations are wonderful experiences.";
		echo $html;
	}else{
		$html = loadCampStats();
		echo $html;
	}
}

function loadMoneyStats(){


	$link = mysqli_connect('dbserver.engr.scu.edu', 'holson', '00000755449', 'test');

	if(  !$link ){
		die( "could not connect to server" );
	}
	
	$userList = mysqli_query($link, "SELECT * FROM user_info");
	$user = mysqli_fetch_row($userList);

	





	return "money stats";
}


function loadAgeStats(){

	$link = mysqli_connect('dbserver.engr.scu.edu', 'holson', '00000755449', 'test');

	if(  !$link ){
		die( "could not connect to server" );
	}
	
	$camperList = mysqli_query($link, "SELECT * FROM camper_info ORDER BY age");
	$camper = mysqli_fetch_row($camperList);


	$ageList = array();
	$totalCount = 0;
	$uniqueCount = 0;
	
	while( $camper != null ){
		$age = $camper[3];
		if( $ageList[$age] == null ){
			$ageList[$age] = 1;
			$uniqueCount += 1;
		}else{
			$ageList[$age] += 1;
		}
		$camper = mysqli_fetch_row($camperList);
		$totalCount += 1;
	}

	mysqli_close($link);

	$html .= "<div align='middle' id='ageDisplay'>";
		foreach( $ageList as $age=> $count ){
		
			$size = 800 * ($count/$totalCount);
			$html .= "<svg  width='$size' height='$size' version='1.1' viewBox='0 0 100 100' preserveAspectRatio='xMinyMin' xmlns='http://www.w3.org/2000/svg' >";
			$html .= "<polyline fill='#755019' points='38,100 40,77.5 35,30 65,30 60,72.5 62,100' />";
			$html .= "<circle fill='#1A7518' cx='50' cy='20' r='20' />";
			$html .= "<circle fill='#1C7519' cx='30' cy='40' r='20' />";
			$html .= "<circle fill='#196D16' cx='50' cy='40' r='20' />";
			$html .= "<circle fill='#1C7519' cx='70' cy='40' r='20' />";
			$html .= "<text text-anchor='middle' fill='white' style='font-weight:bold; font-family:arial;' x='50' y='38'>age $age </text>";
	
			$html .= "</svg>";
			
		}
	$html .= "</div>";

	return $html;
}


function loadCampStats(){

	$link = mysqli_connect('dbserver.engr.scu.edu', 'holson', '00000755449', 'test');

	if(  !$link ){
		die( "could not connect to server" );
	}
	

//	Construct array of camps from locations database


	$campList = mysqli_query($link, "SELECT * FROM camp_locations");
	$campLocation = mysqli_fetch_row($campList);
	
	while( $campLocation != null ){
		$camps[$campLocation[0]]=0;
		$campLocation = mysqli_fetch_row($campList);
	}	


//	Go through camper info and add a count to the camp they are in
	$camperInfo = mysqli_query($link, "SELECT * FROM camper_info");
	$camper = mysqli_fetch_row($camperInfo);
	
	while( $camper != null ){
		$location = $camper[2];
		if( $camps[$location] == null ){
			$camps[$location] = 1;
		}else{
			$camps[$location] += 1;
		}
		$camper = mysqli_fetch_row($camperInfo);
	}
	
	$width = 100;
	$xPos = 40;
	$yPos = 500;
	$textX = $xPos+$width/2;

	$html = "<div class='statDisplay' height='500' width='750'>";
		$html .= "<svg  width='100%' height='100%' version='1.1' xmlns='http://www.w3.org/2000/svg' >";
		foreach( $camps as $camp => $count){

			$color = 'blue';
			$height = $count * 50;
			$yPos = 500-$height;
			$textY = $yPos-10;
			$countY = $yPos + $height/2;

			$html .= "<rect x='".$xPos."' y='".$yPos."' width='".$width."' height='".$height."' stroke='".$color."' fill='".$color."' />";
			$html .= "<text text-anchor='middle'x='".$textX."' y='".$textY."'> ".$camp."</text>";
			$html .= "<text text-anchor='middle'x='".$textX."' y='".$countY."'> ".$count."</text>";
			$xPos += 140;
			$textX += 140;
		}
		$html .= "</svg>";
	$html .= "</div>";

	mysqli_close($link);

	return $html;

}







?>
