<?php
session_start();
include "../connectDB.php"; 
if (isset($_GET['id']) && isset($_GET['act'])) {
    $id = $_GET['id'];
    $act = $_GET['act'];

    if ($act == 'no') {
        $conn->query("DELETE FROM questions WHERE id = '$id'");
        echo "<script>alert('ลบกระทู้สำเร็จ'); window.location='Adminquestion.php';</script>";
    }
}
$sql_list = "SELECT * FROM questions ORDER BY created DESC";
$result_list = $conn->query($sql_list);

?>

<!doctype html>
<html lang="en">

<head>
    <title>จัดการข้อมูลกระทู้</title>
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
            <h3 class="text-deep-sea fw-bold">จัดการกระทู้ (ลบข้อมูล)</h3>
        </div>

        <div class="table-responsive shadow-sm" style="border-radius: 8px; overflow: hidden;">
            <table class="table table-hover bg-white align-middle mb-0">
                <thead class="table-head-theme">
                    <tr>
                        <th class="py-3" width="30%">หัวข้อกระทู้</th>
                        <th class="py-3" width="20%">ผู้สร้าง</th>
                        <th class="py-3" width="20%">วันที่สร้าง</th>
                        <th class="py-3 text-center" width="20%">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_list->fetch_assoc()) { ?>
                        <tr>
                            <td class="fw-bold text-deep-sea">
                                <?= $row["topic"] ?>
                                <br><small class="text-muted"><?= mb_substr($row["detail"], 0, 50) ?>...</small>
                            </td>
                            <td>
                                <?= $row["name"] ?><br>
                                <small class="text-muted"><?= $row["email"] ?></small>
                            </td>
                            <td class="small"><?= $row["created"] ?></td>
                            <td class="text-center">
                                <a href="Adminquestion.php?id=<?= $row["id"] ?>&act=no"
                                    class="btn btn-danger btn-sm px-3"
                                    onclick="return confirm('คุณต้องการลบกระทู้หัวข้อ: <?= $row['topic'] ?> หรือไม่?');">
                                    ลบกระทู้
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