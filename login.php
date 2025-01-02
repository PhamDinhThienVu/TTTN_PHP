<?php
session_start();
include('inc/head.php');
?>
<body id="page-top">
<link href="css/login.css" rel="stylesheet" />
    <?php include 'inc/nav.php'; ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <h2>Đăng nhập</h2>
                <form method="post" action="login.php">
                    <div class="form-group">
                        <label for="username">Tên tài khoản:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                </form>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    include "inc/db-connect.inc.php";
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $query = "SELECT * FROM users WHERE username = ?";

                    try {
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$username]);
                        if ($stmt->rowCount() > 0) {
                            $user = $stmt->fetch();
                            if (password_verify($password, $user['password'])) {
                                $_SESSION['username'] = $user['username'];
                                // Chuyển hướng dựa trên role
                                if ($user['role'] === 'ADMIN') {
                                    header('Location: admin/index.php');
                                } else {
                                    header('Location: index.php');
                                }
                                exit();
                            } else {
                                echo '<div class="alert alert-danger mt-3" role="alert">
                                     Mật khẩu không đúng.
                                    </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger mt-3" role="alert">
                              Tài khoản không tồn tại.
                              </div>';
                        }
                     } catch (PDOException $e) {
                         echo '<div class="alert alert-danger mt-3" role="alert">
                                      Lỗi: ' . htmlspecialchars($e->getMessage()) . '
                                  </div>';
                        }
                   }
                ?>
                  <p class="mt-3 text-center"><a href="register.php">Chưa có tài khoản? Đăng ký tại đây</a></p>
             </div>
           </div>
       </div>
        <?php include 'inc/footer.php'; ?>
       <?php include 'inc/floating-buttons.php'; ?>
       <?php include 'inc/scripts.php'; ?>
    </body>