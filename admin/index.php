<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="assets/css/custom.css" rel="stylesheet" />
  <link href="assets/css/admin.css" rel="stylesheet" />

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand " href="index.php"><img
          src="https://dn5sao.edu.vn/datafiles/34/default/icon/17107506615320_Dn5sao-R.png" alt="..."
          style="height: 3.5rem;" /></a>
      <div class="ms-auto">
        <?php if (isset($_SESSION['username'])) : ?>
          <li class="nav-item dropdown" style="list-style:none;">
            <a class="nav-link dropdown-toggle btn btn-outline-light" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">
              <i class="fas fa-user"></i> Xin chào, <?php echo $_SESSION['username']; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="../logout.php">Đăng xuất</a></li>
            </ul>
          </li>
        <?php else: ?>
          <a class="btn btn-outline-light" href="../login.php">Đăng nhập</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
  <div class="container-fluid mt-4">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#users" data-bs-toggle="tab">
                <i class="fas fa-users"></i> Quản lý người dùng
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#recruits" data-bs-toggle="tab">
                <i class="fas fa-newspaper"></i> Quản lý tin tuyển dụng
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#blogs" data-bs-toggle="tab">
                <i class="fas fa-blog"></i> Quản lý Blog
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">




        <div class="tab-content">

          <!-- Quan ly user -->
          <div class="tab-pane fade show active" id="users">
            <h3>Quản lý người dùng</h3>
            <p>Danh sách người dùng</p>

            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Thêm người dùng</button>

            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tên tài khoản</th>
                  <th>Email</th>
                  <th>Số điện thoại</th>
                  <th>Role</th>
                  <th>Ngày tạo</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include "../inc/db-connect.inc.php";
                $query = "SELECT * FROM users";
                try {
                  $stmt = $pdo->query($query);
                  while ($user = $stmt->fetch()) {
                ?>
                    <tr>
                      <td><?php echo $user['id'] ?></td>
                      <td><?php echo $user['username'] ?></td>
                      <td><?php echo $user['email'] ?></td>
                      <td><?php echo $user['phone'] ?></td>
                      <td><?php echo $user['role'] ?></td>
                      <td><?php echo $user['create_at'] ?></td>
                      <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="<?php echo $user['id']; ?>" data-username="<?php echo $user['username']; ?>" data-email="<?php echo $user['email']; ?>" data-phone="<?php echo $user['phone'] ?>" data-role="<?php echo $user['role'] ?>">Sửa</button>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-id="<?php echo $user['id'] ?>">Xóa</button>
                      </td>
                    </tr>
                <?php
                  }
                } catch (PDOException $e) {
                  echo "Query failed: " . $e->getMessage();
                }
                ?>
              </tbody>
            </table>
          </div>
          <!-- Modal thêm -->
          <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addUserModalLabel">Thêm người dùng</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="post" action="index.php">
                    <div class="form-group">
                      <label for="username">Tên tài khoản:</label>
                      <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                      <label for="phone">Số điện thoại:</label>
                      <input type="tel" class="form-control" name="phone" required pattern="[0-9]{10,}" title="Số điện thoại phải có ít nhất 10 chữ số và chỉ bao gồm chữ số.">
                    </div>
                    <div class="form-group">
                      <label for="password">Mật khẩu:</label>
                      <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                      <label for="role">Role:</label>
                      <select class="form-control" name="role">
                        <option value="USER">User</option>
                        <option value="ADMIN">Admin</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal chỉnh sửa -->
          <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editUserModalLabel">Sửa người dùng</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="post" action="admin/index.php">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                      <label for="edit_username">Tên tài khoản:</label>
                      <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    <div class="form-group">
                      <label for="edit_email">Email:</label>
                      <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="form-group">
                      <label for="edit_phone">Số điện thoại:</label>
                      <input type="tel" class="form-control" id="edit_phone" name="phone" required pattern="[0-9]{10,}" title="Số điện thoại phải có ít nhất 10 chữ số và chỉ bao gồm chữ số.">
                    </div>
                    <div class="form-group">
                      <label for="edit_role">Role:</label>
                      <select class="form-control" name="role" id="edit_role">
                        <option value="USER">User</option>
                        <option value="ADMIN">Admin</option>
                      </select>
                    </div>

                    <button type="submit" class="btn btn-primary" name="update_user">Cập nhật</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal xóa -->
          <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteUserModalLabel">Xóa người dùng</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Bạn có chắc chắn muốn xóa người dùng này?</p>
                </div>
                <div class="modal-footer">
                  <form method="post" action="admin/index.php">
                    <input type="hidden" name="id" id="delete_id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger" name="delete_user">Xóa</button>
                  </form>
                </div>
              </div>
            </div>
          </div>





          <div class="tab-pane fade" id="recruits">
            <h3>Quản lý tin tuyển dụng</h3>
            <p>Danh sách tin tuyển dụng</p>
          </div>






          <div class="tab-pane fade" id="blogs">
            <h3>Quản lý blog</h3>
            <p>Danh sách blog</p>
          </div>
        </div>
      </main>

    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



  <!-- Script cho chuc nang quan ly nguoi dung -->
  <script>
    document.getElementById('phone').addEventListener('input', function(e) {
      this.value = this.value.replace(/[^0-9]/g, ''); // Chỉ cho phép nhập số
      if (this.value.length < 10) {
        this.setCustomValidity("Số điện thoại phải có ít nhất 10 chữ số");
      } else {
        this.setCustomValidity("");
      }
    });
    // Lấy thông tin user để sửa
    var editUserModal = document.getElementById('editUserModal');
    editUserModal.addEventListener('show.bs.modal', function(event) {
      var button = event.relatedTarget;
      var id = button.getAttribute('data-id');
      var username = button.getAttribute('data-username');
      var email = button.getAttribute('data-email');
      var phone = button.getAttribute('data-phone');
      var role = button.getAttribute('data-role');

      var idInput = editUserModal.querySelector('#edit_id');
      var usernameInput = editUserModal.querySelector('#edit_username');
      var emailInput = editUserModal.querySelector('#edit_email');
      var phoneInput = editUserModal.querySelector('#edit_phone');
      var roleInput = editUserModal.querySelector('#edit_role');
      idInput.value = id;
      usernameInput.value = username;
      emailInput.value = email;
      phoneInput.value = phone;
      roleInput.value = role;
    });
    // Lấy thông tin id để xóa
    var deleteUserModal = document.getElementById('deleteUserModal');
    deleteUserModal.addEventListener('show.bs.modal', function(event) {
      var button = event.relatedTarget;
      var id = button.getAttribute('data-id');
      var idInput = deleteUserModal.querySelector('#delete_id');
      idInput.value = id;
    });
    document.querySelectorAll('.modal input[type="tel"]').forEach(function(input) {
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



</html>