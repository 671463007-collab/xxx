<?php
session_start();
include "../connectDB.php";
if (isset($_GET['id']) && isset($_GET['act'])) {
    $id = $_GET['id'];
    $act = $_GET['act'];

    if ($act == 'no') { 
        $conn->query("DELETE FROM users WHERE user_id = '$id'");
        echo "<script>alert('ลบข้อมูลสมาชิกสำเร็จ'); window.location='Adminmember.php';</script>";
    }
}
$sql_list = "SELECT * FROM users ORDER BY user_id DESC";
$result_list = $conn->query($sql_list);

?>

<!doctype html>
<html lang="en">

<head>
    <title>จัดการข้อมูลสมาชิก</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #F0F4F8;
        }

        .text-deep-sea {
            color: #022E51;
        }

        .table-head-theme {
            background-color: #022E51 !important;
            color: white !important;
        }

        .img-profile {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <header>
        <?php
        include "navAdmin.php";
        ?>

    </header>

    <div class="container mt-4">

        <button type="button" class="btn btn-secondary mb-3" onclick="window.history.back();">ย้อนกลับ</button>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="text-deep-sea fw-bold">จัดการข้อมูลสมาชิก</h3>
        </div>

        <div class="table-responsive shadow-sm" style="border-radius: 8px; overflow: hidden;">
            <table class="table table-hover bg-white align-middle mb-0">
                <thead class="table-head-theme">
                    <tr>
                        <th class="py-3">รูป</th>
                        <th class="py-3">ชื่อผู้ใช้งาน (Username)</th>
                        <th class="py-3">ชื่อ-นามสกุล</th>
                        <th class="py-3">อีเมล</th>
                        <th class="py-3">ระดับสิทธิ์</th>
                        <th class="py-3 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_list->fetch_assoc()) {
                        $img_path = "../" . $row['image'];
                    ?>
                        <tr>
                            <td>
                                <?php if (!empty($row['image'])): ?>
                                    <img src="<?= $img_path ?>" class="img-profile" alt="profile">
                                <?php else: ?>
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">?</div>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold text-deep-sea"><?= $row["username"] ?></td>
                            <td><?= $row["name"] ?></td>
                            <td><?= $row["email"] ?></td>
                            <td>
                                <span class="badge <?= ($row['role'] == 'admin') ? 'bg-danger' : 'bg-info' ?>">
                                    <?= $row["role"] ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="Adminmember.php?id=<?= $row["user_id"] ?>&act=no"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('ยืนยันลบสมาชิกคุณ <?= $row['name'] ?>?');">
                                    ลบ
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>