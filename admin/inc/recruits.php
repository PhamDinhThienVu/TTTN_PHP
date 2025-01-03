<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>

<h3>Quản lý tin tuyển dụng</h3>
<p>Danh sách tin tuyển dụng</p>
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addRecruitModal">Thêm tin tuyển dụng</button>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include "../inc/db-connect.inc.php";
  // Xử lý thêm tin tuyển dụng
  if (isset($_POST['title']) && isset($_POST['content'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $query = "INSERT INTO recruits (title, content) VALUES (?, ?)";
    try {
      $stmt = $pdo->prepare($query);
      $stmt->execute([$title, $content]);
      echo '<div class="alert alert-success mt-3" role="alert">
                             Thêm tin tuyển dụng thành công.
                         </div>';
    } catch (PDOException $e) {
      echo '<div class="alert alert-danger mt-3" role="alert">
                             Lỗi: ' . htmlspecialchars($e->getMessage()) . '
                         </div>';
    }
  }
  if (isset($_POST['update_recruit']) && isset($_POST['id']) && isset($_POST['title'])  && isset($_POST['content'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $query = "UPDATE recruits SET title = ?, content = ? WHERE id = ?";
    try {
      $stmt = $pdo->prepare($query);
      $stmt->execute([$title, $content, $id]);
      echo '<div class="alert alert-success mt-3" role="alert">
                             Cập nhật tin tuyển dụng thành công.
                         </div>';
    } catch (PDOException $e) {
      echo '<div class="alert alert-danger mt-3" role="alert">
                                 Lỗi: ' . htmlspecialchars($e->getMessage()) . '
                              </div>';
    }
  }
  if (isset($_POST['delete_recruit']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM recruits WHERE id = ?";
    try {
      $stmt = $pdo->prepare($query);
      $stmt->execute([$id]);
      echo '<div class="alert alert-success mt-3" role="alert">
                                   Xóa tin tuyển dụng thành công.
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
      <th>Tiêu đề</th>
      <th>Ngày tạo</th>
      <th>Thao tác</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $per_page = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page - 1) * $per_page;
    $query = "SELECT * FROM recruits LIMIT $start, $per_page";
    try {
      $stmt = $pdo->query($query);
      while ($recruit = $stmt->fetch()) {
    ?>
        <tr>
          <td><?php echo $recruit['id'] ?></td>
          <td><?php echo $recruit['title'] ?></td>
          <td><?php echo $recruit['create_at'] ?></td>
          <td>
          <button class="btn btn-sm btn-info view-recruit-btn" data-id="<?php echo $recruit['id']; ?>" data-bs-toggle="modal" data-bs-target="#viewRecruitModal">Xem chi tiết</button>
            <button class="btn btn-sm btn-warning" onclick="window.location.href='recruit.edit.php?id=<?php echo $recruit['id']; ?>'">Sửa</button>
            <a class="btn btn-sm btn-danger" onclick="confirmDelete(event)" href="recruit.delete.php?id=<?php echo $recruit['id'] ?>">Xóa</a>
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
    $queryCount = "SELECT COUNT(*) AS total FROM recruits";
    try {
      $stmtCount = $pdo->query($queryCount);
      $totalRecruits = $stmtCount->fetch()['total'];
      $totalPages = ceil($totalRecruits / $per_page);
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
</div>
<!-- Modal thêm -->
<div class="modal fade" id="addRecruitModal" tabindex="-1" aria-labelledby="addRecruitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addRecruitModalLabel">Thêm tin tuyển dụng</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="index.php">
          <div class="form-group">
            <label for="title">Tiêu đề:</label>
            <input type="text" class="form-control" name="title" required>
          </div>
          <div class="form-group">
            <label for="content">Nội dung:</label>
            <textarea class="form-control" id="editor" name="content"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal xem chi tiết -->
<div class="modal fade" id="viewRecruitModal" tabindex="-1" aria-labelledby="viewRecruitModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="viewRecruitModalLabel">Chi tiết tin tuyển dụng</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body" id="viewRecruitContent">

           </div>
       </div>
   </div>
 </div>

<!-- Modal chỉnh sửa -->
<div class="modal fade" id="editRecruitModal" tabindex="-1" aria-labelledby="editRecruitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRecruitModalLabel">Sửa tin tuyển dụng</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="index.php">
          <?php
          if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $queryEdit = "SELECT * FROM recruits WHERE id = ?";
            try {
              $stmtEdit = $pdo->prepare($queryEdit);
              $stmtEdit->execute([$id]);
              $recruitEdit = $stmtEdit->fetch();
          ?>
              <input type="hidden" name="id" value="<?php echo $recruitEdit['id'] ?>">
              <div class="form-group">
                <label for="title">Tiêu đề:</label>
                <input type="text" class="form-control" name="title" value="<?php echo $recruitEdit['title'] ?>" required>
              </div>
              <div class="form-group">
                <label for="content">Nội dung:</label>
                <textarea class="form-control" id="edit_editor" name="content" required><?php echo $recruitEdit['content'] ?></textarea>
              </div>
          <?php

            } catch (PDOException $e) {
              echo '<div class="alert alert-danger mt-3" role="alert">
                                   Lỗi: ' . htmlspecialchars($e->getMessage()) . '
                              </div>';
            }
          }
          ?>
          <button type="submit" class="btn btn-primary" name="update_recruit">Cập nhật</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal xóa -->
<div class="modal fade" id="deleteRecruitModal" tabindex="-1" aria-labelledby="deleteRecruitModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteRecruitModalLabel">Xóa tin tuyển dụng</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Bạn có chắc chắn muốn xóa tin tuyển dụng này?</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="admin/index.php">
          <input type="hidden" name="id" id="delete_id">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-danger" name="delete_recruit">Xóa</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const deleteButtons = document.querySelectorAll('.delete-recruit-btn');
  deleteButtons.forEach(button => {
    button.addEventListener('click', function(event) {
      const recruitId = this.getAttribute('data-id');
      if (confirm('Bạn có chắc chắn muốn xóa tin tuyển dụng này?')) {
        window.location.href = 'user.delete.php?id=' + recruitId;
      }
    });
  });
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
<script>
  let editorInstance;

  ClassicEditor
    .create(document.querySelector('#editor'))
    .then(editor => {
      editorInstance = editor;
    })
    .catch(error => {
      console.error(error);
    });

  // Đồng bộ nội dung CKEditor khi gửi form
  document.querySelector('form').addEventListener('submit', () => {
    document.querySelector('#editor').value = editorInstance.getData();
  });

  let editEditorInstance;

  ClassicEditor
    .create(document.querySelector('#edit_editor'))
    .then(editor => {
      editEditorInstance = editor;
    })
    .catch(error => {
      console.error(error);
    });

  // Đồng bộ nội dung CKEditor trong modal sửa khi gửi form
  document.querySelector('form[action="admin/index.php"]').addEventListener('submit', () => {
    document.querySelector('#edit_editor').value = editEditorInstance.getData();
  });



  function loadEditRecruit(id) {
    fetch(`get_recruit.php?id=${id}`)
      .then(response => response.json())
      .then(data => {
        document.querySelector('#edit_editor').value = data.content;
        document.querySelector('input[name="id"]').value = data.id;
        document.querySelector('input[name="title"]').value = data.title;
        editEditorInstance.setData(data.content); // Đồng bộ nội dung CKEditor
      })
      .catch(error => {
        console.error('Error fetching recruit data:', error);
      });
  }

  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', () => {
      const editors = document.querySelectorAll('.ck-editor__editable');
      editors.forEach(editorDiv => {
        const textarea = editorDiv.closest('.form-group').querySelector('textarea');
        const editorInstance = ClassicEditor.instances[textarea.id];
        textarea.value = editorInstance.getData(); // Đồng bộ dữ liệu
      });
    });
  });

  document.querySelector('form').addEventListener('submit', function(event) {
    const editorContent = editorInstance.getData().trim(); // Lấy nội dung từ CKEditor
    if (!editorContent) {
      alert('Vui lòng nhập nội dung.');
      event.preventDefault(); // Ngăn form submit
    } else {
      document.querySelector('#editor').value = editorContent; // Đồng bộ dữ liệu vào textarea
    }
  });

  function confirmDelete(event) {
    const confirmation = confirm("Bạn có chắc chắn muốn xóa không?");
    if (!confirmation) {
      event.preventDefault(); // Ngăn chặn hành động xóa nếu người dùng chọn 'Hủy'
    }
  }
</script>
<script>
     const viewButtons = document.querySelectorAll('.view-recruit-btn');
     viewButtons.forEach(button => {
     button.addEventListener('click', function(event) {
     const recruitId = this.getAttribute('data-id');
     fetch(`get_recruit.php?id=${recruitId}`)
     .then(response => response.json())
     .then(data => {
         const viewRecruitContent = document.querySelector('#viewRecruitContent');
         viewRecruitContent.innerHTML = data.content;
     })
         .catch(error => {
           console.error('Error fetching recruit data:', error);
         });
     });
 });
 </script>