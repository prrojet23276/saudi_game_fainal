<?php
session_start();
require "db.php";

$username = $_SESSION['username'] ?? "";
$email = $_SESSION['email'] ?? "";
$res = mysqli_query($conn, "SELECT total_score, level FROM users WHERE id=".$_SESSION['user_id']);
$user = mysqli_fetch_assoc($res);

$points = $user['total_score'];
$level = min($user['level'] , 20);
/* جلب المدن من قاعدة البيانات */

$cities = mysqli_query($conn,"SELECT * FROM cities");

$solved = [];

$res = mysqli_query($conn, "SELECT city_id FROM user_progress WHERE user_id=".$_SESSION['user_id']);

while($row = mysqli_fetch_assoc($res)){
    $solved[] = $row['city_id'];
}

/* الشخصية المختارة */

$character = $_GET['character'] ?? "boy";
$avatar = ($character == "girl") ? "girl_avatar.png" : "boy_avatar.png";
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>لفه سعوديه</title>

<style>

body{
margin:0;
font-family:'Tajawal', sans-serif;
min-height:100vh;
background:linear-gradient(#f6e3b4,#e4c28a,#d6a96c);
overflow:hidden;

/* الخلفية */
background: url("sos.jpg") no-repeat center center fixed;
background-size:cover;
}
body::before{
content:"";
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
background: rgba(0,0,0,0.15);
z-index:0;
}
/* top bar */
.top-bar{
display:flex;
justify-content:space-between;
align-items:center;
padding:5px 5px;
direction: ltr;
position: fixed;
width: 100%;
z-index: 1000;
}

/* level */
.level-box{
background:linear-gradient(135deg,#b07a45,#8b5a2b);
color:white;
padding:8px 20px;
border-radius:30px;
font-weight:bold;
font-size:14px;
box-shadow:0 6px 15px rgba(0,0,0,0.25);
display:flex;
align-items:center;
margin-left:10px;
gap:6px;
}

.level-box:before{
content:"⭐";
}

/* user */
.user-area{
display:flex;
align-items:center;
gap:10px;
}

.avatar{
width:40px;
height:40px;
border-radius:50%;
object-fit:cover;
border:2px solid #8b5a2b;
}

.username{
font-weight:bold;
font-size:15px;
}

/* buttons */
.profile-btn{
background:#8b5a2b;
color:white;
border:none;
padding:6px 16px;
border-radius:20px;
cursor:pointer;
}

.mute-btn{
background:#8b5a2b;
color:white;
border:none;
padding:5px 10px;
border-radius:50%;
cursor:pointer;
}

/* profile card */
.profile-card{
position:absolute;
top:70px;
right:20px;
background:linear-gradient(145deg,#f6d37a,#d4a437);
padding:20px;
border-radius:15px;
box-shadow:0 12px 35px rgba(0,0,0,0.35);
width:220px;
display:none;
z-index:9999;
}

/* level bar */
.level-bar{
position:absolute;
top:60px;
left:5px;
right: 5px;
height:20px;
background:#e9d2a7;
border-radius:20px;
overflow:hidden;
pointer-events:none;
}

.level-progress{
height:100%;
background:linear-gradient(90deg,#f7d47c,#e0a93b,#c8881f);
position:absolute;
left:0;
top:0;
border-radius:20px;
}

/* numbers */
.level-numbers{
position:absolute;
top:60px;
right:20px;
left:20px;
display:flex;
justify-content:space-between;

font-size:13px;
direction: ltr;
z-index:2;
}

/* map */
.map-container{
position:relative;
display:flex;
justify-content:center;
align-items:center;
overflow:hidden;
padding-top:70px;
}

.saudi-map{
width:850px;
max-width: none;

}

.city{
position:absolute;
background: #8b5a2b; 
color:white;
padding:2px 6px;
font-size: 12px;
border-radius:18px;
cursor:pointer;
}

/* leaderboard button */
.leader-btn{
background:linear-gradient(135deg,#f7d47c,#e0a93b,#c8881f);
border:2px solid #8b5a2b;
border-radius:20px;
padding:6px 12px;
cursor:pointer;
}

/* leaderboard popup */
.leader-popup{
position:absolute;
top:60px;
left:20px;
display:none;
z-index:9999;
}

.leader-box{
background:linear-gradient(145deg,#f6d37a,#d4a437);
padding:15px;
border-radius:15px;
width:220px;
text-align:center;
position: relative;
}

/* avatar popup */
.avatar-popup{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.7);
display:none;
justify-content:center;
align-items:center;
z-index:999;
}

.avatar-popup img{
width:300px;
border-radius:20px;
}

/* question */
.question-popup{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.6);
display:none;
justify-content:center;
align-items:center;
z-index:999999;
}

.question-box{
background:linear-gradient(145deg,#f7d47c,#e0a93b);
padding:35px;
border-radius:20px;
width:420px;
text-align:center;
box-shadow: 0 15px 40px rgba(0, 0, 0,0.4);
color: #5a3b12;
font-weight: bold;
}

.question-box button{
display:block;
width:100%;
margin:10px 0;
padding:12px;
font-size:16px;

background:#8b5a2b;
color:white;

border:none;
border-radius:12px;
cursor:pointer;

transition:0.3s;
}

.question-box button:hover{
background:#a8743d;
transform:scale(1.05);
}

.close-btn{
position:absolute;
top:8px;
right:10px;

background:none;
border:none;

font-size:18px;
font-weight:bold;
color:#5a3b12;

cursor:pointer;
transition:0.3s;
}

.close-btn:hover{
transform:scale(1.3);
color:#000;
}

.logout-btn{
margin-top:15px;
background:#b04a3a;
color:white;
border:none;
padding:8px 18px;
border-radius:20px;
cursor:pointer;
font-size:14px;
transition:0.3s;
}

.logout-btn:hover{
background:#8a372c;
transform:scale(1.05);
}

.end-box{
display:none;
position:fixed;
top:50%;
left:50%;
transform:translate(-50%,-50%);
width: 500px;
max-width: 90%;
background:linear-gradient(145deg,#fff8e7,#f3d8a6);
padding:30px;
border-radius:25px;
text-align:center;
z-index:999;
border:2px solid #8b5a2b;
box-shadow:
0 20px 50px rgba(0,0,0,0.3),
0 0 0 2px rgba(139,90,43,0.3) inset;
animation: glowGold 2s ease-in-out infinite alternate;
}

@keyframes glowGold {
0%{
box-shadow:
0 0 10px #ffd700,
0 0 20px rgba(255,215,0,0.4);
}

100%{
box-shadow:
0 0 30px #fff2a8,
0 0 60px rgba(255,215,0,0.8);
}
}

.end-box button{
background:#8b5a2b;
color:white;
border:none;
padding:10px 20px;
border-radius:15px;
cursor:pointer;
font-size:14px;
transition:0.3s;
margin-top:20px;
}

.end-box button:hover{
background:#a8743d;
transform:scale(1.05);
}

.close-end{
position:absolute;
top:-5px;
right: 10px;
background:none;
border:none;
font-size:18px;
font-weight:bold;
color:#5a3b12;
cursor:pointer;
transition:0.3s;
}

.close-end:hover{
transform:scale(1.3);
color:#000;
}

.confirm-box{
position:fixed;
top:50%;
left:50%;
transform:translate(-50%,-50%);
background:linear-gradient(145deg,#fff8e7,#f3d8a6);
padding:30px;
border-radius:25px;
text-align:center;
z-index:9999;
border:2px solid #8b5a2b;
box-shadow:
0 20px 50px rgba(0,0,0,0.3),
0 0 0 2px rgba(139,90,43,0.3) inset;
}

.confirm-box button{
margin:5px;
padding:10px 20px;
border:none;
border-radius:12px;
background:#8b5a2b;
color:white;
cursor:pointer;
transition:0.3s;
}

.confirm-box button:hover{
background:#a8743d;
transform:scale(1.05);
}

.city.solved{
animation: glowSolved 1.5s infinite alternate;
}

@keyframes glowSolved{
from{ box-shadow:0 0 5px #422305; }
to{ box-shadow:0 0 20px #e0c488; }
}

.restart-btn{
margin-top:10px;
background:#d6a96c;
color:#3a2508;
border:none;
padding:8px 18px;
border-radius:20px;
cursor:pointer;
font-size:14px;
transition:0.3s;
}

.restart-btn:hover{
background:#c28a4a;
transform:scale(1.05);
}

*{
position:relative;
z-index:2;
}
</style>
</head>

<body>
    <iframe src="music.html" id="musicFrame" style="display:none;"></iframe>
<div class="top-bar">

    <!-- يسار -->
    <div style="display:flex; align-items:center; gap:8px;">

        <div class="level-box">
            مستوى <?php echo $level; ?>
        </div>

        <button onclick="openLeaderboard()" class="leader-btn">🏆</button>

        <button onclick="toggleSound()" class="mute-btn">🔊</button>

    </div>

    <!-- يمين -->
    <div class="user-area">
        <img src="<?php echo $avatar; ?>" class="avatar" onclick="openAvatar(this.src)">

        <span class="username">
            <?php echo $username; ?>
        </span>

        <button class="profile-btn" onclick="toggleProfile()">
            الملف الشخصي
        </button>
    </div>

</div>


<div class="profile-card" id="profileCard">

<h3>الملف الشخصي</h3>

<p>اسم المستخدم: <?php echo $username; ?></p>
<p>الإيميل: <?php echo $email; ?></p>
<p>مجموع النقاط: <?php echo $points; ?></p>

<button onclick="logout()" class="logout-btn">
تسجيل الخروج
</button>
<button onclick="restartGame()" class="restart-btn" id="restartBtn">
إعادة اللعب 🔄
</button>
</div>

<div class="level-bar">
<div class="level-progress" style="width:<?php echo ($level / 20)* 100; ?>%"></div>
</div>

<div class="level-numbers">
<span>1</span>
<span>2</span>
<span>3</span>
<span>4</span>
<span>5</span>
<span>6</span>
<span>7</span>
<span>8</span>
<span>9</span>
<span>10</span>
<span>11</span>
<span>12</span>
<span>13</span>
<span>14</span>
<span>15</span>
<span>16</span>
<span>17</span>
<span>18</span>
<span>19</span>
<span>20</span>
</div>

<div class="map-container">

<img src="map.png" class="saudi-map">

<?php while($city = mysqli_fetch_assoc($cities)){ ?>

<?php
    $city_id = $city['city_id'];

    // أول مدينة مفتوحة
    $unlocked = false;

    if($city_id == 1){
        $unlocked = true;
    } else {
        if(in_array($city_id - 1, $solved)){
            $unlocked = true;
        }
    }
?>

<div class="city 
<?php 
echo $unlocked ? '' : 'locked';

if(in_array($city_id, $solved)){
    echo ' solved';
}
?>
"
onclick="<?php echo $unlocked ? 'openQuestion('.$city_id.')' : ''; ?>"
style="left:<?php echo $city['x_position']; ?>px;
top:<?php echo $city['y_position']; ?>px;">

<?php if($unlocked){ ?>

    <?php if(in_array($city_id, $solved)){ ?>
        ✔ <?php echo $city['city_name']; ?>
    <?php } else { ?>
        <?php echo $city['city_name']; ?>
    <?php } ?>

<?php } else { ?>

    🔒 <?php echo $city['city_name']; ?>

<?php } ?>

</div>

<?php } ?>

<script>

function toggleProfile(){
var card = document.getElementById("profileCard");

if(card.style.display === "block"){
card.style.display = "none";
}else{
card.style.display = "block";
}
}

function openAvatar(src){
let popup = document.getElementById("avatarPopup");
let img = document.getElementById("bigAvatar");

img.src = src;
popup.style.display = "flex";
}

function closeAvatar(){
document.getElementById("avatarPopup").style.display = "none";
}
function checkAnswer(num){

if(answered) return;
answered = true;

document.getElementById("questionArea").style.display="none";
document.getElementById("resultArea").style.display="block";

if(num == window.correctAnswer){

fetch("update_score.php?city=" + window.currentCity)
.then(res => res.json())
.then(response => {

// ❌ إذا محلول من قبل
if(response.status === "already solved"){

document.getElementById("resultText").innerHTML="⚠️ حليت السؤال من قبل";

}else if(response.status === "success"){

// ✅ صوت الصح
document.getElementById("correctSound").currentTime = 0;
document.getElementById("correctSound").play();

document.getElementById("resultText").innerHTML="✔ إجابة صحيحة 🎉";
document.querySelector(".level-box").innerText =
        "⭐ مستوى " + response.level;

    document.querySelector(".profile-card p:nth-child(4)").innerText =
        "مجموع النقاط: " + response.total_score;

    document.querySelector(".level-progress").style.width =
        (response.level / 20) * 100 + "%";

setTimeout(()=>{

fetch("check_finish.php")
.then(res => res.json())
.then(data => {

if(data.status === "finished"){

let winSound = document.getElementById("winSound");

winSound.currentTime = 0;
winSound.play();
// 🎆 احتفال مستمر
window.fireworksInterval = setInterval(() => {

    confetti({
        particleCount: 70,
        spread: 90,
        origin: { x: Math.random(), y: Math.random() * 0.3 },
        startVelocity: 40,
        gravity: 0.9,
        ticks: 200
    });

}, 700);

    // يقفل السؤال
    document.getElementById("questionPopup").style.display = "none";

    // يظهر النهاية
    document.querySelector(".end-box").style.display = "block";

    document.getElementById("finalScore").innerText =
        "🏆 نقاطك: " + data.score;

    document.getElementById("stars").innerText = "⭐⭐⭐";

}else{
    location.reload();
}

});

},1000);
}

});

}else{

// ❌ صوت الخطأ
document.getElementById("wrongSound").currentTime = 0;
document.getElementById("wrongSound").play();

document.getElementById("resultText").innerHTML="❌ إجابة خاطئة";

}

}
function openQuestion(cityId){
answered = false;
window.currentCity = cityId;

fetch("get_question.php?city="+cityId)

.then(res=>res.json())

.then(data=>{

document.getElementById("questionText").innerText = data.question;
document.getElementById("opt1").innerText = data.option1;
document.getElementById("opt2").innerText = data.option2;
document.getElementById("opt3").innerText = data.option3;

document.getElementById("questionArea").style.display="block";
document.getElementById("resultArea").style.display="none";

document.getElementById("questionPopup").style.display="flex";

window.correctAnswer = data.correct;

});
}
function closeQuestion(e){

if(e.target.id === "questionPopup"){

document.getElementById("questionPopup").style.display="none";

}

}

function backToQuestion(){

answered = false; 

document.getElementById("resultArea").style.display="none";
document.getElementById("questionArea").style.display="block";

}

function logout(){

let sound = document.getElementById("exitSound");

if(sound){
sound.currentTime = 0;

sound.play().then(()=>{

setTimeout(()=>{
window.location.href="logout.php";
},500);

}).catch(()=>{

window.location.href="logout.php";

});
}else{

window.location.href="logout.php";

}

}

window.onload = function(){

let btn = document.querySelector(".mute-btn");

// 📥 نجيب حالة الكتم
let isMuted = localStorage.getItem("muted");

if(isMuted === "true"){
    btn.innerHTML = "🔇";
}else{
    btn.innerHTML = "🔊";
}

}

function toggleSound(){

let frame = document.getElementById("musicFrame");
let music = frame.contentWindow.document.getElementById("bgMusic");

let btn = document.querySelector(".mute-btn");

if(music.muted){
    music.muted = false;
    btn.innerHTML = "🔊";
    localStorage.setItem("muted", "false");
}else{
    music.muted = true;
    btn.innerHTML = "🔇";
    localStorage.setItem("muted", "true");
}

}

function openLeaderboard(){

document.getElementById("leaderPopup").style.display = "flex";

// نجيب البيانات
fetch("get_leaderboard.php")
.then(res => res.json())
.then(data => {

let content = "";

data.forEach((player, index) => {

content += `<p>${index+1} - ${player.username} (${player.total_score})</p>`;

});

document.getElementById("leaderContent").innerHTML = content;

});

}

function closeLeaderboard(){
document.getElementById("leaderPopup").style.display = "none";
}

function closeEnd(){
    document.querySelector(".end-box").style.display = "none";
    //  يوقف الألعاب النارية
    clearInterval(window.fireworksInterval);
}

function resetGame(){

fetch("reset_game.php")
.then(res => res.text())
.then(response => {

if(response === "done"){
    location.reload();
}

});

}
function confirmReset(){

let confirmAction = confirm(" متأكد تبي تعيد اللعبة؟");

if(confirmAction){
    resetGame();
}

}
function openConfirm(){
    document.getElementById("confirmBox").style.display = "block";
}

function closeConfirm(){
    document.getElementById("confirmBox").style.display = "none";
}


window.addEventListener("load", function(){

fetch("check_finish.php")
.then(res => res.json())
.then(data => {

let btn = document.getElementById("restartBtn");

if(data.status !== "finished"){

// 🔓 فتح زر إعادة اللعب مباشرة
let btn = document.getElementById("restartBtn");

btn.style.opacity = "1";
btn.style.cursor = "pointer";
btn.innerHTML = "🔄 إعادة اللعب";
btn.dataset.locked = "false";

/* شكله مقفل بس يشتغل */
btn.style.opacity = "0.5";
btn.style.cursor = "not-allowed";
btn.innerHTML = "🔒 إعادة اللعب";

/* نخزن الحالة */
btn.dataset.locked = "true";

}else{
btn.dataset.locked = "false";
}

});

});

function restartGame(){

let btn = document.getElementById("restartBtn");

/* إذا مقفل */
if(btn.dataset.locked === "true"){
    alert("❌ لازم تخلص اللعبة أول!");
    return;
}

/* إذا مفتوح */
let confirmAction = confirm("🎮 تبي تعيد اللعبة؟");

if(confirmAction){

fetch("reset_game.php")
.then(res => res.text())
.then(response => {

if(response === "done"){
location.reload();
}

});

}

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

<div class="avatar-popup" id="avatarPopup" onclick="closeAvatar()">
<img id="bigAvatar">
</div>

<div class="question-popup" id="questionPopup" onclick="closeQuestion(event)">

<div class="question-box">

<div id="questionArea">

<h2 id="questionText"></h2>

<button onclick="checkAnswer(1)" id="opt1"></button>
<button onclick="checkAnswer(2)" id="opt2"></button>
<button onclick="checkAnswer(3)" id="opt3"></button>

</div>

<div id="resultArea" style="display:none">

<h2 id="resultText"></h2>

<button onclick="backToQuestion()">العودة للسؤال</button>

</div>

</div>

</div>
<audio id="correctSound" src="correct.mp3"></audio>
<audio id="wrongSound" src="error.mp3"></audio>
<audio id="exitSound" src="exit.mp3"></audio>
<audio id="winSound" src="win.mp3"></audio>

<div class="leader-popup" id="leaderPopup">

<div class="leader-box">
    <button class="close-btn" onclick="closeLeaderboard()">✖</button>

<h2>🏆 المتصدرين</h2>

<div id="leaderContent">
<!-- هنا بتجي البيانات -->
</div>


</div>

</div>

<div class="end-box" style="display: none;">
    <button class="close-end" onclick="closeEnd()">✖</button>

  <h2> كفو! أنهيت رحلتك في أنحاء المملكة🎉
معلوماتك تدل على وعي وثقافة مميزة 👏
استمر في التعلم… فالمعرفة رحلة لا تنتهي ✨</h2>

  <p id="finalScore"></p>

  <div class="stars" id="stars"></div>

  <button onclick="openConfirm()">إعادة اللعب</button>
  <div class="confirm-box" id="confirmBox" style="display:none;">

  <h2>⚠️</h2>

  <p> متأكد تبغى تعيد اللعبة؟</p>

  <div style="margin-top:20px;">
    <button onclick="resetGame()">نعم</button>
    <button onclick="closeConfirm()">لا</button>
  </div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
</body>
</html>