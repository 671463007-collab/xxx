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
                <li class="nav-item"><a class="nav-link" href="/mini_project_1/User/index.php">หน้าหลัก</a></li>
                <li class="nav-item"><a class="nav-link" href="/mini_project_1/User/addfish.php">เพิ่มข้อมูลปลา</a></li>
                <li class="nav-item"><a class="nav-link" href="../webboard/main_webboard.php">ชุมชน</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">ประเภทปลา</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?category=1">ปลาน้ำจืด</a></li>
                        <li><a class="dropdown-item" href="index.php?category=2">ปลาน้ำเค็ม</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/mini_project_1/User/index.php">ดูทั้งหมด</a></li>
                    </ul>
                </li>
            </ul>

            <form class="d-flex me-3" role="search" action="/mini_project_1/User/index.php" method="GET">
                <div class="input-group">
                    <input class="form-control border-end-0" type="search" name="search" placeholder="ค้นหาชื่อปลา...">
                    <button class="btn btn-outline-secondary border-start-0" type="submit">
                        ค้นหา
                    </button>
                </div>
            </form>

            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle p-0 d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="<?php echo $nav_profile_img; ?>"
                                alt="Profile"
                                style="width:40px; height: 40px; object-fit: cover;"
                                class="rounded-circle border ms-2">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="profile.php">แก้ไขโปรไฟล์</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    ออกจากระบบ
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary rounded-pill px-4 ms-2" href="../login/login.php">
                            เข้าสู่ระบบ
                        </a>
                    </li>
                <?php endif; ?>
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