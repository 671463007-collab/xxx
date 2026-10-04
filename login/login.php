<?php
session_start();
include "../connectDB.php";

if ((isset($_REQUEST['user_name'])) && isset($_REQUEST['password'])) {

  $user_name = trim($_REQUEST['user_name']);
  $password = $_REQUEST['password'];

  if ($user_name == "" || $password == "") {
    echo "<script>
    alert('กรุณากรอกชื่อผู้ใช้และรหัสผ่าน');
    history.back();
  </script>";
    exit;
  }

  $sql = "
  SELECT * FROM users 
  WHERE email = '$user_name' 
    OR username = '$user_name'
  LIMIT 1
";

  $result = $conn->query($sql);

  if ($result->num_rows == 1) {

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['pass'])) {

      $_SESSION['user_id']  = $user['user_id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['email']    = $user['email'];
      $_SESSION['role']     = $user['role'];
      $_SESSION['image']    = $user['image'];

      

      if ($user['role'] == 'admin') {

                echo "<script> alert('ยินดีต้อนรับผู้ดูแลระบบ'); window.location='../Admin/Adminindex.php'; </script>";
            } else {
                echo "<script> window.location='../User/index.php'; </script>";
            }
        } else {
            echo "<script> alert('รหัสผ่านไม่ถูกต้อง'); history.back(); </script>";
        }
    } else {
        echo "<script> alert('ไม่พบผู้ใช้นี้ในระบบ'); history.back(); </script>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>ระบบลงทะเบียน</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="login.css">
</head>

<body>
  <header>
  </header>
  <main>

    <section class="min-vh-100 d-flex justify-content-center align-items-center bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-5 col-lg-4">
            <div class="card shadow p-4">

              <div class="text-center mb-2">
                <h3 class="fw-bold">
                  <span class="text-primary">AquaWorld</span>
                </h3>
              </div>
              <div class="row">
                <div class="col-sm-12">

                  <div id="loginForm">
                    <br>
                    <form class="login-form" method="post" action="">

                      <div class="mb-3">
                        <label for="user_name" class="form-label">ชื่อผู้ใช้ / อีเมล</label>
                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="UserName" required>
                      </div>

                      <div class="mb-3">
                        <label for="password" class="form-label">รหัสผ่าน</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                      </div>

                      <div class="d-grid gap-2 mb-3">
                        <button type="submit" name="login" class="btn btn-primary">ล็อคอิน</button>
                      </div>

                      <div class="mb-3">
                        <div class="text-center mt-3">ผู้ใช้ใหม่หรอ?
                          <a href="#!" onclick="showSignup()">สร้างบัญชีใหม่</a>
                        </div>
                      </div>
                    </form>
                  </div>

                  <div id="signupForm" class="d-none">
                    <form class="login-form" action="register.php" method="POST">

                      <div class="mb-2">
                        <input type="text" class="form-control" name="user_name" placeholder="User Name" required>
                      </div>
                      <div class="mb-2">
                        <input type="text" class="form-control" name="fullname" placeholder="Name" required>
                      </div>

                      <div class="mb-2">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                      </div>

                      <div class="mb-2">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                      </div>

                      <div class="mb-3">
                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
                      </div>

                      <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary">ลงทะเบียน</button>
                      </div>

                      <div class="mb-3">
                        <div class="text-center">
                          มีเเอ็คเคาอยู่เเล้วใช่ไหม
                          <a href="#!" onclick="showLogin()">ล็อคอิน</a>
                        </div>
                      </div>

                    </form>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
    </section>

  </main>
  <footer>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

  <script>
    function showSignup() {
      document.getElementById("loginForm").classList.add("d-none");
      document.getElementById("signupForm").classList.remove("d-none");
    }

    function showLogin() {
      document.getElementById("loginForm").classList.remove("d-none");
      document.getElementById("signupForm").classList.add("d-none");
    }
  </script>
</body>

</html>