<?php
session_start();
include "../inc/db-connect.inc.php";

function handle_error($message, $type = 'danger') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}

function validate_input($input) {
  return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_recruit']) && isset($_POST['id'])) {
        $id = $_POST['id'];
        $title = validate_input($_POST['title']);
        $content = $_POST['content'];
        if (empty($title) || empty($content)) {
            handle_error('Tiêu đề và nội dung không được để trống.');
            header("Location: recruit.edit.php?id=" . $id);
            exit();
        }
        $query = "UPDATE recruits SET title = ?, content = ? WHERE id = ?";
        try {
          $stmt = $pdo->prepare($query);
          $stmt->execute([$title, $content, $id]);
            $_SESSION['message'] = 'Cập nhật tin tuyển dụng thành công.';
            $_SESSION['message_type'] = 'success';
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Lỗi: ' . htmlspecialchars($e->getMessage());
            $_SESSION['message_type'] = 'danger';
        }
      }
}
header("Location: index.php");
exit();
?>