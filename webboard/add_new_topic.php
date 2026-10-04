<?php
include "../connectDB.php"; 


if(isset($_POST['topic'])) {
    $topic = trim($_POST['topic']);
    $detail = trim($_POST['detail']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $created = date('Y-m-d H:i:s');
    $view = 0;
    $reply = 0;
    $sql = "INSERT INTO questions (topic, detail, name, email, created, view, reply) 
            VALUES ('$topic', '$detail', '$name', '$email', '$created', '$view', '$reply')";

    if ($conn->query($sql) === TRUE) {
        echo "บันทึกกระทู้สำเร็จ!<BR>";
        echo "<a href='main_webboard.php'>กลับหน้าหลัก</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>