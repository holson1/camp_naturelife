<?php
session_start();

//this function checks the form submitted from Register.php by a new user, and submits their info to the database if correct
function checkRegNewUser()
{
	session_start();
	//variable to control exit of function
	$die=0;

	//check to make sure the required forms have been filled out
	if(! $_POST['password1'] || ! $_POST['password2'] || ! $_POST['Lname'] || ! $_POST['phone'] || ! $_POST['CLname'] || ! $_POST['Cgrade'] || ! $_POST['cardName'] || ! $_POST['CSV'] || ! $_POST['Fname'] || ! $_POST['email'] || ! $_POST['CFname'] || ! $_POST['school'] || ! $_POST['Ccard'] || ! $_POST['expM'] || ! $_POST['expY'])
	{
		echo "<p class=\"errtxt\" >Please fill out all of the required fields</p>";
		$die=1;	
	}

	//grab the post variables and store them in new variables
	//could be optimized in a for each loop but that complicates how we define and access the variables
	$password = ($_POST['password1']);
	$password2 = ($_POST['password2']);
	$Fname = htmlspecialchars(trim($_POST['Fname']));
	$Lname = htmlspecialchars(trim($_POST['Lname']));
	$email = htmlspecialchars(trim($_POST['email']));
	$phone = htmlspecialchars(trim($_POST['phone']));
	$CFname = htmlspecialchars(trim($_POST['CFname']));
	$CLname = htmlspecialchars(trim($_POST['CLname']));
	$school = htmlspecialchars(trim($_POST['school']));
	$Cgrade = htmlspecialchars(trim($_POST['Cgrade']));
	$aller = htmlspecialchars(trim($_POST['aller']));
	$Cspec = htmlspecialchars(trim($_POST['Cspec']));
	$Ccard = htmlspecialchars(trim($_POST['Ccard']));
	$cardName = htmlspecialchars(trim($_POST['cardName']));
	$expM = htmlspecialchars(trim($_POST['expM']));
	$expY = htmlspecialchars(trim($_POST['expY']));
	$CSV = htmlspecialchars(trim($_POST['CSV']));
	$camp = $_POST['camp'];
	$age = $_POST['age'];
	$sex = $_POST['sex'];
	$week = $_POST['week'];

	//test to make sure passwords match
	if($password != $password2)
	{
		echo "<p class=\"errtxt\">Error: passwords do not match.</p>";
		$die=1;
	}

	//REGEXES
	//email regex
	$ereg = '/^[\w]+@[\w\.\-]+\.[a-zA-Z]{2,4}$/';
	//test to see if email works
	if(preg_match($ereg, $email) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but your email " . $email . " doesn't match the accepted format.</p>";
		$die=1;
	}

	//word regex
	$wreg = '/^[a-zA-Z\-\' ]+$/';
	
	//first name
	if(preg_match($wreg, $Fname) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, your first name doesn't match the accepted format.</p>";
		$die=1;
	}
	//last name
	if(preg_match($wreg, $Lname) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, your last name doesn't match the accepted format.</p>";
		$die=1;
	}
	//kid's first name
	if(preg_match($wreg, $CFname) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, your child's first name doesn't match the accepted format.</p>";
		$die=1;
	}
	//kid's last name
	if(preg_match($wreg, $CLname) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, your child's last name doesn't match the accepted format.</p>";
		$die=1;
	}
	//school
	if(preg_match($wreg, $school) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, your child's school name doesn't match the accepted format.</p>";
		$die=1;
	}

	//NUMBER REGEXES
	//phone
	$phonereg = '/^[\d]{10}$/';
	if(preg_match($phonereg, $phone) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but your phone number doesn't match the correct format (all digits).</p>";
		$die=1;
	}	
	//grade
	$gradereg = '/^[\d]+$/';
	if(preg_match($gradereg, $Cgrade) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but the grade entered doesn't match the correct format (all digits).</p>";
		$die=1;
	}
	
	//test grade further
	if($Cgrade < 1 || $Cgrade > 12)
	{
		echo "<p class=\"errtxt\">Sorry, the grade entered is not between 1 (1st grade) and 12 (senior in highschool).</p>"; 
		$die=1;
	}
	//card
	$cardreg = '/^[\d]{16}$/';
	if(preg_match($cardreg, $Ccard) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but your card number doesn't match the correct format (all digits).</p>";
		$die=1;
	}

	//expm
	$expmreg = '/^[0-1][0-9]$/';
	if(preg_match($expmreg, $expM) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but your expiration month doesn't match the correct format.</p>";
		$die=1;
	}

	//expy
	$expyreg = '/^[2][0][1-2][0-9]$/';
	if(preg_match($expyreg, $expY) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but your expiration year doesn't match the correct format</p>";
		$die=1;
	}

	//csv
	$csvreg = '/^[0-9]{3}$/';
	if(preg_match($csvreg, $CSV) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but your CSV doesn't match the correct format</p>";
		$die=1;
	}

	//initiate the db connection
	$con = mysqli_connect('dbserver.engr.scu.edu', 'holson', '00000755449', 'test');
	//test
	if(!$con)
	{
		echo "MySQL error cannot connect";
		die();
	}

	//run a query to grab the ages of the camp chosen
	$result = mysqli_query($con, "SELECT age_lo, age_hi FROM camp_locations WHERE location_name='$camp'");
	$row = mysqli_fetch_array($result);

	//test the age field to see if the camper is within the range
	if($age < $row[0] || $age > $row[1])
	{
		echo "<p class=\"errtxt\">Sorry, your camper is not in the appropriate age range for " . $camp . ".</p>";
		$die=1;
	}

	//run a query to see if an email already exists
	$check = $con->prepare("SELECT email FROM user_info WHERE email=?");
	$check->bind_param('s', $email);
	if(! $check->execute())
	{
		//query didn't go through, user alert
		echo "<p class=\"errtxt\">Error: could not check email against database.</p>";
		die();
	}
	//bind the result to var
	$check->bind_result($dbemail);
	//check to see if we got a result
	if($check->fetch())
	{
		//if we did, let the user know the email is already in use
		echo "<p class=\"errtxt\">Sorry, the email " . $email . " is already in use. Please choose another or login using this email.</p>";
		$die=1;
	}

	//do this after all variables have been tested
	if($die == 1)
	{
		die();
	}

	//now we want to create the user account
	$create = $con->prepare("INSERT INTO user_info (email, password) VALUES (?,?)");
	$create->bind_param('ss', $email, $password);
	if(! $create->execute())
	{
		echo "<p class=\"errtxt\">Error: could not create new user account.</p>";
		die();
	}

	//now grab the userid of the newly created user
	$grab = $con->prepare("SELECT user_id FROM user_info WHERE email=?");
	$grab->bind_param('s', $email);
	if(! $grab->execute())
	{
		echo "<p class=\"errtxt\">Error: could not grab new user id.</p>";
		die();
	}
	$res = $grab->get_result();
	$nrow = mysqli_fetch_array($res);
	$newuserid = $nrow[0];

	//at this point, all the information entered is valid
	//so we're going to store what's important
	$insertnew = $con->prepare("INSERT INTO camper_info (parent_id, camp, age, gender, camper_fname, camper_lname, school, grade, week, allergies, special_inst) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
	$insertnew->bind_param('isissssisss', $newuserid, $camp, $age, $sex, $CFname, $CLname, $school, $Cgrade, $week, $aller, $Cspec);
	if(! $insertnew->execute())
	{
		//if query doesn't execute
		echo "<p class=\"errtxt\">Error: could not save camper information</p>";
		die();
	}

	//store a message
	$_SESSION['message'] = "<h3>Your camper was successfully registered!</h3>";
	$_SESSION['success'] = 1;

}

//THIS IS A FUNCTION TO CHECK THE INPUT AS SUBMITTED IN Register.php
function checkReg()
{
	session_start();
	$uid = $_SESSION['uid'];

	//variable to control exit of function
	$die=0;

	//check to make sure the required forms have been filled out
	if(! $_POST['Lname'] || ! $_POST['phone'] || ! $_POST['CLname'] || ! $_POST['Cgrade'] || ! $_POST['cardName'] || ! $_POST['CSV'] || ! $_POST['Fname'] || ! $_POST['email'] || ! $_POST['CFname'] || ! $_POST['school'] || ! $_POST['Ccard'] || ! $_POST['expM'] || ! $_POST['expY'])
	{
		echo "<p class=\"errtxt\" >Please fill out all of the required fields</p>";
		$die=1;	
	}

	//grab the post variables and store them in new variables
	//could be optimized in a for each loop but that complicates how we define and access the variables
	$Fname = htmlspecialchars(trim($_POST['Fname']));
	$Lname = htmlspecialchars(trim($_POST['Lname']));
	$email = htmlspecialchars(trim($_POST['email']));
	$phone = htmlspecialchars(trim($_POST['phone']));
	$CFname = htmlspecialchars(trim($_POST['CFname']));
	$CLname = htmlspecialchars(trim($_POST['CLname']));
	$school = htmlspecialchars(trim($_POST['school']));
	$Cgrade = htmlspecialchars(trim($_POST['Cgrade']));
	$aller = htmlspecialchars(trim($_POST['aller']));
	$Cspec = htmlspecialchars(trim($_POST['Cspec']));
	$Ccard = htmlspecialchars(trim($_POST['Ccard']));
	$cardName = htmlspecialchars(trim($_POST['cardName']));
	$expM = htmlspecialchars(trim($_POST['expM']));
	$expY = htmlspecialchars(trim($_POST['expY']));
	$CSV = htmlspecialchars(trim($_POST['CSV']));
	$camp = $_POST['camp'];
	$age = $_POST['age'];
	$sex = $_POST['sex'];
	$week = $_POST['week'];

	//REGEXES
	//email regex
	$ereg = '/^[\w]+@[\w\.\-]+\.[a-zA-Z]{2,4}$/';
	//test to see if email works
	if(preg_match($ereg, $email) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but your email " . $email . " doesn't match the accepted format.</p>";
		$die=1;
	}

	//word regex
	$wreg = '/^[a-zA-Z\-\' ]+$/';
	
	//first name
	if(preg_match($wreg, $Fname) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, your first name doesn't match the accepted format.</p>";
		$die=1;
	}
	//last name
	if(preg_match($wreg, $Lname) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, your last name doesn't match the accepted format.</p>";
		$die=1;
	}
	//kid's first name
	if(preg_match($wreg, $CFname) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, your child's first name doesn't match the accepted format.</p>";
		$die=1;
	}
	//kid's last name
	if(preg_match($wreg, $CLname) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, your child's last name doesn't match the accepted format.</p>";
		$die=1;
	}
	//school
	if(preg_match($wreg, $school) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, your child's school name doesn't match the accepted format.</p>";
		$die=1;
	}

	//NUMBER REGEXES
	//phone
	$phonereg = '/^[\d]{10}$/';
	if(preg_match($phonereg, $phone) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but your phone number doesn't match the correct format (all digits).</p>";
		$die=1;
	}	
	//grade
	$gradereg = '/^[\d]+$/';
	if(preg_match($gradereg, $Cgrade) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but the grade entered doesn't match the correct format (all digits).</p>";
		$die=1;
	}
	
	//test grade further
	if($Cgrade < 1 || $Cgrade > 12)
	{
		echo "<p class=\"errtxt\">Sorry, the grade entered is not between 1 (1st grade) and 12 (senior in highschool).</p>"; 
		$die=1;
	}

	//card
	$cardreg = '/^[\d]{16}$/';
	if(preg_match($cardreg, $Ccard) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but your card number doesn't match the correct format (all digits).</p>";
		$die=1;
	}

	//expm
	$expmreg = '/^[0-1][0-9]$/';
	if(preg_match($expmreg, $expM) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but your expiration month doesn't match the correct format.</p>";
		$die=1;
	}

	//expy
	$expyreg = '/^[2][0][1-2][0-9]$/';
	if(preg_match($expyreg, $expY) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but your expiration year doesn't match the correct format</p>";
		$die=1;
	}

	//csv
	$csvreg = '/^[0-9]{3}$/';
	if(preg_match($csvreg, $CSV) === 0)
	{
		echo "<p class=\"errtxt\">Sorry, but your CSV doesn't match the correct format</p>";
		$die=1;
	}

	//initiate the db connection
	$con = mysqli_connect('dbserver.engr.scu.edu', 'holson', '00000755449', 'test');
	//test
	if(!$con)
	{
		echo "MySQL error cannot connect";
		die();
	}

	//run a query to grab the ages of the camp chosen
	$result = mysqli_query($con, "SELECT age_lo, age_hi FROM camp_locations WHERE location_name='$camp'");
	$row = mysqli_fetch_array($result);

	//test the age field to see if the camper is within the range
	if($age < $row[0] || $age > $row[1])
	{
		echo "<p class=\"errtxt\">Sorry, your camper is not in the appropriate age range for " . $camp . ".</p>";
		$die=1;
	}

	//do this after all variables have been tested
	if($die == 1)
	{
		die();
	}

	//at this point, all the information entered is valid
	//so we're going to store what's important
	$q = $con->prepare("INSERT INTO camper_info (parent_id, camp, age, gender, camper_fname, camper_lname, school, grade, week, allergies, special_inst)
		VALUES (?,?,?,?,?,?,?,?,?,?,?)");
	$q->bind_param('isissssisss', $uid, $camp, $age, $sex, $CFname, $CLname, $school, $Cgrade, $week, $aller, $Cspec);
	if(! $q->execute())
	{
		//query didn't go through, alert user
		echo "<p class=\"errtxt\">Error: could not save information to database.</p>";
		die();
	}

	//close mysql
	mysqli_close($con);

	//store a message
	$_SESSION['message'] = "<h3>Your camper was successfully registered!</h3>";
	$_SESSION['success'] = 1;
}

?>
