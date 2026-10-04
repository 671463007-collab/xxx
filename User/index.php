<?php
session_start();
include "../connectDB.php";

$where_sql = " WHERE fishs.status = 'approved' ";
$url_params = "";
if (isset($_GET['category']) && $_GET['category'] != "") {
    $cate_id = $_GET['category'];
    $where_sql .= " AND fishs.category = '$cate_id' ";
    $url_params = "&category=" . $cate_id;
}
$per_page = 12;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $per_page;

$sql_count = "SELECT count(*) as total FROM fishs " . $where_sql;
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_record = $row_count['total'];
$total_page = ceil($total_record / $per_page);

$sql = "SELECT fishs.*, fish_type.fish_typename 
        FROM fishs 
        LEFT JOIN fish_type ON fishs.category = fish_type.fish_typeId 
        $where_sql 
        ORDER BY fishs.created_at DESC 
        LIMIT $start, $per_page";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="th">

<head>
    <title>AquaWorld - หน้าหลัก</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap');
        
        :root {
            --deep-sea: #022E51;   /* น้ำเงินเข้ม */
            --clownfish: #CC6D3D;  /* ส้มปลาการ์ตูน */
            --dark-orange: #B74803; /* ส้มอิฐ (ตอนชี้) */
            --sea-mist: #A3B4C8;   /* ฟ้าหม่น */
            --light-bg: #F0F4F8;   /* พื้นหลัง */
        }

        body {
            font-family: 'Sarabun', sans-serif;
            background-color: var(--light-bg) !important;
            color: #333;
        }
        h3.border-primary, .text-primary {
            color: var(--deep-sea) !important;
            border-color: var(--deep-sea) !important;
        }
        .bg-info {
            background-color: var(--deep-sea) !important;
            color: #fff !important;
        }
        .btn-outline-primary {
            color: var(--clownfish) !important;
            border-color: var(--clownfish) !important;
        }
        .btn-outline-primary:hover {
            background-color: var(--clownfish) !important;
            color: #fff !important;
            border-color: var(--clownfish) !important;
        }
        .page-link {
            color: var(--deep-sea) !important;
        }
        .page-item.active .page-link {
            background-color: var(--deep-sea) !important;
            border-color: var(--deep-sea) !important;
        }
        .card {
            border: none !important;
            box-shadow: 0 4px 10px rgba(2, 46, 81, 0.05) !important;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(2, 46, 81, 0.15) !important;
        }
    </style>
</head>

<body class="bg-light">

    <header>
        <?php include "navUser.php"; ?>
    </header>

    <main>
        <div class="container">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../logo/banner.jpg" class="d-block w-100" alt="...">

                    <div class="carousel-caption d-none d-md-block text-end" style="right: 5%; bottom: 10%; left: auto;">
                        <h5>AquaWorld</h5>
                        <p>ค้นพบความรู้และสายพันธุ์ปลาจากทั่วทุกมุมโลกได้ที่นี่</p>
                    </div>

                </div>
            </div>
        </div>

            <div class="row mb-3 mt-3">
                <div class="col-12">
                    <h3 class="border-start border-5 border-primary ps-3">
                        <?php
                        if (isset($_GET['search'])) echo "ผลการค้นหา: " . htmlspecialchars($_GET['search']);
                        elseif (isset($_GET['category'])) echo "หมวดหมู่ปลา";
                        else echo "รายการปลาทั้งหมด";
                        ?>
                    </h3>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $file_name = basename($row['image']);
                        $show_image = "../fish_img/" . $file_name;
                        if ($file_name == "" || !file_exists("../fish_img/" . $file_name)) {
                            $show_image = "https://via.placeholder.com/300x200?text=No+Image";
                            if ($file_name != "") $show_image = "../fish_img/" . $file_name;
                        }
                ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm border-0">
                                <div style="height: 200px; overflow: hidden;">
                                    <img src="<?php echo $show_image; ?>"
                                        class="card-img-top w-100 h-100 object-fit-cover"
                                        alt="<?php echo htmlspecialchars($row['namefish']); ?>"
                                        onerror="this.src='https://via.placeholder.com/300x200?text=Image+Error'">
                                </div>
                                <div class="card-body">
                                    <span class="badge bg-info text-dark mb-2">
                                        <?php echo isset($row['fish_typename']) ? $row['fish_typename'] : 'ทั่วไป'; ?>
                                    </span>
                                    <h5 class="card-title text-truncate"><?php echo htmlspecialchars($row['namefish']); ?></h5>
                                    <p class="card-text small text-muted">
                                        <?php echo mb_substr($row['description'], 0, 50) . '...'; ?>
                                    </p>
                                </div>
                                <div class="card-footer bg-white border-top-0 pb-3">
                                    <a href="detail.php?id=<?php echo $row['fish_id']; ?>" class="btn btn-outline-primary w-100 btn-sm rounded-pill">ดูรายละเอียด</a>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<div class="col-12 text-center py-5 text-muted"><h4>ไม่พบข้อมูล</h4></div>';
                }
                ?>
            </div>
        </div>

        <?php if ($total_record > $per_page): ?>
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="index.php?page=<?= $page - 1 . $url_params ?>">ก่อนหน้า</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                        <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                            <a class="page-link" href="index.php?page=<?= $i . $url_params ?>"><?= $i ?></a>
                        </li>
                    <?php } ?>
                    <li class="page-item <?php if ($page >= $total_page) echo 'disabled'; ?>">
                        <a class="page-link" href="index.php?page=<?= $page + 1 . $url_params ?>">ถัดไป</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>

    </main>

    <footer class="bg-body-tertiary text-center mt-5">
        <div class="container p-4 pb-0">
            <section class="mb-4">
                <a
                    class="btn text-white btn-floating m-1"
                    style="background-color: #3b5998;"
                    href="#!"
                    role="button"><i class="fab fa-facebook-f"></i></a>

                <a
                    class="btn text-white btn-floating m-1"
                    style="background-color: #55acee;"
                    href="#!"
                    role="button"><i class="fab fa-twitter"></i></a>

                <a
                    class="btn text-white btn-floating m-1"
                    style="background-color: #ac2bac;"
                    href="#!"
                    role="button"><i class="fab fa-instagram"></i></a>
            </section>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © <?php echo date("Y"); ?> Copyright:
            <a class="text-body" href="#">AquaWorld Project</a>
        </div>
    </footer>

    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>