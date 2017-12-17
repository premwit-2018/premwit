<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    
<style>
    body{
        font-family: 'Kanit', sans-serif;
    }
    .cover{
        height: auto;
        padding: 36px;
        background-color: #263238;
    }
    .logo{
        background-image: url('img/logo.png');
        width: 300px;
        height: 300px;
        background-size: cover;
        background-repeat: no-repeat;
        margin: auto;
    }
    #blacktxt{
        color: black;
    }
    .countdown{
        color: black;
        padding: 20px;
    }

    .timer{
        display: flex;
        justify-content: center;
        align-items: center;        
        vertical-align: middle;
        margin: auto;
        width: 100px;
        height: 100px;
        border-radius: 20px;
        background-color: #e0e0e0;
        color: black;
        font-size: 2em;
        margin-top: 20px;
    }
    #clock{
        padding-top: 20px;
    }
    .row{
        
    }
    .schedule{
        padding: 40px;
        background-color: #263238;
    }
    .button{
        padding-top: 10px;
        padding-bottom: 10px;
        height: auto;
        width: 200px;
        color: white;
        border: 4px white solid;
        border-radius: 10px;
    }
    @media(min-width: 600px){
        #top{
            margin-bottom: 20px;
        }
    }
    @media(max-width: 600px){
        #top{
            margin-bottom: 40px;
        }
    }    
</style>

</head>

<body>
    <nav>
        <div class="nav-wrapper blue-grey darken-4" style="padding-left: 20px;">
            <a href="#" class="brand-logo">Pre MWITS</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="sass.html">ลงทะเบียน</a></li>
                <li><a href="badges.html">Components</a></li>
                <li><a href="collapsible.html">JavaScript</a></li>
            </ul>
        </div>
    </nav>    
        <section class="cover">
            <div class="logo"></div>
            <h4 id="blacktxt" style="text-align: center; color: white;">7-9 มกราคม 2561</h4>
        </section>
        <section class="countdown white" style="text-align: center;">
            <h4 id="blacktxt">Count Down to Pre MWITS 2018</h4>
            <div class="row" id="clock" style="max-width: 600px;">            
            </div>            
        </section>
        <section class="schedule">
            <div class="row" style="padding-top: 40px; max-width: 600px;">
                <div class="col s12 m6">
                    <div align="center">
                        <a id="top" class="button waves-effect waves-light btn-flat"><h5>กำหนดการ</h5></a>
                    </div>
                </div> 
                <div class="col s12 m6">
                    <div align="center">
                        <a class="button waves-effect waves-light btn-flat"><h5>ลงทะเบียน</h5></a>
                    </div>
                </div> 
                
            </div>
        </section>
        <section class="require" style="display:none;">
- ชุดนอนสำหรับ 1 คืน <br>
- ผ้าเช็ดตัว <br>
- ของใช้ส่วนตัว เช่น สบู่ ยาสีฟัน แปรงสีฟัน <br>
- ชุดนักเรียนสำหรับวันแรก<br>
- ชุดพละสำหรับวันที่สอง<br>
- รองเท้าพละสำหรับทั้งสองวัน<br>
- สมุด เครื่องเขียน<br>
- เงินค่าอาหาร (เฉลี่ยข้าวจานละ 30 บาท)<br>
- สายชาร์จโทรศัพท์<br>
- หมอนและผ้าห่ม (ถ้าหากน้องคนใดที่ไม่สะดวกนำมา สามารถแจ้งพี่ๆได้ผ่านทางเพจ facebook) <br>  
- หัวใจเต็มร้อย!
        </section>

</body>

<script type="text/javascript">
    $('#clock').countdown('2018/1/7', function(event) {
    $(this).html(
      event.strftime('<div class="col s12 m3"><div class="timer">%D</div>วัน</div><div class="col s12 m3"><div class="timer">%H</div>ชั่วโมง</div><div class="col s12 m3"><div class="timer">%M</div>นาที</div><div class="col s12 m3"><div class="timer">%S</div>วินาที</div>')
    );
  });
</script>
</html>