
<?php
$servername = 'localhost';  
$username = 'root'; 
$password = ''; 
$dbname = 'myfirstdb';


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('فشل الاتصال:' . $conn->connect_error);
} 
echo "تم الاتصال بقاعدة البيانات بنجاح!";

?>


