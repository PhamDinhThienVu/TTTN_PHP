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
  $queryEdit = "SELECT * FROM recruits where id = ?";
  try {
    $stmtEdit = $pdo->prepare($queryEdit);
    $stmtEdit->execute([$id]);
    $recruitEdit = $stmtEdit->fetch();
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
        <h2>Sửa tin tuyển dụng</h2>
        <form method="post" action="recruit_edit_process.php">
          <input type="hidden" name="id" value="<?php echo htmlspecialchars($recruitEdit['id']) ?>">
          <div class="form-group">
            <label for="edit_title">Tên bài viết:</label>
            <input type="text" class="form-control" id="edit_title" name="title"
              value="<?php echo htmlspecialchars($recruitEdit['title']) ?>">
          </div>
          <div class="form-group">
            <label for="edit_editor">Nội dung:</label>
            <textarea class="form-control" id="edit_editor"
              name="content"><?php echo htmlspecialchars($recruitEdit['content']) ?></textarea>
          </div>

          <button type="submit" class="btn btn-primary" name="update_recruit">Cập nhật</button>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
  <script>
    ClassicEditor
      .create(document.querySelector('#edit_editor'))
      .catch(error => {
        console.error(error);
      });
  </script>
</body>
</body>