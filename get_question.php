<?php
session_start();
require "db.php";

$city = $_GET['city'];

//  نجيب السؤال دايم
$q = mysqli_query($conn,"SELECT * FROM questions WHERE city_id='$city' LIMIT 1");

if(mysqli_num_rows($q) > 0){

    $row = mysqli_fetch_assoc($q);

    echo json_encode([
        "question"=>$row['question_text'],
        "option1"=>$row['option1'],
        "option2"=>$row['option2'],
        "option3"=>$row['option3'],
        "correct"=>$row['correct_answer']
    ]);

}else{

    echo json_encode([
        "status"=>"error"
    ]);
}