<?php
session_start();
include "../connectDB.php";

header('Content-Type: application/json');

if (isset($_POST['detail'])) {
    $detail = $_POST['detail'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $question_id = $_POST['id'];

    $detail = mysqli_real_escape_string($conn, $detail);
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "INSERT INTO answers (detail, name, email, question_id) 
            VALUES ('$detail', '$name', '$email', '$question_id')";
            
    $sql_update_count = "UPDATE questions SET reply = reply + 1 WHERE id = '$question_id'";
    $conn->query($sql_update_count);

    if ($conn->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'บันทึกข้อมูลเรียบร้อย']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ไม่มีข้อมูลส่งมา']);
}

$conn->close();
