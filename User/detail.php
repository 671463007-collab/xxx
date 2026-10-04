<?php
session_start();
include "../connectDB.php"; 
if (isset($_POST['ajax_action'])) {
    header('Content-Type: application/json');

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401); 
        echo json_encode(['message' => 'Unauthorized']);
        exit; 
    }

    $user_id = $_SESSION['user_id'];
    if ($_POST['ajax_action'] == 'like_toggle') {
        $fish_id = mysqli_real_escape_string($conn, $_POST['id']);
        $check = $conn->query("SELECT id FROM fish_likes WHERE user_id = '$user_id' AND fish_id = '$fish_id'");

        if ($check->num_rows > 0) {
            $conn->query("DELETE FROM fish_likes WHERE user_id = '$user_id' AND fish_id = '$fish_id'");
            $status = 'deleted';
        } else {
            $conn->query("INSERT INTO fish_likes (user_id, fish_id) VALUES ('$user_id', '$fish_id')");
            $status = 'inserted';
        }
        $count_result = $conn->query("SELECT COUNT(*) as total FROM fish_likes WHERE fish_id = '$fish_id'");
        echo json_encode(['status' => $status, 'like_count' => $count_result->fetch_assoc()['total']]);
        exit;
    }
    if ($_POST['ajax_action'] == 'add_comment') {
        $detail = mysqli_real_escape_string($conn, trim($_POST['detail']));
        $fish_id = mysqli_real_escape_string($conn, $_POST['id']);
        
        $u_id = $_SESSION['user_id'];
        $u_info = $conn->query("SELECT name, email FROM users WHERE user_id = '$u_id'")->fetch_assoc();
        $name = $u_info['name'];
        $email = $u_info['email'];
        $sql = "INSERT INTO fish_comments (fish_id, user_id, detail, name, email) VALUES ('$fish_id', '$u_id', '$detail', '$name', '$email')";
        
        if ($conn->query($sql)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }
}
$row_detail = null;
$is_liked = false;
$total_likes = 0;
$comments = [];

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $sql_detail = "SELECT fishs.*, fish_type.fish_typename 
                   FROM fishs 
                   LEFT JOIN fish_type ON fishs.category = fish_type.fish_typeid 
                   WHERE fishs.fish_id = '$id' ";
                   
    $result_detail = $conn->query($sql_detail);
    if($result_detail->num_rows > 0){
        $row_detail = $result_detail->fetch_assoc();
        $fish_id = $row_detail['fish_id'];

        $q_count = $conn->query("SELECT COUNT(*) as total FROM fish_likes WHERE fish_id = '$fish_id'");
        $total_likes = $q_count->fetch_assoc()['total'];

        if(isset($_SESSION['user_id'])) {
            $my_id = $_SESSION['user_id'];
            $q_check = $conn->query("SELECT id FROM fish_likes WHERE fish_id = '$fish_id' AND user_id = '$my_id'");
            $is_liked = ($q_check->num_rows > 0);
        }

        $comments = $conn->query("SELECT * FROM fish_comments WHERE fish_id = '$fish_id' ORDER BY id DESC");
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title><?php echo isset($row_detail) ? $row_detail['namefish'] : 'รายละเอียดปลา'; ?> - AquaWorld</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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
        .text-primary { color: var(--deep-sea) !important; }

        .btn-outline-secondary {
            color: var(--deep-sea);
            border-color: var(--sea-mist);
            background-color: #fff;
        }
        .btn-outline-secondary:hover {
            background-color: var(--sea-mist);
            color: var(--deep-sea);
        }
        .btn-danger {
            background-color: var(--clownfish) !important;
            border-color: var(--clownfish) !important;
        }
        .btn-outline-danger {
            color: var(--clownfish) !important;
            border-color: var(--clownfish) !important;
        }
        .btn-outline-danger:hover {
            background-color: var(--clownfish) !important;
            color: #fff !important;
        }
        .bg-info { background-color: var(--deep-sea) !important; color: #fff !important; }

        .comment-card { 
            border-left: 5px solid var(--clownfish) !important; 
            background-color: #fff !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .btn-primary {
            background-color: var(--clownfish) !important;
            border-color: var(--clownfish) !important;
        }
        .btn-primary:hover {
            background-color: var(--dark-orange) !important;
        }
        
        .border-success { border-color: var(--deep-sea) !important; }
        
        .btn-like { transition: all 0.2s; }
    </style>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <header><?php include "navUser.php"; ?></header>

    <main class="container py-5 flex-grow-1">
        <?php if ($row_detail): ?>
            <div class="mb-4">
                <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">ย้อนกลับ</a>
            </div>

            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 overflow-hidden">
                        <div class="bg-white p-3 d-flex align-items-center justify-content-center" style="min-height: 400px;">
                            <?php $show_img = "../" . $row_detail['image']; ?>
                            <img src="<?php echo $show_img; ?>" class="img-fluid rounded" style="max-height: 500px; object-fit: contain;">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <h1 class="fw-bold text-primary mb-2 display-6"><?php echo htmlspecialchars($row_detail['namefish']); ?></h1>
                    
                    <div class="mb-4 d-flex align-items-center gap-2">
                        <span class="badge bg-info text-dark fs-6 rounded-pill px-3 py-2">
                            <?php echo $row_detail['fish_typename']; ?>
                        </span>
                        
                        <button type="button" 
                                class="btn <?php echo $is_liked ? 'btn-danger' : 'btn-outline-danger'; ?> btn-like rounded-pill px-3 py-2" 
                                data-id="<?php echo $row_detail['fish_id']; ?>">
                            ถูกใจ (<span class="like-count"><?php echo $total_likes; ?></span>)
                        </button>
                    </div>
                    
                    <div class="text-muted mb-4 small">
                        ลงข้อมูลเมื่อ: <?php echo date('d/m/Y', strtotime($row_detail['created_at'])); ?>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold text-dark border-start border-4 border-success ps-3">รายละเอียด</h5>
                        <p class="text-secondary mt-2" style="white-space: pre-line; line-height: 1.8;"><?php echo htmlspecialchars($row_detail['description']); ?></p>
                    </div>

                    <?php if (!empty($row_detail['care_detail'])): ?>
                    <div class="bg-warning-subtle p-4 rounded-3 border border-warning-subtle mt-4">
                        <h5 class="fw-bold text-dark mb-3">วิธีการเลี้ยงดู</h5>
                        <p class="mb-0 text-dark" style="white-space: pre-line;"><?php echo htmlspecialchars($row_detail['care_detail']); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-4 p-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-between border-bottom pb-3 mb-4">
                            <h3 class="fw-bold text-primary m-0">ความคิดเห็น</h3>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold">แสดงความคิดเห็นของคุณ</label>
                            <textarea id="comment-text" class="form-control mb-2" rows="3" placeholder="<?php echo isset($_SESSION['user_id']) ? 'เขียนข้อความที่นี่...' : 'กรุณาเข้าสู่ระบบเพื่อแสดงความคิดเห็น'; ?>" <?php echo !isset($_SESSION['user_id']) ? 'disabled' : ''; ?>></textarea>
                            <button type="button" id="btn-comment" class="btn btn-primary px-4 rounded-pill" <?php echo !isset($_SESSION['user_id']) ? 'disabled' : ''; ?>>ส่งความเห็น</button>
                        </div>

                        <div id="comment-list">
                            <?php if ($comments->num_rows > 0): ?>
                                <?php while($c = $comments->fetch_assoc()): ?>
                                    <div class="comment-card p-3 mb-3 rounded shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong class="text-primary"><?php echo htmlspecialchars($c['name']); ?></strong>
                                                <small class="text-muted ms-2"><?php echo htmlspecialchars($c['email']); ?></small>
                                            </div>
                                            <small class="text-muted" style="font-size: 0.85rem;">
                                                <?php echo date('d/m/Y H:i', strtotime($c['time'])); ?>
                                            </small>
                                        </div>
                                        <p class="mb-0 mt-2 text-dark"><?php echo nl2br(htmlspecialchars($c['detail'])); ?></p>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p class="text-muted text-center py-4">ยังไม่มีความคิดเห็น มาเป็นคนแรกที่แสดงความเห็นกัน!</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <footer class="bg-body-tertiary text-center p-3 mt-auto">© <?php echo date("Y"); ?> AquaWorld Project</footer>

    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function(){
        $('.btn-like').click(function(){
            var button = $(this);
            $.ajax({
                url: '', method: 'POST',
                data: { ajax_action: 'like_toggle', id: button.data('id') },
                dataType: 'json',
                success: function(res) {
                    if(res.status == 'inserted') {
                        button.removeClass('btn-outline-danger').addClass('btn-danger');
                        button.find('i').removeClass('far').addClass('fas'); 
                    } else {
                        button.removeClass('btn-danger').addClass('btn-outline-danger');
                        button.find('i').removeClass('fas').addClass('far'); 
                    }
                    button.find('.like-count').text(res.like_count);
                },
                error: function(xhr) { if(xhr.status == 401) alert('กรุณาเข้าสู่ระบบก่อนครับ'); }
            });
        });

        $('#btn-comment').click(function(){
            var text = $('#comment-text').val();
            if(text.trim() == "") { alert("กรุณากรอกข้อความ"); return; }
            
            $.ajax({
                url: '', method: 'POST',
                data: { ajax_action: 'add_comment', id: '<?php echo $row_detail['fish_id']; ?>', detail: text },
                dataType: 'json',
                success: function(res) {
                    if(res.status == 'success') location.reload(); 
                    else alert("เกิดข้อผิดพลาด");
                }
            });
        });
    });
    </script>
</body>
</html>