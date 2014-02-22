<?php

session_start();

if($_POST['requestType'] == 'forumPost'){

	if($_POST['UserID'] == 'Unregistered'){
		echo 'notACamper';
		return;
	}

	$user = $_POST['UserID'];
	$date = $_POST['postDate'];
	$content = $_POST['postContent'];

	storePost($user, $date, $content);
	$post = makePost($user, $date, $content);
	echo nl2br($post);
}






function makePost($user, $date, $content){

	$link = mysqli_connect('dbserver.engr.scu.edu','holson','00000755449','test');

	if( !$link ){
		die("could not connect to database");
	}


	$q = $link->prepare('SELECT * FROM user_info WHERE user_id=?');
	$q->bind_param('i',$user);
	$q->execute();
	
	$row = $q->get_result();
	$rowArray = mysqli_fetch_array($row);
	$spent = $rowArray[3];

	$Badges = $spent/30;

	

	$postElement = "";
	$postElement .= "<div class='forumPost'>";
	$postElement .= 	"<div class='postContent'>";
	$postElement .= 	"<h4 class='postHead'> Camper ".$user."   --   ".$date."</h4>";
	for( $i=1; $i<$Badges; $i++ ){
		$z = 1000-$i;
		$postElement .= "<div style='z-index:".$z.";' class='emblem'>";
		$postElement .= "<img style='z-index:".$z.";' src='./Images/Logo2.png'/>";
		$postElement .= "</div>";
	}
	$postElement .= 		"<p>".$content."</p>";
	$postElement .= 	"</div>";
	$postElement .= "</div>";

	mysqli_close($link);

	return $postElement;

}







function storePost($user, $date, $content){
	//	Store post in MySQL database
	$con = mysqli_connect('dbserver.engr.scu.edu', 'holson', '00000755449', 'test');

	if(!$con){
		die("servers not available");
		echo "servers not available";
	}

	//Sanatizing Data using prepare/bind/execute
	$q = $con->prepare("INSERT INTO forum_posts(user_id,date,post) VALUES (?,?,?)");
	$q->bind_param("iss",$user,$date,$content);
	$q->execute();

	//mysqli_query($con, "INSERT INTO forum_posts(user_id, date, post) VALUES ('$user','$date','$content')");
	
	mysqli_close($con);
}







function loadFeedbackForm(){

	$userID = getUserID();
	$date = date("F j, Y");

	echo "<form id='forumForm' action='Javascript:submitPost()' method='POST' >";
		echo "<h3> Share your thoughts! </h3>";
		echo "<img id='logo' src='./Images/Logo2.png'/>";
		echo "<p> Camper ".$userID."   --   ".$date."</p>";
		//	Submit 3 values to database: User's ID, date of the post, and the post's content
		echo "<input type='hidden' name='UserID' value='".$userID."'/>";
		echo "<input type='hidden' name='postDate' value='".$date."'/>";
		echo "<textarea rows='10' name='postContent' ></textarea>";
		echo "<input type=submit>";
	echo "</form>";

}

function loadFeedbackDisplay(){ 

	$con = mysqli_connect('dbserver.engr.scu.edu', 'holson', '00000755449', 'test');
	if(!$con){
		die("servers not available");
		echo "servers not available";
	}

	$postList = mysqli_query($con, "SELECT * FROM forum_posts ORDER BY stamp DESC");

	$row = mysqli_fetch_row($postList);

	while( $row!=null ){
		$user=$row[0];
		$date=$row[1];
		$content=$row[3];
		$post = makePost($user, $date, $content);
		echo nl2br($post);
		$row = mysqli_fetch_row($postList);
	}

	mysql_close($con);
}



function getUserID(){
	//	Get Camper ID from session 

	if( isset($_SESSION['uid'])){	
		$id = $_SESSION['uid'];
	}else{
		$id = "Unregistered";
	}

	return $id;
}

?>
