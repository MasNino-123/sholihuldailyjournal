<?php
// memulai session atau melanjutkan session yang sudah ada
session_start();

include "koneksi.php";

// check jika belum ada user yang login arahkan ke halaman login
if (!isset($_SESSION['username'])) {
  header("location:login.php");
  exit();
}

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

          <!-- 6) menu dashboard + article -->
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

          <!-- Username dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
              <?= htmlspecialchars($_SESSION['username']); ?>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
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

            echo '<h4 class="lead display-6 pb-2 border-bottom border-danger-subtle">' . $page . '</h4>';
            include($page . ".php");
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
    <div>Aprilyani Nur Safitri &copy; 2023</div>
  </footer>
  <!-- footer end -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
          crossorigin="anonymous"></script>
</body>
</html>
