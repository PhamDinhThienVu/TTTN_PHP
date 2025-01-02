<nav class="navbar navbar-expand-lg bg-white">
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
      <?php else : ?>
        <a class="btn btn-outline-light" href="../login.php">Đăng nhập</a>
      <?php endif; ?>
    </div>
  </div>
</nav>