<?php
session_start();
include "../connectDB.php";
if (isset($_POST['btn_update'])) {
    $fish_id = $_POST['fish_id'];
    $namefish = $_POST['namefish'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $care_detail = $_POST['care_detail'];
    $old_image = $_POST['old_image'];

    if (!empty($_FILES['file1']['name'])) {
        $new_image_name = 'fish_' . uniqid() . "." . pathinfo($_FILES['file1']['name'], PATHINFO_EXTENSION);
        $upload_path = "../assets/fish_img/" . $new_image_name;
        move_uploaded_file($_FILES['file1']['tmp_name'], $upload_path);
        $image_db = "assets/fish_img/" . $new_image_name;
    } else {
        $image_db = $old_image;
    }

    $sql = "UPDATE fishs SET 
            namefish = '$namefish', 
            category = '$category', 
            description = '$description', 
            care_detail = '$care_detail', 
            image = '$image_db' 
            WHERE fish_id = '$fish_id'";

    if ($conn->query($sql)) {
        echo "<script>alert('แก้ไขข้อมูลเรียบร้อย'); window.location='Adminfish.php';</script>";
    } else {
        echo "<script>alert('ผิดพลาด: " . $conn->error . "');</script>";
    }
}

if (isset($_GET['id']) && isset($_GET['act'])) {
    $id = $_GET['id'];
    $act = $_GET['act'];

    if ($act == 'yes') {
        $conn->query("UPDATE fishs SET status = 'approved' WHERE fish_id = '$id'");
        echo "<script>alert('อนุมัติเรียบร้อย'); window.location='Adminfish.php';</script>";
    } elseif ($act == 'no') {
        $conn->query("DELETE FROM fishs WHERE fish_id = '$id'");
        echo "<script>alert('ลบข้อมูลสำเร็จ'); window.location='Adminfish.php';</script>";
    }
}
$edit_mode = false;
$row_edit = null;

if (isset($_GET['edit_id'])) {
    $edit_mode = true;
    $edit_id = $_GET['edit_id'];
    $result_edit = $conn->query("SELECT * FROM fishs WHERE fish_id = '$edit_id'");
    $row_edit = $result_edit->fetch_assoc();
}

$sql_list = "SELECT * FROM fishs ORDER BY fish_id DESC";
$result_list = $conn->query($sql_list);

?>

<!doctype html>
<html lang="en">

<head>
    <title>จัดการข้อมูลปลา</title>
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

        .btn-approve {
            background-color: #CC6D3D;
            color: white;
            border: none;
        }

        .btn-approve:hover {
            background-color: #B74803;
            color: white;
        }

        .img-preview {
            width: 100px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
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

        <?php if (!$edit_mode): ?>
            <button type="button" class="btn btn-secondary mb-3" onclick="window.history.back();">ย้อนกลับ</button>
        <?php endif; ?>

        <?php if ($edit_mode && $row_edit): ?>

            <div class="card shadow border-0">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0 fw-bold">แก้ไขข้อมูล: <?= $row_edit['namefish'] ?></h4>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="fish_id" value="<?= $row_edit['fish_id'] ?>">
                        <input type="hidden" name="old_image" value="<?= $row_edit['image'] ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">ชื่อปลา</label>
                                <input type="text" name="namefish" class="form-control" value="<?= $row_edit['namefish'] ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">หมวดหมู่</label>
                                <input type="text" name="category" class="form-control" value="<?= $row_edit['category'] ?>" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">รายละเอียด</label>
                                <textarea name="description" class="form-control" rows="3"><?= $row_edit['description'] ?></textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">วิธีเลี้ยงดู</label>
                                <textarea name="care_detail" class="form-control" rows="3"><?= $row_edit['care_detail'] ?></textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">รูปภาพ</label><br>
                                <img src="../<?= $row_edit['image'] ?>" width="120" class="mb-2 border rounded">
                                <input type="file" name="file1" class="form-control">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="Adminfish.php" class="btn btn-secondary">ยกเลิก</a>
                            <button type="submit" name="btn_update" class="btn btn-success px-4">บันทึกการแก้ไข</button>
                        </div>
                    </form>
                </div>
            </div>

        <?php else: ?>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-deep-sea fw-bold">จัดการข้อมูลปลา</h3>
            </div>

            <div class="table-responsive shadow-sm" style="border-radius: 8px; overflow: hidden;">
                <table class="table table-hover bg-white align-middle mb-0">
                    <thead class="table-head-theme">
                        <tr>
                            <th class="py-3">รูปภาพ</th>
                            <th class="py-3">ชื่อปลา</th>
                            <th class="py-3">หมวดหมู่</th>
                            <th class="py-3">รายละเอียด</th>
                            <th class="py-3">สถานะ</th>
                            <th class="py-3 text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_list->fetch_assoc()) {
                            $img_path = "../" . $row['image'];
                        ?>
                            <tr>
                                <td><img src="<?= $img_path ?>" class="img-preview" alt="รูปปลา"></td>
                                <td class="fw-bold text-deep-sea"><?= $row["namefish"] ?></td>
                                <td><span class="badge bg-light text-dark border"><?= $row["category"] ?></span></td>
                                <td class="small text-muted"><?= mb_substr($row["description"], 0, 40) ?>...</td>
                                <td>
                                    <?php if ($row["status"] == 'approved'): ?>
                                        <span class="text-success fw-bold">อนุมัติแล้ว</span>
                                    <?php else: ?>
                                        <span class="text-warning fw-bold">รอตรวจสอบ</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['status'] != 'approved'): ?>
                                        <a href="Adminfish.php?id=<?= $row["fish_id"] ?>&act=yes" class="btn btn-approve btn-sm mb-1">อนุมัติ</a>
                                    <?php endif; ?>
                                    <a href="Adminfish.php?edit_id=<?= $row['fish_id'] ?>" class="btn btn-warning btn-sm text-white mb-1">แก้ไข</a>
                                    <a href="Adminfish.php?id=<?= $row["fish_id"] ?>&act=no" class="btn btn-danger btn-sm mb-1" onclick="return confirm('ยืนยันลบ?');">ลบ</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>