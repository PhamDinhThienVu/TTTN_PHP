<?php
include "inc/db-connect.inc.php";
?>



<!-- RecruitmentRecruitment -->
<section class="page-section" id="recruit">
  <div class="container">
    <div class="text-center">
      <h2 class="section-heading text-uppercase">Tin tuyển dụng và du học</h2>
      <h3 class="section-subheading text-muted">Một số tin tức tuyển dụng và du học được chúng tôi cập nhất mới nhất cho quý khách hàng</h3>
    </div>

    <div id="content">
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
    </div>
  </div>

</section>
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