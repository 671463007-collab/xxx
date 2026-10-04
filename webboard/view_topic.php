<?php
session_start();
include "../connectDB.php";

$id = $_GET['id'];

$sql_u = "UPDATE questions SET view = view + 1 WHERE id = '$id'";
$conn->query($sql_u);

$sql = "SELECT * FROM questions WHERE id = '$id'";
$query = $conn->query($sql);
$result = $query->fetch_assoc();

$sql_a = "SELECT * FROM answers WHERE question_id = '$id'";
$query_a = $conn->query($sql_a);
$rows_a = $query_a->num_rows;

$my_name = "";
$my_email = "";

if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['name']) && isset($_SESSION['email'])) {
        $my_name = $_SESSION['name'];
        $my_email = $_SESSION['email'];
    } else {
        $user_id = $_SESSION['user_id'];
        $sql_user = "SELECT name, email FROM users WHERE user_id = '$user_id'";
        $query_user = $conn->query($sql_user);
        if ($res_user = $query_user->fetch_assoc()) {
            $my_name = $res_user['name'];
            $my_email = $res_user['email'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รายละเอียดกระทู้</title>

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
        .card-header.bg-dark, .card-header.bg-primary {
            background-color: var(--deep-sea) !important;
            color: #fff !important;
        }
        .btn-secondary {
            background-color: #fff !important;
            color: var(--deep-sea) !important;
            border-color: var(--sea-mist) !important;
        }
        .btn-secondary:hover {
            background-color: var(--sea-mist) !important;
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
        .card {
            box-shadow: 0 4px 15px rgba(2, 46, 81, 0.1) !important;
            border: none !important;
        }

        input[readonly] {
            background-color: #e9ecef;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-4">

        <div class="mb-3">
            <button type="button" class="btn btn-secondary" onclick="window.history.back();">
                ย้อนกลับ
            </button>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><?php echo $result['topic']; ?></h5>
            </div>
            <div class="card-body">
                <p>เนื้อหา :</p>
                <p class="card-text" style="white-space: pre-line;"><?php echo nl2br($result['detail']); ?></p>
            </div>
            <div class="card-footer text-muted">
                <div class="row">
                    <div class="col-md-6">
                        <p class="d-inline">ชื่อผู้ตั้งกระทู้ :</p> <?php echo $result['name']; ?> <br>
                        <p class="d-inline">อีเมล์ :</p> <?php echo $result['email']; ?>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="d-inline">วันที่ตั้งกระทู้ :</p> <?php echo $result['created']; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($rows_a > 0) {
            while ($result_a = $query_a->fetch_assoc()) { ?>
                <div class="card mb-3 border-secondary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 border-end">
                                <p class="mb-1">ชื่อผู้ตอบ:</p>
                                <?php echo $result_a['name']; ?><br>
                                <small class="text-muted"><?php echo $result_a['email']; ?></small>
                            </div>
                            <div class="col-md-9">
                                <p class="mb-1">รายละเอียด:</p>
                                <?php echo nl2br($result_a['detail']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        } else { ?>
            <div class="alert alert-warning text-center">ไม่มีคำตอบ</div>
        <?php } ?>

        <?php if (isset($_SESSION['user_id'])) { ?>
            <div class="card border-primary mt-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <strong>ตอบคำถาม</strong>
                </div>
                <div class="card-body">
                    <form id="add_answer" name="add_answer" method="post" action="add_answer.php">

                        <div class="mb-3 row">
                            <label for="detail" class="col-sm-2 col-form-label text-md-end"><strong>รายละเอียด</strong></label>
                            <div class="col-sm-10">
                                <textarea name="detail" class="form-control" id="detail" rows="5" required></textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label text-md-end"><strong>ชื่อผู้ตอบ</strong></label>
                            <div class="col-sm-10">
                                <input name="name" type="text" class="form-control" id="name" value="<?php echo $my_name; ?>" readonly>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-sm-2 col-form-label text-md-end"><strong>อีเมล์ผู้ตอบ</strong></label>
                            <div class="col-sm-10">
                                <input name="email" type="text" class="form-control" id="email" value="<?php echo $my_email; ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" name="submit" class="btn btn-success">ส่ง</button>
                                <button type="button" class="btn btn-secondary" onclick="window.history.back();">กลับ</button>
                            </div>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div class="text-center mt-4">
                <p class="text-danger">กรุณา <a href="../login/login.php">เข้าสู่ระบบ</a> ก่อนตอบคำถาม</p>
                <button type="button" class="btn btn-secondary" onclick="window.history.back();">กลับ</button>
            </div>
        <?php } ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#add_answer").submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "add_answer.php",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.reload();
                        } else {
                            alert("เกิดข้อผิดพลาด: " + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("ติดต่อเซิฟเวอร์ไม่ได้ หรือโค้ด PHP มี Error");
                    }
                });
            });
        });
    </script>

</body>
</html>