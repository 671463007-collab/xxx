<?php
session_start();
include "../connectDB.php";

$sql = "SELECT * FROM questions ORDER BY id DESC ";
$query = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ระบบ Webboard กระทู้ ถาม ตอบ</title>

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
        h2, .text-primary {
            color: var(--deep-sea) !important;
        }
        .btn-success {
            background-color: var(--clownfish) !important;
            border-color: var(--clownfish) !important;
        }
        .btn-success:hover {
            background-color: var(--dark-orange) !important;
            border-color: var(--dark-orange) !important;
        }
        .table-dark {
            background-color: var(--deep-sea) !important;
            color: #fff;
        }
        .table-dark th {
            background-color: var(--deep-sea) !important;
            border-color: #03406e;
        }
        .table-hover tbody tr:hover {
            background-color: #e2eaf4;
        }
        .topic-link {
            text-decoration: none;
            color: var(--deep-sea);
            font-weight: 500;
            display: block; 
        }
        .topic-link:hover {
            color: var(--clownfish);
        }
        .card {
            box-shadow: 0 4px 15px rgba(2, 46, 81, 0.1) !important;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">
        
        <div class="row mb-4 align-items-center">
            <div class="col-md-8">
                <h2 class="mb-0">Webboard พูดคุย</h2>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="new_topic.php" class="btn btn-success btn-lg shadow-sm">
                    ตั้งกระทู้ใหม่
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark text-white">
                            <tr>
                                <th class="text-center" style="width: 80px;">ลำดับ</th>
                                <th>หัวข้อกระทู้</th>
                                <th class="text-center" style="width: 180px;">วันที่ตั้ง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($query->num_rows > 0) {
                                while ($result = $query->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td class="text-center text-muted"><?php echo $i; ?></td>
                                    <td>
                                        <a href="view_topic.php?id=<?php echo $result['id']; ?>" class="topic-link">
                                            <?php echo $result['topic']; ?>
                                        </a>
                                    </td>
                                    <td class="text-center text-secondary" style="font-size: 0.9rem;">
                                        <?php echo $result['created']; ?>
                                    </td>
                                </tr>
                            <?php
                                    $i++;
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <br>
                                        ยังไม่มีกระทู้ในขณะนี้
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>