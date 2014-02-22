
var score=0;
var leafHeight;
var leafWidth;

function GameManager(){

	//register gamecontrol events

	$('#selectG1').on('mousedown', function(){
		this.style.backgroundColor='#144414';
		$('*').on('mouseup', function(){
			$('#selectG1').css('background-color','#218321');
		});
	});

	document.getElementById("selectG1").onclick=function(){
		document.getElementById("gameControl").style.visibility="hidden";
		var game = Game1();
	}
}


function Game1(){

	setInterval(function(){shrinkLeaf(score)}, 40);
	leafHeight = 0;
	leafWidth = 0;

	makeMainLeaf();

}

function makeMainLeaf(){

	leafHeight = 200;
	leafWidth = 200;
	var leaf = document.createElement("div");
	leaf.id = "leaf";
	leaf.style.left = Math.floor((Math.random() * 500)+100) +"px";
	leaf.style.top = Math.floor((Math.random() * 300)+100) +"px";
	leaf.style.height=leafHeight+'px';
	leaf.style.width=leafWidth+'px';
	leaf.onclick = clickLeaf;
	var gameArea = document.getElementById("gameArea");
	gameArea.appendChild(leaf);

}

function removeLeaf(leaf){
	var parent = document.getElementById("gameArea");
	parent.removeChild(leaf);
}

function clickLeaf(){

	removeLeaf(this);
	makeMainLeaf();
	score++;

}

function shrinkLeaf(score){

	shrinkRate = score*.4;
	var leaf = document.getElementById("leaf");
	if( leaf != null){
		leafHeight -= shrinkRate;
		leafWidth -= shrinkRate;
		leaf.style.height = leafHeight+'px';
		leaf.style.width = leafWidth+'px';
		if(leafWidth < 10){
			gameOver();
		}
	}
}

function gameOver(){
	document.getElementById('gameControl').style.visibility = '';
	document.getElementById('gameControl').innerHTML = '<h1> Game Over </h1><p> You caught '+score+' leaves!</p>';
}


function updateBoard(){



}


