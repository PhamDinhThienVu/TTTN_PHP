<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login.php');
  exit();
}
if (isset($_GET['id'])) {
  include "../inc/db-connect.inc.php";
  $id = $_GET['id'];
  $query = "DELETE FROM recruits WHERE id = ?";
  try {
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    echo '<div class="alert alert-success mt-3" role="alert">
                 Xóa Bài viết thành công.
            </div>';
  } catch (PDOException $e) {
    echo '<div class="alert alert-danger mt-3" role="alert">
            Lỗi: ' . htmlspecialchars($e->getMessage()) . '
             </div>';
  }
}
header('Location: index.php'); // Chuyển hướng trở lại trang admin
exit();
