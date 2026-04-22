<?php
session_start();
require "db.php";

if(!isset($_SESSION['user_id'])){
    echo "no user";
    exit();
}

$user_id = $_SESSION['user_id'];

/* تصفير النقاط واللفل */
mysqli_query($conn, "
UPDATE users 
SET total_score = 0, level = 0 
WHERE id = $user_id
");

/* حذف التقدم */
mysqli_query($conn, "
DELETE FROM user_progress 
WHERE user_id = $user_id
");

echo "done";
?>