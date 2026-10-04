<?php
session_start();
include "../connectDB.php"; 
if (empty($_SESSION['user_id'])) { 
    echo "<script>window.location='../login/login.php';</script>"; exit;
}

$user_id = $_SESSION['user_id'];
if (isset($_POST['btn_save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $new_pass = $_POST['new_pass'];
    $confirm1   = $_POST['confirm_password'];
    $image_db = $_POST['old_img'];

    if ($new_pass != "" && $new_pass != $confirm1) {
        echo "<script>
            alert('รหัสผ่านใหม่ไม่ตรงกัน กรุณากรอกใหม่อีกครั้ง');
            history.back();
        </script>";
        exit;
    }

    if (!empty($_FILES['profile_img']['name'])) {
        $ext = pathinfo($_FILES['profile_img']['name'], PATHINFO_EXTENSION);
        $filename = "user_" . $user_id . "_" . time() . "." . $ext; // ตั้งชื่อไฟล์
        
        if (move_uploaded_file($_FILES['profile_img']['tmp_name'], "../fish_img/profile/" . $filename)) {
            
            $old_file = "../" . $_POST['old_img'];
            if ($_POST['old_img'] != "" && file_exists($old_file)) {
                unlink($old_file);
            }

            $image_db = "fish_img/profile/" . $filename;
        }
    }

    $sql = "UPDATE users SET name = '$name', email = '$email', image = '$image_db' ";
    if ($new_pass != "") {
        $hash_pass = password_hash($new_pass, PASSWORD_DEFAULT);
        $sql .= ", pass = '$hash_pass' ";
    }

    $sql .= " WHERE user_id = '$user_id' ";

    if ($conn->query($sql)) {
        $_SESSION['user_name'] = $name;
        echo "<script>alert('บันทึกข้อมูลเรียบร้อย'); window.location='profile.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM users WHERE user_id = '$user_id'");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลส่วนตัว</title>
    <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
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

        .text-primary { color: var(--deep-sea) !important; }
        
        .btn-primary {
            background-color: var(--clownfish) !important;
            border-color: var(--clownfish) !important;
        }
        .btn-primary:hover {
            background-color: var(--dark-orange) !important;
            border-color: var(--dark-orange) !important;
        }
        .btn-outline-secondary {
            color: var(--deep-sea);
            border-color: var(--sea-mist);
            background-color: #fff;
        }
        .btn-outline-secondary:hover {
            background-color: var(--sea-mist);
            color: var(--deep-sea);
        }
        .bg-primary {
            background-color: var(--clownfish) !important;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <header>
        <?php include "navUser.php"; ?>
    </header>

    <main class="container py-5 flex-grow-1">
        
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-primary">ตั้งค่าโปรไฟล์</h2>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="old_img" value="<?php echo $row['image']; ?>">
                    
                    <div class="row g-5">
                        
                        <div class="col-lg-4 text-center order-lg-2">
                            <div class="position-relative d-inline-block mb-3">
                                <?php 
                                    $show_img = "../" . $row['image'];
                                    if(empty($row['image']) || !file_exists($show_img)){
                                        $show_img = "../fish_img/profile/avatar-1.jpg"; 
                                    }
                                ?>
                                <img id="preview" src="<?php echo $show_img; ?>" 
                                     class="rounded-circle border border-4 shadow-sm" 
                                     width="180" height="180" style="object-fit: cover;">
                                
                                <label for="upload_img" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-pill px-3 py-1 shadow-sm small" style="cursor: pointer; font-size: 0.8rem;">
                                    เลือกรูป
                                </label>
                                <input type="file" name="profile_img" id="upload_img" hidden accept="image/*">
                            </div>
                            <div class="text-muted small">คลิกปุ่มเพื่อเปลี่ยนรูปโปรไฟล์</div>
                        </div>

                        <div class="col-lg-8 order-lg-1">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Username</label>
                                <label class="form-control bg-light"><?php echo $row['username']; ?></label>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">ชื่อที่แสดง</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">อีเมล</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">รหัสผ่านใหม่ <span class="text-muted fw-normal">(เว้นว่างถ้าไม่เปลี่ยน)</span></label>
                                <input type="password" name="new_pass" class="form-control" placeholder="********">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">ยืนยันรหัสผ่านใหม่ <span class="text-muted fw-normal"></span></label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="********">
                            </div>

                            <div class="mt-4">
                                <button type="submit" name="btn_save" class="btn btn-primary rounded-pill px-4">
                                    บันทึกข้อมูล
                                </button>
                                <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4 ms-2">ยกเลิก</a>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </main>

    <footer class="bg-white text-center py-3 border-top mt-auto">
        <div class="container text-muted">© <?php echo date("Y"); ?> AquaWorld Project</div>
    </footer>

    <script>
        upload_img.onchange = evt => {
            const [file] = upload_img.files
            if (file) preview.src = URL.createObjectURL(file)
        }
    </script>
    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>