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
			padding: 0;
			background-color: #4caf50;
			border-radius: 30px;
		}
		.bar{
			width: 300px;
			height: 40px;
			background-color: #f44336; 
			transition: all 0.2s;
			border-radius: 30px;
		}
		.hp{
			padding-top: 8px;
    		color: white;
    		text-align: center;
		}
	</style>
</head>
<body>
    <div class="barcontainer">
		<div class="bar"><div class="hp"></div></div>
	</div>
</body>
<script>
var hpboss = 100;
function executeQuery() {
	$.ajax({
		url: "/node_modules/backend/api.php",
		type: "POST",
		dataType: "json",
	}).done(function(data) {
		hpboss = data;
	});
	setTimeout(executeQuery, 1000);
	console.log(hpboss);
	$(".hp").text(hpboss);
	var percent = 100-((hpboss/50000)*100);
	$(".bar").css("width", percent+"%");	
};
executeQuery();




</script>
</html>