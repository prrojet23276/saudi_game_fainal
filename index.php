<?php
session_start();
require "db.php";

$login_error = "";
$register_error = "";
$success = "";
$active = "home";

/* تسجيل الدخول */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {

    $active = "login";

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {

        if ($password == $row['password']) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];

            header("Location: index.php");
            exit();

        } else {
            $login_error = "كلمة المرور غير صحيحة";
        }

    } else {
        $login_error = "البريد الإلكتروني غير موجود";
    }
}

/* تسجيل جديد */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {

    $active = "register";

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $check_username = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    if(mysqli_num_rows($check_email) > 0){
        $register_error = "البريد الإلكتروني مستخدم مسبقًا";
    } elseif(mysqli_num_rows($check_username) > 0){
        $register_error = "اسم المستخدم مستخدم بالفعل";
    } else {
        $sql = "INSERT INTO users (username,email,password,total_score,level)
                VALUES ('$username','$email','$password',0,1)";
        mysqli_query($conn, $sql);

       $success= "تم انشاء الحساب بنجاح";
    }
}

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>لفه سعودية</title>


<style>
/* ===== خلفية اللعبة ===== */
body{
margin:0;
font-family:'Tajawal', sans-serif;

background: url("b.jpeg") no-repeat center center;
background-size: cover;

display:flex;
justify-content:center;
align-items:center;
min-height:100vh;
overflow:hidden;
}

/* ===== تغميق ===== */
body::after{
content:"";
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background: rgba(0,0,0,0.25);
pointer-events:none;
z-index:1;
}

/* ===== الكارد ===== */
.card{
display:none;
background: linear-gradient(145deg,#ffe7a3,#e0a93b);
border-radius:25px;
padding:30px;
width:360px; /* صغرناه */
max-width:90%;
text-align:center;
box-shadow:
0 10px 0 #8c5a00,
0 25px 50px rgba(0,0,0,0.6);
position:relative;
z-index:10;
animation: floatBox 3s ease-in-out infinite;
align-items:center;
}
.card form{
    width:100%;
    display:flex;
    flex-direction:column;
    align-items:center;
}

/* حركة */
@keyframes floatBox{
0%{transform:translateY(0);}
50%{transform:translateY(-12px);}
100%{transform:translateY(0);}
}

/* ===== النص ===== */
h1{
color:#3a2508;
font-size:clamp(20px,2vw,28px);
}

p{
color:#5a3b12;
font-size:clamp(12px,1.2vw,15px);
}

/* ===== الحقول ===== */
input{
width:100%;
padding:12px;
margin:8px 0;
background:#fff8e1;
border:none;
border-radius:15px;
font-size:14px;
}
input:focus{
outline:none;
box-shadow:0 0 10px rgba(255,160,0,0.5);
}

/* ===== الأزرار ===== */
button{
width:100%;
padding:clamp(12px,2vw,16px);
margin:10px 0;

background: linear-gradient(180deg,#ffda75,#ff9f1c);
color:#3a2a10;

border:none;
border-radius:25px;

font-size:clamp(14px,1.5vw,17px);
font-weight:bold;

cursor:pointer;

box-shadow:
0 8px 0 #a85d00,
0 15px 25px rgba(0,0,0,0.5);

transition:0.15s;
}

button:hover{
transform:translateY(-3px);
}

button:active{
transform:translateY(4px);
}

/* ===== الشخصيات ===== */
.characters{
position:fixed;
bottom:0;
left:clamp(20px,6vw,120px);
z-index:2;
pointer-events:none;
}

.char{
height:clamp(300px, 50vh, 500px);

filter:
drop-shadow(0 20px 30px rgba(0,0,0,0.5))
brightness(0.95)
contrast(0.95)
saturate(0.9);

opacity:0.95;
}

.boy{
margin-right:-120px;
}

/* ===== شاشة التحميل ===== */
#loadingScreen{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;

background: url("backx.jpg") no-repeat center center;
background-size: cover;

display:flex;
flex-direction:column;
justify-content:center;
align-items:center;

z-index:9999;
}

#loadingScreen::before{
content:"";
position:absolute;
width:100%;
height:100%;
background: rgba(0,0,0,0.45);
z-index:0;
}

/* اللوقو */
.game-logo{
width:clamp(200px, 30vw, 420px);
margin-bottom:30px;

position:relative;
z-index:1;

animation:logoFloat 3s ease-in-out infinite;
}

@keyframes logoFloat{
0%{transform:translateY(0);}
50%{transform:translateY(-10px);}
100%{transform:translateY(0);}
}

/* شريط التحميل */
.progress{
width:clamp(200px, 25vw, 320px);
height:18px;

background:rgba(255,255,255,0.3);
border-radius:20px;
overflow:hidden;

position:relative;
z-index:1;
}

.bar{
height:100%;
width:0%;
background: linear-gradient(90deg,#ffd166,#fca311);
animation:load 6s forwards;
}

@keyframes load{
from{width:0%;}
to{width:100%;}
}

/* النص */
#loadingScreen p{
color:#fff;
font-size:clamp(14px,1.5vw,18px);
font-weight:bold;
margin-top:15px;

text-shadow:0 2px 10px rgba(0,0,0,0.8);
z-index:1;
}

.hidden{
display:none;
}
</style>

</head>

<body>
<audio id="mos2" loop>
  <source src="mos2.mp3" type="audio/mpeg">
</audio>
<div id="loadingScreen">

    <img src="loggo.png" class="game-logo">

    <div class="progress">
        <div class="bar"></div>
    </div>

    <p>جاري تحميل اللعبة...</p>

</div>
<div class="card">

<?php if(isset($_SESSION['user_id'])): ?>

    <div id="home">
        <h1>يامرحبا<?php echo $_SESSION['username']; ?></h1>
        <p>جاهز تبدأ المغامرة؟</p>

        <a href="character.php">
            <button class="primary">ابدأ اللعب</button>
        </a>

    </div>

<?php else: ?>

    <div id="home" class="<?php echo ($active=="home")?'':'hidden'; ?>">
      <h1>حياك الله في لعبتنا لَفه سعوديه</h1>
      <p>سجل دخولك عشان تكمل معنا</p>

      <button class="primary" onclick="showSection('login')">تسجيل دخول</button>
      <button class="btn primary" onclick="showSection('register')">تسجيل جديد</button>
      <button class="btn primary" onclick="showSection('about')">تعريف اللعبة</button>
    </div>

    <!-- تسجيل الدخول -->
    <div id="login" class="<?php echo ($active=="login")?'':'hidden'; ?>">
      <h1>تسجيل الدخول</h1>

      <?php if(!empty($login_error)) echo "<p style='color:#ff8888;'>$login_error</p>"; ?>
      <?php if(!empty($success)) echo "<p style='color:lightgreen;'>$success</p>"; ?>

      <form method="POST">
        <input type="email" name="email" placeholder="البريد الإلكتروني" required>
        <input type="password" name="password" placeholder="كلمة المرور" required>
        <button class="primary" name="login">دخول</button>
      </form>

      <div onclick="showSection('home')">⬅ العودة</div>
    </div>

    <!-- تسجيل جديد -->
    <div id="register" class="<?php echo ($active=="register")?'':'hidden'; ?>">
      <h1>إنشاء حساب</h1>

      <?php if(!empty($register_error)) echo "<p style='color:#ff8888;'>$register_error</p>"; ?>
      <?php if(!empty($success)) echo "<p style='color:lightgreen;'>$success</p>"; ?>

      <form method="POST">
        <input type="text" name="username" placeholder="اسم المستخدم" required>
        <input type="email" name="email" placeholder="البريد الإلكتروني" required>
        <input type="password" name="password" placeholder="كلمة المرور" required>
        <button class="primary" name="register">تسجيل</button>
      </form>

      <div onclick="showSection('home')">⬅ العودة</div>
    </div>

    <!-- تعريف -->
    <div id="about" class="hidden">
      <h1>طريقه اللعب📜</h1>
      <p>
      شد الرحال وابدأ رحلتك في لَفه سعودية 😎
      استكشف مدن المملكة وجاوب على الاسئله بكل حماس 
      أثبت معرفتك وجاوب صح عشان تجمع النقاط🔥
      كل مرحلة تقرّبك للقمة… فهل أنت قدّها؟ 😏
      اجمع أعلى النقاط وخل اسمك يتصدر 🏆
      </p>
      <button class="primary" onclick="showSection('home')">ابدأ الآن🎮</button>
      <div onclick="showSection('home')">⬅ العودة</div>
    </div>

<?php endif; ?>

</div>

<script>
function showSection(section){
  const sections = document.querySelectorAll('#home, #login, #register, #about');
  sections.forEach(sec => sec.classList.add('hidden'));
  document.getElementById(section).classList.remove('hidden');
}

document.addEventListener("click", function(){

let frame = document.getElementById("musicFrame");
let music = frame.contentWindow.document.getElementById("bgMusic");

music.play();

}, { once: true });
</script>

<script>
window.addEventListener("load", function(){

setTimeout(function(){
    document.getElementById("loadingScreen").style.display = "none";
    document.querySelector(".card").style.display = "block";
}, 6000);

});

document.addEventListener("click", function(){

let frame = document.getElementById("musicFrame");

if(frame && frame.contentWindow){

let music = frame.contentWindow.document.getElementById("mos2");

if(music){
    music.play().catch(()=>{});
}

}

}, { once:true });
</script>
<script>
let music = document.getElementById("mos2");

// رجع الوقت
let savedTime = localStorage.getItem("musicTime");
if(savedTime){
    music.currentTime = savedTime;
}

// رجع الكتم
let isMuted = localStorage.getItem("muted");
if(isMuted === "true"){
    music.muted = true;
}

//  أ (تشغيل مرة وحدة فقط)
if(localStorage.getItem("musicStarted") === "true"){
    music.play().catch(()=>{});
}else{
    document.addEventListener("click", function(){
        music.play().then(()=>{
            localStorage.setItem("musicStarted","true");
        }).catch(()=>{});
    }, { once:true });
}

// حفظ الوقت
setInterval(()=>{
    localStorage.setItem("musicTime", music.currentTime);
},1000);
</script>
<div class="characters">
    <img src="girl.png" class="char">
    <img src="boy.png" class="char boy">
</div>
</body>
</html>
