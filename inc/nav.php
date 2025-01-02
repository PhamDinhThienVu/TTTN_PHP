
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand " href="index.php"><img
                src="https://dn5sao.edu.vn/datafiles/34/default/icon/17107506615320_Dn5sao-R.png" alt="..."
                style="height: 3.5rem;" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php#about">VỀ DOANH NGHIỆP</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#services">DỊCH VỤ</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#recruit">TIN TUYỂN DỤNG</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#team">ĐỘI NGŨ</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#contact">THÔNG TIN LIÊN HỆ</a></li>
                    <?php if (isset($_SESSION['username'])) : ?>
                     <li class="nav-item dropdown">
                       <a class="nav-link dropdown-toggle auth-button"  role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">
                            <i class="fas fa-user"></i> Xin chào, <?php echo $_SESSION['username']; ?>
                       </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                        </ul>
                    </li>
                   <?php else : ?>
                     <li class="nav-item">
                         <a class="nav-link auth-button" href="login.php">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                           </a>
                      </li>
                 <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>