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

		var db = firebase.database().ref().child('boss');
		var bosshp = db.child('hp');
		var holdon = firebase.database().ref().child('holdval');

		function write() {
			var newPostKey = firebase.database().ref('holdval').push().key;
			var updates = {};
			updates['/holdval/' + newPostKey] = "true";
			return firebase.database().ref().update(updates);
		}

		function push() {
			db.set({
				dmgdiff: dmgdiff,
			});
		};
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


		//			var healthbar = {
		//				canvas : document.createElement("canvas"),
		//				start : function() {
		//					this.canvas.width = 480;
		//					this.canvas.height = 50;
		//					this.context = this.canvas.getContext("2d");
		//					document.body.insertBefore(this.canvas, document.body.childNodes[0]);
		//					bosshp = new component(480,50,"red",-240,0);
		//				}
		//
		//			}

		//			healthbar.start();

		function component(width, height, color, x, y, type) {
			this.type = type;
			this.score = 0;
			this.width = 480;
			this.height = 50;
			this.speedX = 0;
			this.speedY = 0;
			this.x = x;
			this.y = y;
			this.update = function () {
				ctx = healthbar.context;
				if (this.type == "text") {
					ctx.font = this.width + " " + this.height;
					ctx.fillStyle = color;
					ctx.fillText(this.text, this.x, this.y);
				} else {
					this.x = gethpx();
					ctx.fillStyle = "#42ff64";
					ctx.fillRect(0, 0, 480, 50);
					ctx.fillStyle = color;
					ctx.fillRect(0, 0, this.x, this.height);
					//console.log(this.x);
				}

			}
		}

		//bosshp.update();

		function bossdmg(damage) {
			dmgdiff -= damage;
			//bosshp.update();
			//console.log(bosshp.x);
		}

		function studentdmg(damage) {
			dmgdiff += damage;
			//bosshp.update();
			//console.log(bosshp.x);
		}

		function gethpx() {
			var x = 480 * (dmgdiff + wingoal) / (wingoal * 2);
			//console.log("X=")
			return x;
		}




		function getdpss() {
			return ((100 + stdex) * (1 + 0.5 * (1.2 * Math.log(Math.E + (time_s / 50)))) * (1.2 * Math.log(Math.E + (time_s / 50))) *
				(stdamp) + (stdadd)) * stud_tempmod;
		}

		function getdpsb1() {
			return (150 + bossex) * (1 + 0.5 * (1 * Math.log(Math.E + (time / 50))) * (1 * Math.log(Math.E + (time / 50))) *
				Math.log(400 / getbossperc())) * (bossamp);
		}

		function getdpsb2() {
			return (275 + bossex) * (1 + 0.5 * (1.2 * Math.log(Math.E + (time / 100))) * (1.2 * Math.log(Math.E + (time / 100))) *
				Math.log(400 / getbossperc())) * (bossamp);
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
			if(time<0)
			{
				time=0;
			}
		}

		function stun_boss(seconds) {
			if(stun != 0)
			{
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
			bperc =	100 * (wingoal + dmgdiff) / (wingoal * 2);
			if(bperc<0)
			{
				return 0.01;
			}
			return bperc;
		}

		setInterval(function () {
			$(".dmgdiff").text(dmgdiff)
		}, 100);
		//setInterval(function(){console.log("Boss dps ="+getdpsb1())},100);
		//setInterval(function(){console.log("Student dps ="+getdpss())},100);
		tupdate = setInterval(function () {
			timer();
		}, 1000);
		sdps = setInterval(function () {
			damagetoboss()
		}, 100);
		bdps = setInterval(function () {
			damagetostd()
		}, 100);
		//setInterval(function(){bosshp.update()},100);


		setInterval(function () {
			timer();
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
		
		function pause()
		{
			if(!pause)
			{
				clearInterval(tupdate);
				clearInterval(sdps);
				clearInterval(bdps);
				paused = true;
			}
		}
		
		var balancehits = 0;
		
		function balancer(_hit)
		{
			if(balancehits != 0)
			{
				balancehits += _hits;
				return;
			}
			
			balancehits = hits;
			bhit = setInterval(function(){balancer_cd()},100);
			
		}
		
		function balancer_cd()
		{
			balancehits-=1;
			dmgdiff += 5000;
			if(balancehits == 0)
			{
				clearInterval(bhit);
			}	
			
		}
		
		function play()
		{
			if(paused)
			{
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
			<div class="collapsible-header">dmgdiff:&nbsp; <span class="dmgdiff"></span></div>
			<div class="collapsible-body">
				<a class="btn-floating waves-effect waves-light"><i class="material-icons">play_arrow</i></a>
				<a class="btn-floating waves-effect waves-light"><i class="material-icons">pause</i></a>
			</div>
		</li>
		<li>
			<div class="collapsible-header">
				Administrator Tools
			</div>
			<div class="collapsible-body">
				<button class="btn waves-effect waves-light" onclick="play()">CONTINUE GAME</button>
				<button class="btn waves-effect waves-light" onclick="pause()">PAUSE GAME</button>
				<button class="btn waves-effect waves-light" onclick="balancer(10)">DEAL DAMAGE TO STUDENT, FOR BALANCING OUT</button>

			</div>
		</li>
		<li>
			<div class="collapsible-header">
				Manual Attack
			</div>
			<div class="collapsible-body">
				<button class="btn waves-effect waves-light" onclick="manual_atk(500)">MNL ATK 500</button>
				<button class="btn waves-effect waves-light" onclick="manual_atk(10000)">MNL ATK 10000</button>


			</div>
		</li>
		<li>
			<div class="collapsible-header">
				Common Items
			</div>
			<div class="collapsible-body">
				<button class="btn waves-effect waves-light" onclick="item_main_1()">STUN BOSS 5</button>
				<button class="btn waves-effect waves-light" onclick="item_main_2()">DPS B +10</button>
				<button class="btn waves-effect waves-light" onclick="item_main_3()">ATK B +20</button>
				<button class="btn waves-effect waves-light" onclick="item_main_4()">INST DAMAGE 5 SEC</button>
			</div>
		</li>
		<li>
			<div class="collapsible-header">
				Rare Items
			</div>
			<div class="collapsible-body">
				<button class="btn waves-effect waves-light" onclick="item_extra_1()">BOSS DPS 0.95</button>
				<button class="btn waves-effect waves-light" onclick="item_extra_2()">STUDENT DPS 1.05</button>
				<button class="btn waves-effect waves-light" onclick="item_extra_3()">Time/1.25</button>
				<button class="btn waves-effect waves-light" onclick="item_extra_5()">DPS B +50</button>
				<button class="btn waves-effect waves-light" onclick="item_extra_6()">ATK B +100</button>
				<button class="btn waves-effect waves-light" onclick="item_extra_7()">BOSS DMG COUNTER 0.75</button>
				<button class="btn waves-effect waves-light" onclick="item_extra_8()">DMGx2 1 MIN</button>
				<button class="btn waves-effect waves-light" onclick="item_extra_9()">BOSSx0.5 1MIN</button>
				<button class="btn waves-effect waves-light" onclick="item_extra_10()">SNOWBALL STUN</button>
				<button class="btn waves-effect waves-light" onclick="item_extra_11()">FLASHBACK</button>
				<button class="btn waves-effect waves-light" onclick="item_extra_12()">%BOSS / 2</button>
				<button class="btn waves-effect waves-light" onclick="item_extra_13()">MANUAL ATK ATK+0.5</button>
				<button class="btn waves-effect waves-light" onclick="item_extra_14()">MANUAL ATK DPS+0.1</button>
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
		function executeQuery() {
			console.log(dmgdiff);
			push(dmgdiff);
			setTimeout(executeQuery, 100);
		};
		$(".btn").click(function () {
			push();
		});
		executeQuery();
		$(".btn").click(function () {
			write();
		});
	</script>

</html>