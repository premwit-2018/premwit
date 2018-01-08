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

    if($row['status'] != 'admin'){
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
			var provider = new firebase.auth.GoogleAuthProvider();
			provider.addScope('https://www.googleapis.com/auth/contacts.readonly');


			var db = firebase.database();


			function tofb(val) {
				var newPostKey = db.ref('/history/').push().key;
				var updates = {};
				updates['/history/' + newPostKey] = val;
				return db.ref('history/' + newPostKey).update({
					item: val,
					timestamp: firebase.database.ServerValue.TIMESTAMP,
				});
			}


			function push() {
				db.ref("boss").set({
					dmgdiff: dmgdiff,
				});
			}

			function clr() {
				for (i = 1; i <= 20; i++) {
					db.ref('map/Group ' + i + '/order/').remove();
					for (j = 1; j <= 10; j++) {
						db.ref('map/Group ' + i + '/' + j).set("false");
					}
				}
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

			.content {
				margin: auto;
				max-width: 640px;
				padding: 20px;
				padding-top: 40px;
			}
		</style>
		<script>
			var wingoal = 500000;
			var dmgdiff = 0;
			var bossex = 1;
			var bossamp = 1;
			var stdex = 1;
			var stdamp = 1;
			var stdadd = 0;
			var time = 0;
			var boss_tempmod = 1;
			var stud_tempmod = 1;
			var booster_countdown = 0;
			var stun = 0;
			var bossphase = 1;
			var tincrement = 1;
			var item_13_check = 0;
			var item_14_check = 0;
			var paused = false;
			var time_s = 0;

			function bossdmg(damage) {
				dmgdiff -= damage;
			}

			function studentdmg(damage) {
				dmgdiff += damage;
			}

			function gethpx() {
				var x = 480 * (dmgdiff + wingoal) / (wingoal * 2);
				return x;
			}




		function getdpss() {
			return ((100 + stdex) * (1 + 0.5 * (1.2 * Math.log(Math.E + (time_s / 50)))) * (1.2 * Math.log(Math.E + (time_s / 50))) *
				(stdamp) + (stdadd)) * stud_tempmod;
		}

		function getdpsb1() {
			return (150 + bossex) * (1 + 0.5 * (1 * Math.log(Math.E + (time / 50))) * (1 * Math.log(Math.E + (time / 50))) *
				Math.log(100 / getbossperc())) * (bossamp);
		}

		function getdpsb2() {
			return (300 + bossex) * (1 + 0.5 * (1.0 * Math.log(Math.E + (time / 25))) * (1.0 * Math.log(Math.E + (time / 25))) *
				Math.log(800 / getbossperc())) * (bossamp);
		}


			function damagetoboss() {
				dmgdiff -= (getdpss() * 0.1);
			}

			function damagetostd() {
				if (stun <= 0)
					if (bossphase == 1)
						dmgdiff += (getdpsb1() * 0.1);
					else
						dmgdiff += (getdpsb2() * 0.1);
			}


			function timer() {
				time += tincrement;
				time_s += 1;
				if (time < 0) {
					time = 0;
				}
			}

			function stun_boss(seconds) {
				if (stun != 0) {
					stun += seconds;
					return;
				}
				stun = seconds;
				stundur = setInterval(function () {
					stun_countdown();
				}, 1000);

			}

			function stun_countdown() {
				stun -= 1;
				if (stun == 0) {
					clearInterval(stundur);
				}
			}

			function getbossperc() {
				var bperc;
				bperc = 100 * (wingoal + dmgdiff) / (wingoal * 2);
				if (bperc < 0) {
					return 0.01;
				}
				return bperc;
			}


			tupdate = setInterval(function () {
				timer();
			}, 1000);
			sdps = setInterval(function () {
				damagetoboss()
			}, 100);
			bdps = setInterval(function () {
				damagetostd()
			}, 100);

			setInterval(function () {
//				timer();
				$(".time").text(time);
				console.log(time);
			}, 1000);

			function manual_atk(dmg) {
				dmgdiff -= dmg;
				if (item_13_check == 1) {
					stdex += 0.5;
				}
				if (item_14_check == 1) {
					stdadd += 0.1;
				}
			}

			function item_main_1() {
				stun_boss(5);
			}

			function item_main_2() {
				stdadd += 10;
			}

			function item_main_3() {
				stdex += 20;
			}

			function item_main_4() {
				dmg = getdpss() * 5;
				dmgdiff = dmgdiff - dmg;
			}

			function item_extra_1() {
				bossamp = bossamp * 0.95;
			}

			function item_extra_2() {
				stdamp = stdamp * 1.05;
			}

			function item_extra_3() {
				time = time / 1.25;
				tincrement = tincrement / 1.25;
			}

			function item_extra_4() {
				stdadd += 50;
			}

			function item_extra_6() {
				stdex += 100;
			}

			function item_extra_7() {
				if (bossphase == 1) {
					dmg = getdpsb1() * 0.75;
				} else {
					dmg = getdpsb2() * 0.75;
				}
				dmgdiff = dmgdiff - dmg;
			}

			function bstcountdown_std() {
				booster_countdown -= 1;
				if (booster_countdown == 0) {
					clearInterval(a);
					stud_tempmod /= 2;
				}
			}

			function item_extra_8() {
				if (booster_countdown != 0)

				{
					booster_countdown += 60;
					return;
				}
				stud_tempmod *= 2;
				booster_countdown = 60;
				a = setInterval(function () {
					bstcountdown_std()
				}, 1000);
			}

			function bstcountdown_boss() {
				booster_countdown -= 1;
				if (booster_countdown == 0) {
					clearInterval(a);
					boss_tempmod *= 2;
				}
			}

			function item_extra_9() {
				boss_tempmod /= 2;
				booster_countdown = 60;
				a = setInterval(function () {
					bstcountdown_boss()
				}, 1000);
			}

			function item_extra_10() {
				stun_boss(15);
			}

			function item_extra_11() {
				time -= 100;
			}

			function item_extra_12() {
				dmgdiff = ((dmgdiff + wingoal) / 2) - wingoal;
				//console.log(dmgdiff);
			}

			function item_extra_13() {
				item_13_check = 1;
			}

			function item_extra_14() {
				item_14_check = 1;
			}

			function pause() {
				if (!paused) {
					clearInterval(tupdate);
					clearInterval(sdps);
					clearInterval(bdps);
					paused = true;
				}
			}

			var balancehits = 0;

			function balancer(_hit) {
				if (balancehits != 0) {
					balancehits += _hits;
					return;
				}

				balancehits = hits;
				bhit = setInterval(function () {
					balancer_cd()
				}, 100);

			}

			function balancer_cd() {
				balancehits -= 1;
				dmgdiff += 5000;
				if (balancehits == 0) {
					clearInterval(bhit);
				}

			}

			function play() {
				if (paused) {
					tupdate = setInterval(function () {
						timer();
					}, 1000);
					sdps = setInterval(function () {
						damagetoboss()
					}, 100);
					bdps = setInterval(function () {
						damagetostd()
					}, 100);
					paused = false;
				}
			}
			function reset() {
				db.ref("boss").set({
					dmgdiff: 0,
				});
				db.ref("history").remove();
			}
			
		</script>
	</head>

	<body>

		<div id="modal1" class="modal">
			<div class="modal-content">
				<h4>Are you sure?</h4>
			</div>
			<div class="modal-footer">
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancle</a>
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat red-text" id="reset">Reset the DB</a>
			</div>
		</div>
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
					<div class="collapsible-header">dmgdiff:&nbsp;
						<span class="dmgdiff">sign in first</span>
						
					</div>
					<div class="collapsible-body">
						<button class="btn waves-effect waves-light auth" onclick="firebase.auth().signInWithRedirect(provider);">
							Auth
						</button>
						<button class="red btn waves-effect waves-light out">
							Sign Out
						</button>
					</div>
				</li>
				<li>
					<div class="collapsible-header" id="console">Console:&nbsp;
						<span id="phaselog">Phase 1</span>
					</div>
					<div class="collapsible-body">
						<button class="btn blue wave-effect waves-light" id="start" onclick="tofb('run')">Start Game</button>
						<button class="btn wave-effect waves-light" id="phase">Switch Phase 2</button>
					</div>
				</li>
				<li>
					<div class="collapsible-header">Time:&nbsp;
						<span class="time"></span>
						
					</div>	
				</li>				
				<li>
					<div class="collapsible-header">
						Administrator Tools
					</div>
					<div class="collapsible-body">
						<button class="btn waves-effect waves-light" onclick="tofb('001')">CONTINUE GAME</button>
						<button class="btn waves-effect waves-light" onclick="tofb('002')">PAUSE GAME</button>
						<button class="btn waves-effect waves-light" onclick="tofb('003')">DEAL DAMAGE TO STUDENT, FOR BALANCING OUT</button>
						<button class="red btn waves-effect waves-light" id="toreset">Reset DB(Danger!!)</button>

					</div>
				</li>

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
	</body>
	<script>
		firebase.database().ref('history').on("child_added", function (data) {
			console.log(data.val()["item"]);
			var id = data.val()['item'];
			if (id == '901') {
				manual_atk(500);
			} else if (id == '001') {
				play();
			} else if (id == '002') {
				pause();
			} else if (id == '003') {
				balancer(10);
			} else if (id == '902') {
				manual_atk(10000);
			} else if (id == '101') {
				item_main_1();
			} else if (id == '102') {
				item_main_2();
			} else if (id == '103') {
				item_main_3();
			} else if (id == '104') {
				item_main_4();
			} else if (id == '201') {
				item_extra_1();
			} else if (id == '202') {
				item_extra_2();
			} else if (id == '203') {
				item_extra_3();
			} else if (id == '204') {
				item_extra_5();
			} else if (id == '205') {
				item_extra_6();
			} else if (id == '206') {
				item_extra_7();
			} else if (id == '207') {
				item_extra_8();
			} else if (id == '208') {
				item_extra_9();
			} else if (id == '209') {
				item_extra_10();
			} else if (id == '210') {
				item_extra_11();
			} else if (id == '211') {
				item_extra_12();
			} else if (id == '212') {
				item_extra_13();
			} else if (id == '213') {
				item_extra_14();
			}



		});
		$(document).ready(function () {
			pause();
			$("#phase").hide()
			$(".out").hide();
			$('.logout').click(function () {
				window.location.replace("logout.php");
			});
			$('.modal').modal();
			$(".button-collapse").sideNav();
			$('select').material_select();
		});
		$("#phase").click(function () {
			$("#phase").hide();
			$("#start").removeClass("disabled");
			$("#phaselog").text("Phase 2");
			tofb('phasechange');
			bossphase = 2;
			dmgdiff = 0;
			
			reset();
			
			Materialize.toast('Phase 2 activated', 4000);
			$("#phase").hide(300);
		});
		$("#reset").click(function () {
			db.ref('history').remove();
			Materialize.toast('DB has been reset', 4000)
		});
		$("#toreset").click(function () {
			$('#modal1').modal('open');
		});
		firebase.auth().getRedirectResult().then(function (result) {

			if (result.credential) {
				var token = result.credential.accessToken;
				console.log(token);
				var user = result.user;
				$(".dmgdiff").text("Waiting for start command");
				Materialize.toast('Signed in waiting to start', 2000);
				tofb('connected');
				$(".auth").hide();
				$(".out").show();
				reset();

				$("#start").click(function () {
					
					$("#start").addClass("disabled");
					function executeQuery() {
						push(dmgdiff);
						setTimeout(executeQuery, 100);
					};
					executeQuery();
					play();
					setInterval(function () {
						$(".dmgdiff").text(dmgdiff);
						if (dmgdiff < -500000) {
							pause();
							dmgdiff = -500000;
							$("#phase").show();
							tofb("won");
							clearInterval(this);							
						}
						else if(dmgdiff > 500000){
							pause();
							dmgdiff = -500000;
							$("#phase").show();
							tofb("lost");
							clearInterval(this);														
						}
					}, 100);
				});

			}


			console.log(user.uid);
		}).catch(function (error) {
			// Handle Errors here.
			var errorCode = error.code;
			var errorMessage = error.message;
			// The email of the user's account used.
			var email = error.email;
			// The firebase.auth.AuthCredential type that was used.
			var credential = error.credential;
			// ...
		});
		$(".out").click(function () {
			firebase.auth().signOut().then(function () {
				$(".auth").show();
				$(".out").hide();
			}).catch(function (error) {
				// An error happened.
			});
		})
	</script>

	</html>