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
		canvas {
			border: 1px solid #d3d3d3;
			background-color: #42ff64;
		}
		button{
			margin: 5px;
		}
	</style>
</head>
<body>
    
</body>
<script>
$.ajax({
  	url: "/node_modules/backend/api.php",
  	type: "POST",
	dataType: "json",
}).done(function(data) {
  console.log(data);
});


</script>
</html>