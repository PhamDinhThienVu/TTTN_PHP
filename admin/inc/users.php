
  <h3>Quản lý người dùng</h3>
  <p>Danh sách người dùng</p>


  <form method="get" action="index.php" class="mb-3">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Tìm kiếm theo tên hoặc email" name="search"  value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
             <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
           </div>
       </form>

  <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Thêm người dùng</button>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../inc/db-connect.inc.php";
    // Xử lý thêm user
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['role'])) {
      $username = $_POST['username'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $password = $_POST['password'];
      $role = $_POST['role'];
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $query = "INSERT INTO users (username, email,phone, password, role) VALUES (?, ?, ?, ?, ?)";
      try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username, $email, $phone, $hashedPassword, $role]);
        echo '<div class="alert alert-success mt-3" role="alert">
                       Thêm người dùng thành công.
                     </div>';
      } catch (PDOException $e) {
        echo '<div class="alert alert-danger mt-3" role="alert">
                               Lỗi: ' . htmlspecialchars($e->getMessage()) . '
                         </div>';
      }
    }
    if (isset($_POST['update_user']) && isset($_POST['id']) && isset($_POST['username'])  && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['role'])) {
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
    if (isset($_POST['delete_user']) && isset($_POST['id'])) {
      $id = $_POST['id'];
      $query = "DELETE FROM users WHERE id = ?";
      try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        echo '<div class="alert alert-success mt-3" role="alert">
                                Xóa người dùng thành công.
                            </div>';
      } catch (PDOException $e) {
        echo '<div class="alert alert-danger mt-3" role="alert">
                                 Lỗi: ' . htmlspecialchars($e->getMessage()) . '
                               </div>';
      }
    }
  }
  ?>
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
      $per_page = 10;
      $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $start = ($page - 1) * $per_page;
      $query = "SELECT * FROM users LIMIT $start, $per_page";

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
              <button class="btn btn-sm btn-warning" onclick="window.location.href='user.edit.php?id=<?php echo $user['id']; ?>'">Sửa</button>


              <a class="btn btn-sm btn-danger" onclick="confirmDelete(event)" href="user.delete.php?id=<?php echo $user['id'] ?>">Xóa</a>
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
  <!-- Phân trang -->
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
      <?php
      $queryCount = "SELECT COUNT(*) AS total FROM users";
      try {
        $stmtCount = $pdo->query($queryCount);
        $totalUsers = $stmtCount->fetch()['total'];
        $totalPages = ceil($totalUsers / $per_page);
        if ($totalPages > 1) {
          for ($i = 1; $i <= $totalPages; $i++) {
            echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
          }
        }
      } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
      }
      ?>
    </ul>
  </nav>
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



  <script>
    document.getElementById('phone').addEventListener('input', function(e) {
      this.value = this.value.replace(/[^0-9]/g, '');
      if (this.value.length < 10) {
        this.setCustomValidity("Số điện thoại phải có ít nhất 10 chữ số");
      } else {
        this.setCustomValidity("");
      }
    });



    function confirmDelete(event) {
      const confirmation = confirm("Bạn có chắc chắn muốn xóa không?");
      if (!confirmation) {
        event.preventDefault(); // Ngăn chặn hành động xóa nếu người dùng chọn 'Hủy'
      }
    }
  </script>
