<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login.php');
  exit();
}
include('inc/head.php');
include "../inc/db-connect.inc.php";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $queryEdit = "SELECT * FROM users where id = ?";
  try {
    $stmtEdit = $pdo->prepare($queryEdit);
    $stmtEdit->execute([$id]);
    $userEdit = $stmtEdit->fetch();
  } catch (PDOException $e) {
    echo '<div class="alert alert-danger mt-3" role="alert">
                             Lỗi: ' . htmlspecialchars($e->getMessage()) . '
                         </div>';
  }
} else {
  header('Location: index.php');
  exit();
}

?>


<body id="page-top">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">Admin Panel</a>
      <div class="ms-auto">
        <a class="btn btn-outline-light" href="../logout.php">Đăng xuất</a>
      </div>
    </div>
  </nav>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <h2>Sửa người dùng</h2>
        <form method="post" action="index.php">
          <input type="hidden" name="id" id="edit_id" value="<?php echo $userEdit['id'] ?>">
          <div class="form-group">
            <label for="edit_username">Tên tài khoản:</label>
            <input type="text" class="form-control" id="edit_username" name="username" value="<?php echo $userEdit['username'] ?>" required>
          </div>
          <div class="form-group">
            <label for="edit_email">Email:</label>
            <input type="email" class="form-control" id="edit_email" name="email" value="<?php echo $userEdit['email'] ?>" required>
          </div>
          <div class="form-group">
            <label for="edit_phone">Số điện thoại:</label>
            <input type="tel" class="form-control" id="edit_phone" name="phone" value="<?php echo $userEdit['phone'] ?>" required pattern="[0-9]{10,}" title="Số điện thoại phải có ít nhất 10 chữ số và chỉ bao gồm chữ số.">
          </div>
          <div class="form-group">
            <label for="edit_role">Role:</label>
            <select class="form-control" name="role" id="edit_role">
              <option value="USER" <?php if ($userEdit['role'] == 'USER') echo 'selected'; ?>>User</option>
              <option value="ADMIN" <?php if ($userEdit['role'] == 'ADMIN') echo 'selected'; ?>>Admin</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary" name="update_user">Cập nhật</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user']) && isset($_POST['id']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['role'])) {
          $id = $_POST['id'];
          $username = $_POST['username'];
          $email = $_POST['email'];
          $phone = $_POST['phone'];
          $role = $_POST['role'];
          $query = "UPDATE users SET username = ?, email = ?, phone = ?, role = ? WHERE id = ?";
          try {
            $stmt = $pdo->prepare($query);
            $stmt->execute([$username, $email, $phone, $role, $id]);
            echo '<div class="alert alert-success mt-3" role="alert">
Cập nhật người dùng thành công.
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.querySelectorAll('input[type="tel"]').forEach(function(input) {
      input.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length < 10) {
          this.setCustomValidity("Số điện thoại phải có ít nhất 10 chữ số");
        } else {
          this.setCustomValidity("");
        }
      });
    });
  </script>
  </body>