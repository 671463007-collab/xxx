<?php
session_start();
include "../connectDB.php"; 

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php"); 
    exit();
}

// --- ส่วนที่แก้ไข: ดึงข้อมูลจากตาราง users ---
$user_id = $_SESSION['user_id'];

// ** แก้ชื่อตารางเป็น users และใช้ user_id **
$sql_user = "SELECT * FROM users WHERE user_id = '$user_id'"; 

$result_user = $conn->query($sql_user);

// กันเหนียว: ถ้าหาไม่เจอให้เป็นค่าว่าง (ป้องกัน Error)
if ($result_user && $result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $user_name = $row_user['name']; 
    $user_email = $row_user['email'];
} else {
    $user_name = "";
    $user_email = "";
}
// ------------------------------------------
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ตั้งกระทู้ใหม่</title>
    
    <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <?php include "../User/navUser.php"; ?>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap');
        
        :root {
            --deep-sea: #022E51;   
            --clownfish: #CC6D3D;  
            --dark-orange: #B74803;
            --sea-mist: #A3B4C8;   
            --light-bg: #F0F4F8;   
        }

        body {
            font-family: 'Sarabun', sans-serif;
            background-color: var(--light-bg) !important;
        }
        .card-header.bg-primary {
            background-color: var(--deep-sea) !important;
            color: #fff !important;
        }
        .btn-success {
            background-color: var(--clownfish) !important;
            border-color: var(--clownfish) !important;
            color: #fff !important;
        }
        .btn-success:hover {
            background-color: var(--dark-orange) !important;
            border-color: var(--dark-orange) !important;
        }
        .btn-secondary {
            background-color: #fff !important;
            color: var(--deep-sea) !important;
            border-color: var(--sea-mist) !important;
        }
        .btn-secondary:hover {
            background-color: var(--sea-mist) !important;
        }
        .card {
            box-shadow: 0 4px 15px rgba(2, 46, 81, 0.1) !important;
        }
        .input-group-text {
            background-color: var(--deep-sea) !important;
            color: #fff !important;
            border-color: var(--deep-sea) !important;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="mb-3">
            <button type="button" class="btn btn-secondary" onclick="window.history.back();">
                ย้อนกลับ
            </button>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0">ตั้งกระทู้ใหม่</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <form id="new_topic" name="new_topic" method="post" action="add_new_topic.php">
                            
                            <div class="mb-3">
                                <label for="topic" class="form-label fw-bold">หัวข้อกระทู้</label>
                                <input type="text" name="topic" id="topic" class="form-control form-control-lg" placeholder="ใส่หัวข้อเรื่องที่ต้องการถาม..." required>
                            </div>

                            <div class="mb-3">
                                <label for="detail" class="form-label fw-bold">รายละเอียด</label>
                                <textarea name="detail" id="detail" rows="6" class="form-control" placeholder="อธิบายรายละเอียดเพิ่มเติม..." required></textarea>
                            </div>

                            <hr class="my-4">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold">ชื่อผู้ตั้งกระทู้</label>
                                    <div class="input-group">
                                        <span class="input-group-text">ชื่อ</span>
                                        <input type="text" name="name" id="name" class="form-control bg-light" value="<?php echo $user_name; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold">อีเมล</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Email</span>
                                        <input type="email" name="email" id="email" class="form-control bg-light" value="<?php echo $user_email; ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="reset" class="btn btn-secondary">
                                    ล้างข้อมูล
                                </button>
                                <button type="submit" name="Submit" class="btn btn-success px-4">
                                    บันทึกข้อมูล
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#new_topic").submit(function(e) {
                e.preventDefault(); 

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(), 
                    success: function(response) {
                        if (response.indexOf("Error") === -1) {
                            alert("บันทึกกระทู้สำเร็จ!");
                            window.location.href = "main_webboard.php";
                        } else {
                            alert("เกิดข้อผิดพลาด: " + response); 
                        }
                    },
                    error: function() {
                        alert("ติดต่อเซิฟเวอร์ไม่ได้");
                    }
                });
            });
        });
    </script>
</body>

</html>