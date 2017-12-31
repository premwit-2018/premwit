<?php
session_start();
if(isset($_SESSION['id'])){
    require_once "dbhelper.php";
    $conn = connect_db();
    if(!$conn){
        echo "<p> Connection Error </p>";
        close_db($conn);
        die();
    }
    $getdata = $conn->prepare("SELECT * FROM user WHERE id = ?");
    $getdata->bind_param('s',$_SESSION['id']);
    $getdata->execute();
    $userdata = $getdata->get_result();
    $row = $userdata->fetch_array(MYSQLI_ASSOC); //all data from db in array sql injection protected

    if($row['status'] != 'dev'){
        header("location: index.php");
    }
}   
else{
    header("location: index.php");
}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Pre MWIT 2018 | Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="/node_modules/materialize-css/dist/css/materialize.min.css" rel="stylesheet">
	<link href="/node_modules/tether/dist/css/tether.min.css" rel="stylesheet">
	<script src="/node_modules/jquery/dist/jquery.js"></script>
	<script src="/node_modules/tether/dist/js/tether.min.js"></script>
	<script src="/node_modules/materialize-css/dist/js/materialize.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Kanit:300,400|Material+Icons" rel="stylesheet">
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

		var db = firebase.database();

		function tofb(val) {
			var newPostKey = db.ref('/history/').push().key;
			var updates = {};
			updates['/history/' + newPostKey] = val;
			return db.ref('history/'+newPostKey).update({
                item: val,
                timestamp: firebase.database.ServerValue.TIMESTAMP,
            });
		}
	</script>
	<style>
		@media(min-width: 600px) {

			.brand-logo {
				margin-left: 20px;
				font-size: 2em;
				white-space: nowrap;
			}
		}

		@media(max-width: 600px) {

			.brand-logo {
				margin-left: 0px;
				font-size: 1.5em !important;
				white-space: nowrap;
			}
		}

		body {
			font-family: 'Kanit', sans-serif;
		}

		canvas {
			border: 1px solid #d3d3d3;
			background-color: #42ff64;
		}

		button {
			margin: 5px;
		}
		.content{
			margin: auto;
			max-width: 640px;
			padding: 20px;
			padding-top: 40px;
		}
	</style>
	<script>

	</script>
</head>

<body>
	<ul class="side-nav" id="mobile-demo" style="padding-top: 24px;">
		<li class="sidebar">
			<a class="logout" href="#">Log Out</a>
		</li>
	</ul>
	<div class="navbar-fixed">
		<nav class="nav-extended blue-grey darken-4">
			<div class="nav-wrapper">
				<a href="#" class="brand-logo">Pre-MWITS Staff</a>
				<a href="#" data-activates="mobile-demo" class="button-collapse">
					<i class="material-icons">menu</i>
				</a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li>
						<a class="logout" href="#">Log Out</a>
					</li>
				</ul>

			</div>
		</nav>
	</div>
	<div class="content">
	
	<ul class="collapsible popout" data-collapsible="accordion">
		<li>
			<div class="collapsible-header">
				Manual Attack
			</div>
			<div class="collapsible-body">
				<button class="btn waves-effect waves-light" onclick="tofb('901')">MNL ATK 500</button>
				<button class="btn waves-effect waves-light" onclick="tofb('902')">MNL ATK 10000</button>


			</div>
		</li>
		<li>
			<div class="collapsible-header">
				Common Items
			</div>
			<div class="collapsible-body">
				<button class="btn waves-effect waves-light" onclick="tofb('101')">STUN BOSS 5</button>
				<button class="btn waves-effect waves-light" onclick="tofb('102')">DPS B +10</button>
				<button class="btn waves-effect waves-light" onclick="tofb('103')">ATK B +20</button>
				<button class="btn waves-effect waves-light" onclick="tofb('104')">INST DAMAGE 5 SEC</button>
			</div>
		</li>
		<li>
			<div class="collapsible-header">
				Rare Items
			</div>
			<div class="collapsible-body">
				<button class="btn waves-effect waves-light" onclick="tofb('201')">BOSS DPS 0.95</button>
				<button class="btn waves-effect waves-light" onclick="tofb('202')">STUDENT DPS 1.05</button>
				<button class="btn waves-effect waves-light" onclick="tofb('203')">Time/1.25</button>
				<button class="btn waves-effect waves-light" onclick="tofb('204')">DPS B +50</button>
				<button class="btn waves-effect waves-light" onclick="tofb('205')">ATK B +100</button>
				<button class="btn waves-effect waves-light" onclick="tofb('206')">BOSS DMG COUNTER 0.75</button>
				<button class="btn waves-effect waves-light" onclick="tofb('207')">DMGx2 1 MIN</button>
				<button class="btn waves-effect waves-light" onclick="tofb('208')">BOSSx0.5 1MIN</button>
				<button class="btn waves-effect waves-light" onclick="tofb('209')">SNOWBALL STUN</button>
				<button class="btn waves-effect waves-light" onclick="tofb('210')">FLASHBACK</button>
				<button class="btn waves-effect waves-light" onclick="tofb('211')">%BOSS / 2</button>
				<button class="btn waves-effect waves-light" onclick="tofb('212')">MANUAL ATK ATK+0.5</button>
				<button class="btn waves-effect waves-light" onclick="tofb('213')">MANUAL ATK DPS+0.1</button>
			</div>
		</li>
	</ul>
	</div>
	<script>
        $(document).ready(function () {
            $('.logout').click(function () {
                window.location.replace("logout.php");
            });
            $('.modal').modal();
            $(".button-collapse").sideNav();
            $('select').material_select();
        });		

	</script>

</html>