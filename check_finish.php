<?php
session_start();
require "db.php";

$user_id = $_SESSION['user_id'];

// عدد المدن
$total = mysqli_query($conn, "SELECT COUNT(*) as count FROM cities");
$totalCities = mysqli_fetch_assoc($total)['count'];

// عدد المحلولة
$done = mysqli_query($conn, "SELECT COUNT(*) as count FROM user_progress WHERE user_id=$user_id");
$doneCities = mysqli_fetch_assoc($done)['count'];

if($doneCities >= $totalCities){

    $res = mysqli_query($conn, "SELECT total_score FROM users WHERE id=$user_id");
    $user = mysqli_fetch_assoc($res);

    echo json_encode([
        "status"=>"finished",
        "score"=>$user['total_score']
    ]);

}else{
    echo json_encode([
        "status"=>"not_finished"
    ]);
}