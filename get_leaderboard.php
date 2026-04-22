<?php
require "db.php";

$result = mysqli_query($conn, "
SELECT username, total_score 
FROM users 
ORDER BY total_score DESC 
LIMIT 10
");

$data = [];

while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}

echo json_encode($data);
?>
