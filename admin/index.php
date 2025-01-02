<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}
 include "../inc/db-connect.inc.php"; // Include the database connection file

?>

<!DOCTYPE html>
<html lang="en">
<?php include 'inc/head.php'; ?>
<body id="page-top">
    <?php include 'inc/nav.php'; ?>
   <div class="container-fluid mt-4">
        <div class="row">
            <?php include 'inc/sidebar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="tab-content">
                   <?php include 'inc/users.php'; ?>
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
    <?php include 'inc/scripts.php'; ?>
</body>
</html>