<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
<meta charset="UTF-8">
<title>اختيار الشخصية</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600;800&display=swap" rel="stylesheet">
<style>

/* == الخلفية== */
body{
margin:0;
font-family:"Cairo",sans-serif;
height:100vh;
overflow:hidden;
text-align:center;
background: url("b2.jpeg") no-repeat center center fixed;
background-size: cover;
position:relative;
}
html, body{
margin:0;
padding:0;
width:100%;
height:100%;
overflow:hidden;
}
/* تغميق خفيف */
body::before{
content:"";
position:absolute;
top:0;
left:0;
width:100%;
height:100%;

background: rgba(0,0,0,0.25);
z-index:0;
}

/* ===== الترحيب ===== */
.welcome,
h1{
font-weight:900;
color:#ffe08a;

/* حدود وهمية */
text-shadow:
1px 1px 0 #3a2508,
-1px 1px 0 #3a2508,
1px -1px 0 #3a2508,
-1px -1px 0 #3a2508,
0 3px 0 #8c5a00,
0 6px 10px rgba(0,0,0,0.7);
}
/* ===== العنوان ===== */
h1{
margin-top:5px;
font-size:34px;
font-weight:900;
color:#ffe08a;
text-shadow:
1px 1px 0 #3a2508,
-1 1px 0 #3a2508,
1px -1px 0 #3a2508,
-1px -1px 0 #3a2508,
0 3px 0 #8c5a00,
0 6px 10px rgba(0,0,0,0.7),
}
/* ===== الشخصيات ===== */
.characters{
display:flex;
justify-content:center;
gap:150px; /* ضبط المسافة */
margin-top:70px;
position:relative;
z-index:2;
}

/* ===== الكارد ===== */
.character-card{
cursor:pointer;
display:flex;
flex-direction:column;
align-items:center;
transition:0.3s;
}

.character-card:hover{
transform:scale(1.08);
}

/* ===== الإطار ===== */
.frame{
width:200px;
height:200px;
padding:12px;
border-radius:25px;
background:linear-gradient(145deg,#f7d47c,#e0a93b);
box-shadow:
0 10px 0 #8c5a00,
0 20px 40px rgba(0,0,0,0.5);
display:flex;
justify-content:center;
align-items:center;
}

/* ===== الصور (الشخصيات) ===== */
.frame img{
width:103%;
height:auto;
object-fit:contain;
transform: translateY(1px);

filter:
drop-shadow(0 10px 20px rgba(0,0,0,0.4))
contrast(1.05)
saturate(1.05);
}

.girl-img{
width:112% !important;
height:auto;
transform: translateY(15px) !important;
}

/* ===== الاسم ===== */
.character-card p{
margin-top:12px;
font-size:20px;
font-weight:bold;
color:#fff;
text-shadow:0 3px 10px rgba(0,0,0,0.6);
}

/* ===== زر الاسم ===== */
.name-btn{
margin-top:18px;
padding:8px 20px;
font-size:20px;
font-weight:bold;
border:none;
border-radius:20px;
background:linear-gradient(180deg,#ffda75,#ff9f1c);
color:#3a2a10;
cursor:pointer;
transition:0.2s;
box-shadow:
0 6px 0 #a85d00,
0 10px 20px rgba(0,0,0,0.4);
}
/* Hover */
.name-btn:hover{
transform:translateY(-3px);
}
/* Click */
.name-btn:active{
transform:translateY(3px);
box-shadow:
0 2px 0 #a85d00,
0 5px 10px rgba(0,0,0,0.3);
}
/* ===== التحديد ===== */
.character-card.active .frame{
box-shadow:
0 0 25px #ffd166,
0 10px 0 #8c5a00,
0 20px 40px rgba(0,0,0,0.6);
transform:scale(1.1);
}

/* ===== الغبار ===== */
.dust{
position:absolute;
width:80px;
height:30px;
background:rgba(255,255,255,0.4);
border-radius:50%;
bottom:80px;
opacity:0;
}

.dust.active{
animation:dustAnim 0.6s;
}

@keyframes dustAnim{
0%{opacity:0; transform:scale(0.5);}
50%{opacity:1; transform:scale(1);}
100%{opacity:0; transform:scale(1.5);}
}

</style>
</head>
<body>
<iframe src="music.html" id="musicFrame" style="display:none;"></iframe>
<div class="welcome">
ياهلا فيك <?php echo $_SESSION['username']; ?> 👋
</div>

<h1>اختر شخصيتك</h1>

<div class="characters">

<div class="character-card" onclick="selectCharacter(this,'girl')">

<div class="frame">
<img src="girl22.png" class="girl-img">
</div>

<button class="name-btn">نوير</button>

</div>

<div class="character-card" onclick="selectCharacter(this,'boy')">

<div class="frame">
<img src="boy2.png">
</div>

<button class="name-btn">سلطان</button>
</div>

</div>

<div class="dust" id="dust"></div>

<script>
function selectCharacter(card,type){

// تشغيل الصوت
let sound = document.getElementById("selectSound");
sound.currentTime = 0;
sound.play();

// التأثير م
document.querySelectorAll('.character-card').forEach(c=>{
c.classList.remove("active")
})

card.classList.add("active")

// تأخير بسيط عشان الصوت
setTimeout(()=>{
window.location.href="game.php?character="+type
},500)

}
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
<audio id="selectSound" src="cus.mp3"></audio>
</body>
</html>