<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Pre MWIT 2018</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="/node_modules/materialize-css/dist/css/materialize.min.css" rel="stylesheet">
	<link href="/node_modules/tether/dist/css/tether.min.css" rel="stylesheet">
	<script src="/node_modules/jquery/dist/jquery.js"></script>
	<script src="/node_modules/tether/dist/js/tether.min.js"></script>
	<script src="/node_modules/materialize-css/dist/js/materialize.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<script src="https://www.gstatic.com/firebasejs/4.8.1/firebase.js"></script>
	<script>
	  // Initialize Firebase
	  var config = {
		apiKey: "AIzaSyAEX9X8bnUyVoI2OKMhJqy3dJmEErzRRXc",
		authDomain: "pre-mwits-2018-cdn.firebaseapp.com",
		databaseURL: "https://pre-mwits-2018-cdn.firebaseio.com",
		projectId: "pre-mwits-2018-cdn",
		storageBucket: "pre-mwits-2018-cdn.appspot.com",
		messagingSenderId: "655785045663"
	  };
	  
	  firebase.initializeApp(config);
	  var db = firebase.database().ref().child('boss');	
	</script>
	<style>
		body{
			font-family: 'Kanit', sans-serif;
		}
		.barcontainer{
			margin-left: auto;
			margin-right: auto;
			margin-top: 35px;
			width: 500px;
			height: 40px;
			padding: 8px;
			background-color: #eceff1;
			border-radius: 30px;
			padding-top: 8px;
			padding-left: 8px;
		}
		.bar{
			height: 24px;
			background-color: #4caf50;
			transition: all 0.2s;
			border-radius: 30px;
		}
		.hp{
			padding-top: 8px;

    		text-align: center;
		}
	</style>
</head>
<body>
    <div class="barcontainer">
		<div class="bar"></div>
	</div>
	<div class="hp"></div>
	<div class="atk">Attacked</div>
</body>
<script>
$.fn.extend({
    animateCss: function (animationName, callback) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        this.addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
            if (callback) {
              callback();
            }
        });
        return this;
    }
});

var bosshp = db.child('dmgdiff');
var hpboss = 0; 
var atk = firebase.database().ref().child('holdval');
atk.on('value',snap => {
	$(".atk").animateCss('flash');
	console.log("attacked");
});
bosshp.on('value',snap => {
	hpboss = 500000 + snap.val();
	var percent = (hpboss/500000)*100;
	$(".hp").text(Math.floor(500000*(percent/200)));
	$(".bar").css("width", percent/2+"%");	
});

/*
function executeQuery() {
	$.ajax({
		url: "/node_modules/backend/api.php",
		type: "POST",
		dataType: "json",
	}).done(function(data) {
		hpboss = data;
	});
	setTimeout(executeQuery, 100);
	console.log(hpboss);
	$(".hp").text(hpboss);
	var percent = 50-((hpboss/500000)*100);
	$(".bar").css("width", percent+"%");	
};
executeQuery();
*/



</script>
</html>