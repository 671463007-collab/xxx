<?php
session_start();
include "../connectDB.php";

// 1. เพิ่ม isset เช็คว่ามีการกดส่งข้อมูลมาจริงๆ ไหม (ป้องกัน Error หน้าขาว)
if (isset($_REQUEST['user_name'])) {

    // เปลี่ยนเป็น $_REQUEST ตามต้องการ
    $user_name = trim($_REQUEST['user_name']);
    $fullname  = trim($_REQUEST['fullname']);    
    $email     = trim($_REQUEST['email']);
    $password  = $_REQUEST['password'];
    $confirm   = $_REQUEST['confirm_password'];

    // ตรวจสอบค่าว่าง
    if($user_name != "" && $fullname != "" && $email != "" && $password != "" && $confirm != ""){

        // ตรวจสอบรหัสผ่านตรงกันไหม
        if ($password != $confirm) {
            echo "<script>
                alert('รหัสผ่านไม่ตรงกัน');
                history.back();
            </script>";
            exit;
        }

        // ตรวจสอบอีเมลซ้ำ
        $check_sql = "SELECT user_id FROM users WHERE email = '$email'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            echo "<script>
                alert('อีเมลนี้ถูกใช้งานแล้ว');
                history.back();
            </script>";
            exit;
        }

        // ตรวจสอบ Username ซ้ำ
        $check_sql = "SELECT username FROM users WHERE username = '$user_name'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            echo "<script>
                alert('Username นี้ถูกใช้งานแล้ว');
                history.back();
            </script>";
            exit;
        }

        // เข้ารหัสรหัสผ่าน
        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        // =======================================================
        // 2. กำหนดรูปภาพเริ่มต้น และ Role เริ่มต้น
        // =======================================================
        // รูป default (เพื่อให้ Navbar มีรูปโชว์ทันทีที่ล็อกอิน)
        $default_image = "fish_img/profile/avatar-1.jpg"; 
        $default_role  = "member"; // หรือ 'user' แล้วแต่ฐานข้อมูลคุณ

        // บันทึกลงฐานข้อมูล (เพิ่ม column image และ role)
        $insert_sql = "
            INSERT INTO users (username, name, email, pass, image, role)
            VALUES ('$user_name', '$fullname', '$email', '$hash_password', '$default_image', '$default_role')
        ";

        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>
                alert('สมัครสมาชิกเรียบร้อยแล้ว');
                window.location='login.php'; 
            </script>";
        } else {
            echo "<script>
                alert('เกิดข้อผิดพลาด: {$conn->error}');
                history.back();
            </script>";
        }
    } else {
        echo "<script>
            alert('กรุณากรอกข้อมูลให้ครบทุกช่อง');
            history.back();
        </script>";
    }
}
?>