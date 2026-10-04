<?php
include "../connectDB.php";

// ตั้งค่ารูปโปรไฟล์เริ่มต้น
$nav_profile_img = "../assets/fish_img/profile/avatar-1.jpg";

if (isset($_SESSION['user_id'])) {
    $nav_user_id = $_SESSION['user_id'];

    // ดึงแค่รูปภาพอย่างเดียว ไม่ดึงชื่อแล้ว
    $sql_nav = "SELECT image FROM users WHERE user_id = '$nav_user_id'";
    $result_nav = $conn->query($sql_nav);

    if ($result_nav && $result_nav->num_rows > 0) {
        $row_nav = $result_nav->fetch_assoc();
        $db_img = $row_nav['image'];

        if (!empty($db_img)) {
            $clean_path = str_replace("assets/", "", $db_img);
            $check_path = "../" . $clean_path;

            if (file_exists($check_path)) {
                $nav_profile_img = $check_path;
            }
        }
    }
}
?>

<style>
    :root {
        --deep-sea: #022E51;  
        --clownfish: #CC6D3D; 
        --dark-orange: #B74803; 
        --sea-mist: #A3B4C8;  
    }
    .navbar {
        border-bottom: 3px solid var(--clownfish);
    }
    
    .navbar-brand.text-primary {
        color: var(--deep-sea) !important;
    }
    
    .nav-link {
        color: var(--deep-sea) !important;
        font-weight: 500;
    }
    .nav-link:hover {
        color: var(--clownfish) !important;
    }
    .btn-outline-secondary {
        color: var(--deep-sea) !important;
        border-color: #ced4da !important;
    }
    .btn-outline-secondary:hover {
        background-color: var(--sea-mist) !important;
        color: #fff !important;
    }
    .btn-primary {
        background-color: var(--clownfish) !important;
        border-color: var(--clownfish) !important;
        color: #fff !important;
    }
    .btn-primary:hover {
        background-color: var(--dark-orange) !important;
        border-color: var(--dark-orange) !important;
    }
    .dropdown-item:active {
        background-color: var(--deep-sea) !important;
    }
    .logout-warning-text {
        color: var(--clownfish);
        font-size: 1.5rem;
        font-weight: bold;
    }
</style>

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center fw-bold text-primary" href="index.php">
             AquaWorld
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="Adminindex.php">Dashboard สรุปข้อมูลระบบ</a></li>
                <li class="nav-item"><a class="nav-link" href="Adminmember.php">สามาชิก</a></li>
                <li class="nav-item"><a class="nav-link" href="Adminwebboard.php">กระทู้</a></li>
                <li class="nav-item"><a class="nav-link" href="Adminfish.php">ปลา</a></li>
                <li class="nav-item"><a class="nav-link" href="Admincom.php">คอมเมนต์</a></li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../login/login.php">ออกจากระบบ</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center pt-4">
                <div class="logout-warning-text mb-3">!</div>
                <h5>ต้องการออกจากระบบ?</h5>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">ยกเลิก</button>
                <a href="../login/logout.php" class="btn btn-danger btn-sm">ยืนยัน</a>
            </div>
        </div>
    </div>
</div>