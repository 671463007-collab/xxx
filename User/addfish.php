<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php"); 
    exit();
}
include "../connectDB.php"; 
if (isset($_POST['save_fish'])) {
    $namefish = $_POST['namefish'];
    $category = $_POST['category']; 
    $description = $_POST['description'];
    $care_detail = $_POST['care_detail'];
    //ใครเป็นคนโพส
    $user_id = $_SESSION['user_id'] ?? 0;
    
    $status = (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') ? 'approved' : 'pending';
    $image_path_db = ""; 

    if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
        $ext = pathinfo(basename($_FILES['image']['name']), PATHINFO_EXTENSION);
        $new_image_name = 'fish_' . uniqid() . "." . $ext;
        $upload_path_real = "../fish_img/" . $new_image_name;
        $image_path_db = "fish_img/" . $new_image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path_real)) {
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ');</script>";
        }
    }
    $sql = "INSERT INTO fishs(namefish, category, description, care_detail, image, status, created_at, user_id) 
            VALUES('$namefish','$category','$description','$care_detail','$image_path_db','$status', NOW(), '$user_id')";
    
    $result = mysqli_query($conn, $sql);
    if($result){
        echo "<script>
                alert('บันทึกข้อมูลเรียบร้อย'); 
                window.location='index.php';
              </script>";
    } else {
        echo "<script>alert('ไม่สามารถเพิ่มข้อมูลได้: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>AquaWorld - เพิ่มข้อมูลปลา</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap');
        
        :root {
            --deep-sea: #022E51;   /* น้ำเงินเข้ม */
            --clownfish: #CC6D3D;  /* ส้มปลาการ์ตูน */
            --dark-orange: #B74803; /* ส้มอิฐ */
            --sea-mist: #A3B4C8;   /* ฟ้าหม่น */
            --light-bg: #F0F4F8;   /* พื้นหลัง */
        }

        body {
            font-family: 'Sarabun', sans-serif;
            background-color: var(--light-bg) !important;
        }
        .card-header.bg-primary {
            background-color: var(--deep-sea) !important;
            color: #fff !important;
        }        .btn-primary {
            background-color: var(--clownfish) !important;
            border-color: var(--clownfish) !important;
        }
        .btn-primary:hover {
            background-color: var(--dark-orange) !important;
            border-color: var(--dark-orange) !important;
        }
        .btn-outline-secondary {
            color: var(--deep-sea) !important;
            border-color: var(--sea-mist) !important;
            background-color: #fff !important;
        }
        .btn-outline-secondary:hover {
            background-color: var(--sea-mist) !important;
            color: var(--deep-sea) !important;
        }
        .card {
            box-shadow: 0 4px 15px rgba(2, 46, 81, 0.1) !important;
        }
    </style>
</head>

<body class="bg-light">

    <header>
        <?php include "navUser.php"; ?>
    </header>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0 fw-bold">เพิ่มข้อมูลปลาสวยงาม</h4>
                    </div>
                    <div class="card-body p-4">

                        <form method="POST" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label class="form-label fw-bold">ชื่อปลา</label>
                                <input type="text" name="namefish" class="form-control" placeholder="ระบุชื่อปลา" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">ประเภทปลา</label>
                                <select name="category" class="form-select" required>
                                    <option value="" selected disabled>-- กรุณาเลือกประเภท --</option>
                                    <option value="1">ปลาน้ำจืด</option>
                                    <option value="2">ปลาน้ำเค็ม</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">รายละเอียด / ลักษณะปลา</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="อธิบายลักษณะทั่วไปของปลา" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">วิธีการเลี้ยงดู</label>
                                <textarea name="care_detail" class="form-control" rows="3" placeholder="อาหาร, อุณหภูมิ, การเปลี่ยนน้ำ, ขนาดตู้" required></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">รูปภาพประกอบ</label>
                                <input type="file" name="image" class="form-control" accept="image/*" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="save_fish" class="btn btn-primary btn-lg">
                                    บันทึกข้อมูล
                                </button>
                                <a href="index.php" class="btn btn-outline-secondary">ยกเลิก</a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>