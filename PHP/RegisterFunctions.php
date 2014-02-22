<?php

session_start();

// function checkData();
//	Need to check all post data on server side. In order of importance
//	1.All Post Fields are filled (all inputs were input)
//	2.No repeated users (check emails against MySQL)
//	3.Other things I'm sure are less important

if($_POST['requestType'] == 'newUser'){
	$email = $_POST['email'];
	$password = $_POST['password1'];
	createNewUser($email, $password);	
}
/*
$camp = $_POST['camp'];
$week = $_POST['week'];
$age = $_POST['age'];
$gender = $_POST['sex'];
$fName = $_POST['CFname'];
$lName = $_POST['CLname'];
$school = $_POST['Cschool'];
$grade = $_POST['Cgrade'];
$spec = $_POST['Cspec'];
$aller = $_POST['aller'];
*/
// addCamper( ..params.. ){
// 
//  ...Add information to camper_info database...
//
//	header('Location:../RegistrationComplete.php');
// }

function createNewUser($email, $pass){
	
	$link = mysqli_connect('dbserver.engr.scu.edu','holson','00000755449','test');
	if( !$link ){
		die("unable to connect to database");
	}
	
	$q = $link->prepare("INSERT INTO user_info(email, password) VALUES(?,?)");
	$q->bind_param("ss",$email,$pass);
	$q->execute();

	$userList = mysqli_query($link, "SELECT * FROM user_info WHERE email='$email'");

	$userInfo = mysqli_fetch_row($userList);
	
	$id = $userInfo[0];
	
	$_SESSION['uid'] = $id;
	$_SESSION['email'] = $email;
	
	mysqli_close($link);


	return;

}

?>

