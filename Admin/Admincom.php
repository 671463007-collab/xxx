<?php
session_start();
include "../connectDB.php";
if (isset($_GET['id']) && isset($_GET['act'])) {
    $id = $_GET['id'];
    $act = $_GET['act'];

    if ($act == 'no') {
        $conn->query("DELETE FROM answers WHERE id = '$id'");
        echo "<script>alert('ลบคอมเม้นสำเร็จ'); window.location='Admincom.php';</script>";
    }
}
$sql_list = "SELECT a.*, q.topic FROM answers a 
             LEFT JOIN questions q ON a.question_id = q.id 
             ORDER BY a.id DESC";
$result_list = $conn->query($sql_list);

?>

<!doctype html>
<html lang="en">

<head>
    <title>จัดการคอมเม้น</title>
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
            <h3 class="text-deep-sea fw-bold">จัดการคอมเม้น (ลบข้อมูล)</h3>
        </div>

        <div class="table-responsive shadow-sm" style="border-radius: 8px; overflow: hidden;">
            <table class="table table-hover bg-white align-middle mb-0">
                <thead class="table-head-theme">
                    <tr>
                        <th class="py-3" width="25%">กระทู้ที่ตอบ</th>
                        <th class="py-3" width="30%">ข้อความคอมเม้น</th>
                        <th class="py-3" width="20%">ผู้คอมเม้น</th>
                        <th class="py-3 text-center" width="15%">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_list->fetch_assoc()) { ?>
                        <tr>
                            <td>
                                <small class="text-muted">กระทู้:</small><br>
                                <strong><?= $row["topic"] ? $row["topic"] : "<span class='text-danger'>ไม่พบกระทู้</span>" ?></strong>
                            </td>
                            <td>
                                <div style="max-height: 60px; overflow: hidden; font-size: 0.9rem;">
                                    <?= $row["detail"] ?>
                                </div>
                            </td>
                            <td>
                                <?= $row["name"] ?><br>
                                <small class="text-muted"><?= $row["email"] ?></small>
                            </td>
                            <td class="text-center">
                                <a href="Admincom.php?id=<?= $row["id"] ?>&act=no"
                                    class="btn btn-danger btn-sm px-3"
                                    onclick="return confirm('ยืนยันลบคอมเม้นของคุณ <?= $row['name'] ?>?');">
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