<?php
session_start();
require "db.php";

if(!isset($_SESSION['user_id'])){
    echo json_encode(["status"=>"no user"]);
    exit();
}

$user_id = intval($_SESSION['user_id']);
$city_id = intval($_GET['city'] ?? 0);

// تحقق إذا محلولة
$check = mysqli_query($conn, "SELECT id FROM user_progress WHERE user_id=$user_id AND city_id=$city_id");

if(mysqli_num_rows($check) > 0){
    echo json_encode(["status"=>"already solved"]);
    exit();
}

// جيب النقاط
$result = mysqli_query($conn, "SELECT total_score FROM users WHERE id=$user_id");
$row = mysqli_fetch_assoc($result);

$current_score = intval($row['total_score']);
$new_score = $current_score + 10;

// ✅ أول شيء أضف المدينة
mysqli_query($conn, "INSERT INTO user_progress (user_id, city_id) VALUES ($user_id, $city_id)");

// ✅ بعدها احسب عدد المدن
$count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM user_progress WHERE user_id=$user_id");
$count_data = mysqli_fetch_assoc($count_res);

$new_level = $count_data['total'];

// تحديث البيانات
mysqli_query($conn, "UPDATE users SET total_score=$new_score, level=$new_level WHERE id=$user_id");

// رجّع النتيجة
echo json_encode([
    "status" => "success",
    "total_score" => $new_score,
    "level" => $new_level
]);
