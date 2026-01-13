<?php
// memulai session atau melanjutkan session yang sudah ada
session_start();

include "koneksi.php";

// check jika belum ada user yang login arahkan ke halaman login
if (!isset($_SESSION['username'])) {
  header("location:login.php");
  exit();
}

// Ambil foto profil user
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT foto FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$foto_profil = $user_data['foto'] ?? '';
$stmt->close();

// halaman aktif
$page = $_GET['page'] ?? 'dashboard';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | My Daily Journal</title>
  <link rel="icon" type="image/png" href="img/logo.png">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- 1) Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

  <!-- Bootstrap Icons (untuk footer icon) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />

  <!-- 5) Sticky footer style -->
  <style>
    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    #content {
      flex: 1;
    }
    .user-avatar {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 5px;
      border: 2px solid #fff;
    }
  </style>
</head>

<body>

  <!-- 2) nav begin -->
  <nav class="navbar navbar-expand-sm bg-body-tertiary sticky-top" style="background-color:#a58cff !important;">
    <div class="container">
      <a class="navbar-brand fw-semibold text-dark" target="_blank" href="index.php">My Daily Journal</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">

          <!-- 6) menu dashboard + article + gallery -->
          <li class="nav-item">
            <a class="nav-link <?= ($page === 'dashboard') ? 'fw-bold text-dark' : 'text-dark' ?>"
               href="admin.php?page=dashboard">
              Dashboard
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($page === 'article') ? 'fw-bold text-dark' : 'text-dark' ?>"
               href="admin.php?page=article">
              Article
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($page === 'gallery') ? 'fw-bold text-dark' : 'text-dark' ?>"
               href="admin.php?page=gallery">
              Gallery
            </a>
          </li>

          <!-- Username dropdown dengan foto profil -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
              <?php
              // Tampilkan foto profil jika ada
              if (!empty($foto_profil) && file_exists('img/' . $foto_profil)) {
                  echo '<img src="img/' . htmlspecialchars($foto_profil) . '" alt="Avatar" class="user-avatar">';
              } else {
                  echo '<i class="bi bi-person-circle"></i> ';
              }
              echo htmlspecialchars($_SESSION['username']);
              ?>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="admin.php?page=profile">
                  <i class="bi bi-person-circle"></i> Profile
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item" href="logout.php">
                  <i class="bi bi-box-arrow-right"></i> Logout
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </div>
  </nav>
  <!-- nav end -->

  <!-- 3) content begin -->
  <section id="content" class="p-5">
    <div class="container">

      <?php
      if (isset($_GET['page'])) {
          $page = $_GET['page'];
      } else {
          $page = "dashboard";
      }

      // Capitalize first letter untuk judul halaman
      $page_title = ucfirst($page);
      echo '<h4 class="lead display-6 pb-2 border-bottom border-danger-subtle">' . $page_title . '</h4>';
      
      // Include file sesuai page
      if (file_exists($page . ".php")) {
          include($page . ".php");
      } else {
          echo '<div class="alert alert-danger mt-3">';
          echo '<i class="bi bi-exclamation-triangle"></i> Halaman tidak ditemukan!';
          echo '</div>';
      }
      ?>

    </div>
  </section>
  <!-- content end -->

  <!-- 4) footer begin -->
  <footer class="text-center p-3" style="background-color:#a58cff !important;">
    <div>
      <a href="https://www.instagram.com/udinusofficial" target="_blank" rel="noopener">
        <i class="bi bi-instagram h2 p-2 text-dark"></i>
      </a>
      <a href="https://twitter.com/udinusofficial" target="_blank" rel="noopener">
        <i class="bi bi-twitter h2 p-2 text-dark"></i>
      </a>
      <a href="https://wa.me/+62812685577" target="_blank" rel="noopener">
        <i class="bi bi-whatsapp h2 p-2 text-dark"></i>
      </a>
    </div>
    <small class="text-muted">© 2026 My Daily Journal</small>
  </footer>
  <!-- footer end -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
          crossorigin="anonymous"></script>
</body>
</html>