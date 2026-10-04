<?php
session_start();
include "../connectDB.php";
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Admin</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <header>
            <?php 
            include "navAdmin.php"; 
            ?>
            
        </header>
        <main>

        <?php

$userCount      = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$topicCount     = $conn->query("SELECT COUNT(*) AS total FROM questions")->fetch_assoc()['total'];
$fishCount    = $conn->query("SELECT COUNT(*) AS total FROM fishs")->fetch_assoc()['total'];

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - AquaWorld</title>

    <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #F0F4F8;
        }
        .bg-deep-sea {
            background-color: #022E51 !important;
            color: white;
        }
        .bg-clownfish {
            background-color: #CC6D3D !important;
            color: white;
        }
        .bg-dark-orange {
            background-color: #B74803 !important;
            color: white;
        }
        .card {
            border: none;
        }
    </style>

</head>
<body>

<div class="container mt-4">

    <h3 class="mb-4" style="color: #022E51;">Dashboard สรุปข้อมูลระบบ</h3>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card bg-deep-sea shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">จำนวนสมาชิกทั้งหมด</h5>
                    <h1><?= $userCount ?></h1>
                    </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-clownfish shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">จำนวนกระทู้ทั้งหมด</h5>
                    <h1><?= $topicCount ?></h1>
                    </div>
            </div>
        </div>

        <div class="col-md-4">
             <div class="card bg-dark-orange shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">จำนวนปลาทั้งหมด</h5>
                    <h1><?= $fishCount ?></h1>
                    </div>
            </div>
        </div>

    </div>

</div>

<script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
