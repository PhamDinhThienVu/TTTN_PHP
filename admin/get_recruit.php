<?php
include "../inc/db-connect.inc.php";

header('Content-Type: application/json');

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM recruits WHERE id = ?";
  try {
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $recruit = $stmt->fetch();
    if ($recruit) {
      echo json_encode($recruit);
    } else {
      echo json_encode(['error' => 'Không tìm thấy tin tuyển dụng']);
    }
  } catch (PDOException $e) {
    echo json_encode(['error' => 'Lỗi: ' . $e->getMessage()]);
  }
} else {
    echo json_encode(['error' => 'Không có ID được cung cấp']);
}
?>