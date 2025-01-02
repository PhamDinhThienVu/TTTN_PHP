<?php
include('inc/head.php');
?>

<body id="page-top">
<link href="css/register.css" rel="stylesheet" />
  <?php include 'inc/nav.php'; ?>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <h2>Đăng ký</h2>
        <form method="post" action="register.php">
          <div class="form-group">
            <label for="username">Tên tài khoản:</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="phone">Số điện thoại:</label>
            <input type="tel" class="form-control" id="phone" name="phone" required pattern="[0-9]{10,}"  title="Số điện thoại phải có ít nhất 10 chữ số và chỉ bao gồm chữ số.">
          </div>
          <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary">Đăng ký</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          include "inc/db-connect.inc.php"; // Include the database connection file
          $username = $_POST['username'];
          $email = $_POST['email'];
          $phone = $_POST['phone'];
          $password = $_POST['password'];
          $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
          $query = "INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)";

          try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([$username, $email, $phone, $hashedPassword]);
            echo '<div class="alert alert-success mt-3" role="alert">
                                 Đăng ký thành công. Vui lòng đăng nhập
                             </div>';
          } catch (PDOException $e) {
            echo '<div class="alert alert-danger mt-3" role="alert">
                                 Lỗi: ' . htmlspecialchars($e->getMessage()) . '
                             </div>';
          }
        }
        ?>
      </div>
    </div>
  </div>
  <?php include 'inc/footer.php'; ?>
  <?php include 'inc/floating-buttons.php'; ?>
  <?php include 'inc/scripts.php'; ?>
</body>