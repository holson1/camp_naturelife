function initialize(){
	initHeader();
	initNav();
	initContent();
}


//	INITIALIZE NAVIGATION BAR
function initNav(){
	PageList = {
		"Home":"./index.php",
		"Register":"./Register.php",
		"Store":"./Store.php",
		"Camp Stats":"Stats.php",
		"Feedback": "Feedback.php",
		"Game": "Game.php",
	}
	for( var name in PageList){
		link = PageList[name];
		$(".NavBar").append("<a class=\"NavLink\" href=\""+link+"\">"+name+"</a");
		$(".NavBar").append("<a>|</a>");
	}

	//	Getting current page
	var ThisWindow = window.location.pathname;
	var node = ThisWindow.split("/");
	var link = node[node.length-1];

	//if no greeting is set
	if($("#greeting").length == 0) {

		$(".NavBar").append("<input id=\"createact\" type=\"button\" value=\"Create Account\" onclick=\"window.location.href='Register.php';\"/>");
		$(".NavBar").append("<input id=\"loginbutton\" type=\"button\" value=\"Login &nbsp;|\" onclick=\"showLogin();\"/>");
	}
	else {
		$(".NavBar").append("<a id=\"logoutbutton\" href=\"logout.php?page="+link+"\">Logout</a>");
	}
}

function initHeader(){
	
	$(".Header").append("<img class='headerLogo' src='./Images/Logo2.png'/>");

}

//	DOESNT DO ANYTHING JUST HERE FOR COMPLETENESS
function initContent(){
}

//	INITIALIZE FOOTER SECTION
function initFooter(){
}

//	SHOW LOGIN DIV
function showLogin() {
	//create a new div if one doesn't already exist
	if($("#login").length == 0)
	{
		$("body").append("<div id=\"login\"></div>");
	}

	//	Getting current page
	var ThisWindow = window.location.pathname;
	var node = ThisWindow.split("/");
	var link = node[node.length-1];

	//add content to the div
	$("#login").html("<h1>Login</h1>");
	$("#login").append("<input type=\"button\" id=\"closelogin\" value=\"X\" onclick=\"removeLogin();\" />");
	$("#login").append("<form id=\"loginform\" name=\"loginform\" action=\"login.php?page="+link+"\" method=\"post\">");
	$("#loginform").html("<label for=\"logEmail\">Email Address</label>");
	$("#loginform").append("<br/>");
	$("#loginform").append("<input type=\"text\" name=\"logEmail\" />");
	$("#loginform").append("<br/>");
	$("#loginform").append("<label for=\"logPW\">Password</label>");
	$("#loginform").append("<br/>");
	$("#loginform").append("<input type=\"password\" name=\"logPW\" />");
	$("#loginform").append("<br/>");
	$("#loginform").append("<input type=\"submit\" value=\"Submit\" />");
	$("#loginform").append("</form>");
}

//	HIDE LOGIN DIV
function removeLogin() {
	$("#login").remove();
}

//	SET CAMP ON REGISTER PAGE
function setCamp(choice) {
	var select = $("#campsel");
	select.val(choice);
	updateWeek(choice);
}


//	DISPLAY CAMP INFORMATION
function campInfoDisplay(place) {
	//insert the camp name
	$("#campname").html(place);

	//insert the camp location
	$("#camploc").html(campInfo[place].loc);

	//weeks offered
	$("#weeks").html("Weeks offered: ");
	//grab the weeks offered
	var wkarray = campInfo[place].weeks;

	//insert into the html, while formatting w/ commas
	for(var i=0; i<(wkarray.length); i++) {
		if(i < (wkarray.length - 1))
			$("#weeks").append(wkarray[i] + ", ");
		else
			$("#weeks").append(wkarray[i]);
	}

	//insert the accepted ages
	$("#campages").html("Ages accepted: " + campInfo[place].ages[0] + "-" + campInfo[place].ages[1] + " years old");

	//insert the description
	$("#campdesc").html(campInfo[place].desc);

	//activities
	$("#actheader").html("Activities: ");
	var actarray = campInfo[place].activities;

	//insert activities into the html, while formatting w/ commas
	$("#activities").html("");
	for(i=0; i<(actarray.length); i++) {
		$("#activities").append("<li>" + actarray[i] + "</li>");
	}

	//add the register button
	$("#reg").html("<input type='button' onclick='parent.location=\"Register.php?camp=" + place + "\"' value='Register now!'/>");
}

//	UPDATE WEEK SELECTION WHEN CAMP SELECTION CHANGES
function updateWeek(place) {
	
	//if nothing was passed
	if(updateWeek.arguments.length == 0) {
	var sel = $("#campsel");
	var place = sel.val();
	}

	//grab the weeks for that particular camp
	var wkarray = campInfo[place].weeks;

	//insert into the select
	$("#weeksel").html("<option value=\"" + wkarray[0] + "\">" + wkarray[0] + "</option>");
	for(var i=1; i<(wkarray.length); i++) {
		$("#weeksel").append("<option value=\"" + wkarray[i] + "\">" + wkarray[i] + "</option>");
	}
}

//	CALCULATE TOTAL FEE
function calculateFee(numChildReg) {
	//grab the selected camp
	var sel = $("#campsel");
	var place = sel.val();
	
	//grab the rate for that particular camp
	var rate = campInfo[place].fee;
	//compute the discount
	var discount = rate * (numChildReg * .1);
	//now compute the total fee
	var totalFee = rate - discount;

	//insert the value into the html
	$("#totalfee").html("Total fee: $" + totalFee);
}

//	IF AN ERROR OCCURS IN REGISTRATION, FOCUS ON THAT TEXT
function errFocus() {
}


	//	CAMP INFORMATION
var campInfo = [];
campInfo['Camp Yosemite'] = {
	loc: "250 State Dr, Yosemite Village, CA, 95380",
	ages: [12, 16],
	weeks: ["7/27", "8/3", "8/10", "8/17", "8/24"],
	activities: ["Bouldering and beginner's rock climbing", "Nature hikes", "Woodland arts & crafts", "Animal tracking", "Hammock weaving", "Native American tool crafting"],
	desc: "Join us for a week of adventure and fun in scenic Yosemite national park! This overnight camp engages older children and teenagers with exciting activities and wilderness survival lessons. (Overnight, $200/w)",
	fee: 200
	};
campInfo['Camp Marin'] = {
	loc: "Wildcat Campground, Hwy 1, CA, 94956",
	ages: [12, 16],
	weeks: ["7/6", "7/13", "8/3", "8/10"],
	activities: ["Kayaking and canoeing", "Tidepool exploration", "Elephant seal watching", "Beach hikes", "Beach fort competition", "Marine wildlife workshops"],
	desc: "Surf's up! Get excited for a beachside exploration at Camp Marin, where older children and teenagers will spend time kayaking, exploring the wildlife of the beaches, and camping out in some of Marin County's most beautiful vistas. (Overnight, $200/w)",
	fee: 200
	};
campInfo['Camp Coe'] = {
	loc: "Henry W. Coe State Park, Morgan Hill, CA, 95037",
	ages: [8, 12],
	weeks: ["6/1", "6/8", "6/15", "6/22", "7/6", "7/13", "7/20", "7/27", "8/3"],
	activities: ["Outdoor arts and crafts", "Nature hikes", "Tent construction basics", "Identifying invasive species", "Field games", "Animal parade"],
        desc: "Hey there young campers! Camp Coe is our most popular camp for beginning outdoor enthusiasts, featuring tons of interactive ways to get to know the nature around us. (9AM - 3:30PM, $50/w)",
	fee: 50
	};
campInfo['Camp Diablo'] = {
	loc: "Mt. Diablo State Park, 96 Mitchel Canyon Fire Rd, Clayton, CA, 94517",
	ages: [10, 16],
	weeks: ["6/1","7/20", "7/27", "8/10", "8/17"],
	activities: ["Orienteering", "All-terrain hikes", "Fire building", "Cooking around the campfire", "Waste-free shelters"],
	desc: "Do you want to learn how to survive in the wilderness? This small-sized, medium age-group camp leads a rigorous yet memorable expedition through the Mt. Diablo countryside, teaching imporant survival skills along the way. (Overnight, $200/w)",
	fee: 200
	};
campInfo['Camp Castle Rock'] = {
	loc: "Castle Rock State Park, 15000 Skyline Blvd, Los Gatos, CA, 95033",
	ages: [8, 12],
	weeks: ["6/15", "6/22", "7/6", "7/13", "7/20", "7/27", "8/24"],
	activities: ["Beach exploration", "Learn about tidepool habitats", "Driftwood crafts", "Beach sustainability lessons", "Flying kites", "Sand castle competition"],
	desc: "New for Summer 2014, Camp Castle Rock gives younger kids an opportunity to learn about California's coasts while having tons of fun! Campers will learn all about sustainability and keeping our beaches clean, while they play and make memories that will last a lifetime. (9AM - 3:30 PM, $100/w)",
	fee: 100
	};



