<?php
include "koneksi.php";
$query = mysqli_query($conn, "SELECT * FROM article ORDER BY tanggal DESC");

if (!$query) {
  die("Query error: " . mysqli_error($conn));
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jurnal Sholihul</title>
    <link rel="icon" type="image/png" href="img/Logoo.jpg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
      
      #galery .bg-white img {
        height: 220px;
        width: 100%;
        object-fit: cover;
        display: block;
      }

     
      #galery .bg-white {
        height: 224px; 
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
      }

      
      #galleryModalImg {
        max-height: 80vh;
        object-fit: contain;
        width: auto;
        display: block;
        margin-left: auto;
        margin-right: auto;
      }
      
      html { scroll-behavior: smooth; }

     
      .navbar.sticky-top { z-index: 1030; }
      
      .navbar-brand img { height: 36px; width: auto; display: inline-block; }
       .accordion-button:not(.collapsed),
      .accordion-button:active,
      .accordion-button:focus {
        background-color: #162ec5ff; 
        color: #fff;
        box-shadow: none;
      }
      .accordion-button:not(.collapsed)::after {
        filter: invert(1) saturate(8) hue-rotate(-10deg);
      }
      .accordion-button {
        transition: background-color .15s ease, color .15s ease;
      }

      /* Scroll to Top Button */
      #scrollToTopBtn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background-color: #162ec5ff;
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        transition: background-color 0.3s ease, opacity 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      }

      #scrollToTopBtn:hover {
        background-color: #162ec5ff;
      }

      #scrollToTopBtn.show {
        display: flex;
      }

      /* Dark Mode CSS */
      :root {
        --bg-light: #ffffff;
        --text-light: #000000;
        --card-light: #ffffff;
        --section-light: #f8f9fa;
        --navbar-light: #ffffff;
        --border-light: #dee2e6;
      }

      body.dark-mode {
        --bg-light: #1a1a1a;
        --text-light: #ffffff;
        --card-light: #2d2d2d;
        --section-light: #222222;
        --navbar-light: #2d2d2d;
        --border-light: #444444;
      }

      body {
        background-color: var(--bg-light);
        color: var(--text-light);
        transition: background-color 0.3s ease, color 0.3s ease;
      }

      /* Navbar Dark Mode */
      body.dark-mode .navbar {
        background-color: var(--navbar-light) !important;
        border-bottom-color: var(--border-light) !important;
      }

      body.dark-mode .navbar-light .navbar-brand {
        color: var(--text-light) !important;
      }

      body.dark-mode .navbar-light .nav-link {
        color: var(--text-light) !important;
      }

      body.dark-mode .navbar-light .nav-link:hover {
        color: #162ec5ff !important;
      }

      /* Card Dark Mode */
      body.dark-mode .card {
        background-color: var(--card-light) !important;
        border-color: var(--border-light) !important;
        color: var(--text-light) !important;
      }

      body.dark-mode .card-body {
        color: var(--text-light) !important;
      }

      /* Section Dark Mode */
      body.dark-mode #article {
        background-color: var(--section-light) !important;
      }

      body.dark-mode #About\ me {
        background-color: var(--section-light) !important;
      }

      /* Text Colors Dark Mode */
      body.dark-mode .text-muted {
        color: #b0b0b0 !important;
      }

      body.dark-mode .text-dark {
        color: var(--text-light) !important;
      }

      body.dark-mode .text-black {
        color: var(--text-light) !important;
      }

      body.dark-mode p {
        color: var(--text-light) !important;
      }

      body.dark-mode span {
        color: var(--text-light) !important;
      }

      body.dark-mode li {
        color: var(--text-light) !important;
      }

      body.dark-mode small {
        color: var(--text-light) !important;
      }

      body.dark-mode label {
        color: var(--text-light) !important;
      }

      body.dark-mode button {
        color: var(--text-light) !important;
      }

      /* Footer Dark Mode */
      body.dark-mode footer {
        background-color: var(--navbar-light) !important;
        border-top: 1px solid var(--border-light);
      }

      body.dark-mode footer .text-dark {
        color: var(--text-light) !important;
      }

      /* Theme Toggle Button */
      .theme-toggle {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 24px;
        padding: 8px 12px;
        transition: transform 0.3s ease;
        color: var(--text-light);
      }

      .theme-toggle:hover {
        transform: scale(1.2);
      }

      .theme-toggle-container {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-left: 20px;
      }

      /* Accordion Dark Mode */
      body.dark-mode .accordion-item {
        border-color: var(--border-light) !important;
        background-color: var(--card-light) !important;
      }

      body.dark-mode .accordion-button {
        background-color: var(--card-light) !important;
        color: var(--text-light) !important;
        border-color: var(--border-light) !important;
      }

      /* Dark Mode - Text Color Override */
      body.dark-mode .text-dark {
        color: var(--text-light) !important;
      }

      body.dark-mode .text-black {
        color: var(--text-light) !important;
      }

      body.dark-mode p {
        color: var(--text-light) !important;
      }

      body.dark-mode span {
        color: var(--text-light) !important;
      }

      body.dark-mode li {
        color: var(--text-light) !important;
      }

      body.dark-mode small {
        color: var(--text-light) !important;
      }

      body.dark-mode label {
        color: var(--text-light) !important;
      }

      body.dark-mode button {
        color: var(--text-light) !important;
      }

      /* Gallery section dark mode text */
      body.dark-mode #galery h2 {
        color: var(--text-light) !important;
      }

      body.dark-mode #galery p {
        color: var(--text-light) !important;
      }

      /* Hero section text dark mode */
      body.dark-mode #hero {
        background-color: #162ec5ff !important;
      }

      body.dark-mode #hero h1,
      body.dark-mode #hero p {
        color: #ffffff !important;
      }

      /* Gallery section dark mode */
      body.dark-mode #galery {
        background-color: #162ec5ff !important;
      }

      body.dark-mode #galery h2,
      body.dark-mode #galery p {
        color: #ffffff !important;
      }

      /* Schedule section icons dark mode */
      body.dark-mode .bi-book,
      body.dark-mode .bi-pencil-square,
      body.dark-mode .bi-people,
      body.dark-mode .bi-bicycle,
      body.dark-mode .bi-film,
      body.dark-mode .bi-bag {
        color: #4967efff !important;
      }

      /* Footer dark mode text */
      body.dark-mode footer a {
        color: var(--text-light) !important;
      }

      body.dark-mode footer small {
        color: #b0b0b0 !important;
      }

      /* Ensure all links are readable */
      body.dark-mode a {
        color: #4967efff !important;
      }

      body.dark-mode a:hover {
        color: #4967efff !important;
      }

      /* About Me - teks putih di dark mode */
      body.dark-mode #About\ me,
      body.dark-mode #About\ me h2,
      body.dark-mode #About\ me .accordion-item,
      body.dark-mode #About\ me .accordion-button,
      body.dark-mode #About\ me .accordion-button.collapsed,
      body.dark-mode #About\ me .accordion-body,
      body.dark-mode #About\ me .accordion-body p,
      body.dark-mode #About\ me .accordion-body strong,
      body.dark-mode #About\ me .accordion-body code,
      body.dark-mode #About\ me .accordion-body .text-muted {
        color: var(--text-light) !important;
      }

      body.dark-mode #About\ me .accordion-button::after {
        filter: invert(1) !important;
      }
    </style>
  </head>
  <body>
    <!-- Nav begin-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom sticky-top">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
          <img src="img/Logoo.jpg" alt="Logo" class="d-inline-block align-text-top me-2">
          <span class="ms-2">Nino</span>
        </a>
        <div class="d-flex align-items-center">
          <!-- Theme Toggle Button -->
          <div class="theme-toggle-container">
            <button id="themeToggle" class="theme-toggle" aria-label="Toggle dark mode">
              <i class="bi bi-moon-fill"></i>
            </button>
          </div>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="#hero">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#article">Article</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#galery">Gallery</a>
              </li>
              <li class ="nav-item">
                <a class="nav-link" href="#schedule">Schedule</a>
              </li>
              <li class ="nav-item">
                <a class="nav-link" href="#About me">About Me</a>
              </li> 
              <li class="nav-item">
                <a class="nav-link" href="login.php".target="_blank">Login</a>
              </li> 
            </ul>
        </div>
      </div>
     </nav>
      <!-- nav end -->
      <!-- hero begin -->
      <section id="hero" class="py-5" style="background-color:#4967efff;">
        <div class="container">
          <div class="row align-items-center g-4">
            <div class="col-md-8 text-center text-md-start">
              <h1 class="display-4 fw-bold lh-1">Sholihul Muayyad A11.2024.15565</h1>
              <p class="lead text-muted mt-4">Saya adalah seorang Kapiten. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit labore nam neque, temporibus blanditiis nulla, sed iusto officiis animi ducimus deleniti consequatur doloribus dolorem quibusdam, numquam soluta dolores tempore. At?</p>
              <!-- Tanggal, Waktu, dan Hari -->
              <div class="mt-4 text-muted small">
                <p id="dayDisplay" class="mb-1"></p>
                <p id="dateDisplay" class="mb-1"></p>
                <p id="timeDisplay" class="mb-0"></p>
              </div>
            </div>
            <div class="col-md-4 text-center">
              <img src="img/Foto_profile.jpeg" alt="Hero photo" class="img-fluid rounded shadow" style="max-height:420px; object-fit:cover;">
            </div>
          </div>
        </div>
      </section>
       <!-- hero end -->
  <!-- article begin -->
<section id="article" class="py-5 bg-body-tertiary">
  <div class="container">
    <h2 class="text-center display-5 fw-bold mb-4">Article</h2>

    <div class="row g-4 justify-content-center">

      <!-- BEGIN ARTICLE -->
      <?php while ($row = mysqli_fetch_assoc($query)) { ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100">

            <img
              src="img/<?php echo $row['gambar']; ?>"
              class="card-img-top"
              alt="<?php echo htmlspecialchars($row['judul']); ?>">

            <div class="card-body text-center">
              <p class="text-muted">Olahraga</p>

              <h5 class="card-title">
                <?php echo htmlspecialchars($row['judul']); ?>
              </h5>

              <p class="card-text">
                <?php echo htmlspecialchars($row['isi']); ?>
              </p>
            </div>

            <div class="card-footer text-center text-muted small">
              <?php echo $row['tanggal']; ?>
            </div>

          </div>
        </div>
      <?php } ?>
      <!-- END ARTICLE -->

    </div>
  </div>
</section>
<!-- article end -->
  <!-- galery begin -->
  <section id="galery" class="py-5" style="background-color:#4967efff;">
    <div class="container">
      <h2 class="text-center display-4 fw-bold text-dark mb-4">Gallery</h2>
      <p class="text-center text-dark mb-4">Galeri saya</p>

      <div class="row g-3">
        <div class="col-6 col-sm-4 col-md-4">
          <button class="btn p-0 border-0 w-100" data-bs-toggle="modal" data-src="img/galeri1.jpg" data-bs-target="#galleryModal">
            <div class="bg-white p-2 rounded shadow-sm">
              <img src="img/galeri1.jpg" alt="gambar" class="img-fluid rounded" loading="lazy">
            </div>
          </button>
        </div>
        <div class="col-6 col-sm-4 col-md-4">
          <button class="btn p-0 border-0 w-100" data-bs-toggle="modal" data-src="img/galeri2.jpg" data-bs-target="#galleryModal">
            <div class="bg-white p-2 rounded shadow-sm">
              <img src="img/galeri2.jpg" alt="gambar" class="img-fluid rounded" loading="lazy">
            </div>
          </button>
        </div>
        <div class="col-6 col-sm-4 col-md-4">
          <button class="btn p-0 border-0 w-100" data-bs-toggle="modal" data-src="img/galeri3.jpg" data-bs-target="#galleryModal">
            <div class="bg-white p-2 rounded shadow-sm">
              <img src="img/galeri3.jpg" alt="gambar" class="img-fluid rounded" loading="lazy">
            </div>
          </button>
        </div>
        <div class="col-6 col-sm-4 col-md-4">
          <button class="btn p-0 border-0 w-100" data-bs-toggle="modal" data-src="img/galeri4.jpg" data-bs-target="#galleryModal">
            <div class="bg-white p-2 rounded shadow-sm">
              <img src="img/galeri4.jpg" alt="gambar" class="img-fluid rounded" loading="lazy">
            </div>
          </button>
        </div>
        <div class="col-6 col-sm-4 col-md-4">
          <button class="btn p-0 border-0 w-100" data-bs-toggle="modal" data-src="img/galeri5.jpg" data-bs-target="#galleryModal">
            <div class="bg-white p-2 rounded shadow-sm">
              <img src="img/galeri5.jpg" alt="gambar" class="img-fluid rounded" loading="lazy">
            </div>
          </button>
        </div>
        <div class="col-6 col-sm-4 col-md-4">
          <button class="btn p-0 border-0 w-100" data-bs-toggle="modal" data-src="img/galeri6.jpg" data-bs-target="#galleryModal">
            <div class="bg-white p-2 rounded shadow-sm">
              <img src="img/galeri6.jpg" alt="gambar" class="img-fluid rounded" loading="lazy">
            </div>
          </button>
        </div>
      </div>
    </div>
  </section>
  <!-- galery end -->
  <!--Schedule begin -->
  <section id="schedule" class="py-5">
    <div class="container">
      <h2 class="text-center display-5 fw-bold mb-4">Schedule</h2>

      <div class="row g-4 justify-content-center">
      <div class="col-12 col-md-3">
      <div class="card h-100 text-center shadow-sm">
      <div class="card-body py-4">
        <i class="bi bi-book fs-2 text-danger mb-3"></i>
        <h5 class="card-title">Membaca</h5>
        <p class="text-muted small">Menambah wawasan setiap pagi sebelum beraktivitas.</p>
      </div>
      </div>
      </div>

      <div class="col-12 col-md-3">
      <div class="card h-100 text-center shadow-sm">
      <div class="card-body py-4">
        <i class="bi bi-pencil-square fs-2 text-danger mb-3"></i>
        <h5 class="card-title">Menulis</h5>
        <p class="text-muted small">Mencatat setiap pengalaman harian di jurnal pribadi.</p>
      </div>
      </div>
      </div>

      <div class="col-12 col-md-3">
      <div class="card h-100 text-center shadow-sm">
      <div class="card-body py-4">
        <i class="bi bi-people fs-2 text-danger mb-3"></i>
        <h5 class="card-title">Diskusi</h5>
        <p class="text-muted small">Bertukar ide dengan teman dalam kelompok belajar.</p>
      </div>
      </div>
      </div>

      <div class="col-12 col-md-3">
      <div class="card h-100 text-center shadow-sm">
      <div class="card-body py-4">
        <i class="bi bi-bicycle fs-2 text-danger mb-3"></i>
        <h5 class="card-title">Olahraga</h5>
        <p class="text-muted small">Menjaga kesehatan dengan bersepeda sore hari.</p>
      </div>
      </div>
      </div>
      </div>

      <div class="row g-4 justify-content-center mt-3">
      <div class="col-12 col-md-4">
      <div class="card h-100 text-center shadow-sm">
      <div class="card-body py-4">
        <i class="bi bi-film fs-2 text-danger mb-3"></i>
        <h5 class="card-title">Movie</h5>
        <p class="text-muted small">Menonton film yang bagus di bioskop.</p>
      </div>
      </div>
      </div>

      <div class="col-12 col-md-4">
      <div class="card h-100 text-center shadow-sm">
      <div class="card-body py-4">
        <i class="bi bi-bag fs-2 text-danger mb-3"></i>
        <h5 class="card-title">Belanja</h5>
        <p class="text-muted small">Membeli kebutuhan bulanan di supermarket.</p>
      </div>
      </div>
      </div>
      </div>
    </div>
    </section>
  <!--schedule end -->
  <!--About me begin-->
<section id="About me" class="py-5 bg-body-tertiary">
    <div class="container">
      <h2 class="text-center display-5 fw-bold mb-4">About Me</h2>
<div class="container my-5">
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            Universitas Dian Nuswantoro Semarang (2024 - Now)
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>Lorem ipsum dolor sit amet.</strong> Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quisquam, necessitatibus provident. Nisi architecto error itaque eius unde id. Dolorem, natus?
            <code>Lorem ipsum dolor sit amet.</code>, Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores, expedita.
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            SMK N 1 Pati (2021-2024)
          </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>Lorem ipsum dolor sit amet.</strong> Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quisquam, necessitatibus provident. Nisi architecto error itaque eius unde id. Dolorem, natus?
            <code>Lorem ipsum dolor sit amet.</code>, Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores, expedita.
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            SMP 3 Juwana (2018-2021)
          </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
               <strong>Lorem ipsum dolor sit amet.</strong> Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quisquam, necessitatibus provident. Nisi architecto error itaque eius unde id. Dolorem, natus?
            <code>Lorem ipsum dolor sit amet.</code>, Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores, expedita.
            </div>
          </div>
        </div>
      </div>
    </div>
  <!-- About me end-->
  <!-- footer begin -->
    <footer class="text-center p-4 bg-light">
      <div class="container">
        <div class="d-flex justify-content-center gap-3 mb-2">
          <a href="#" class="text-dark fs-4" aria-label="Instagram" title="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-dark fs-4" aria-label="WhatsApp" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
          <a href="#" class="text-dark fs-4" aria-label="X (Twitter)" title="X"><i class="bi bi-twitter-x"></i></a>
        </div>
        <small class="text-muted">© 2025 My Daily Journal</small>
      </div>
    </footer>
    <!-- footer end -->
    <!-- Scroll to Top Button -->
    <button id="scrollToTopBtn" aria-label="Scroll to top">
      <i class="bi bi-chevron-up"></i>
    </button>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script type="text/javascript">
    
      function updateDateTime() {
        const now = new Date();
        
        // Array nama hari dan bulan
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        // Format hari
        const dayName = days[now.getDay()];
        
        // Format tanggal (DD/MM/YYYY)
        const date = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const year = now.getFullYear();
        const dateString = `${date}/${month}/${year}`;
        
        // Format waktu (HH:MM:SS)
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;
        
        // Update DOM
        document.getElementById('dayDisplay').textContent = dayName;
        document.getElementById('dateDisplay').textContent = dateString;
        document.getElementById('timeDisplay').textContent = timeString;
      }
      
      // Jalankan fungsi saat halaman load
      updateDateTime();
      
      // Update setiap detik
      setInterval(updateDateTime, 1000);

      // Gallery modal image handler
      document.querySelectorAll('[data-bs-target="#galleryModal"]').forEach(button => {
        button.addEventListener('click', function() {
          const imageSrc = this.getAttribute('data-src');
          document.getElementById('galleryModalImg').src = imageSrc;
        });
      });
      
      // Scroll to Top Button 
      const scrollToTopBtn = document.getElementById('scrollToTopBtn');

      window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
          scrollToTopBtn.classList.add('show');
        } else {
          scrollToTopBtn.classList.remove('show');
        }
      });

      scrollToTopBtn.addEventListener('click', function() {
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      });

      // Theme Toggle Button
      const themeToggle = document.getElementById('themeToggle');
      const htmlElement = document.documentElement;
      const body = document.body;

      const savedTheme = localStorage.getItem('theme') || 'light';
      if (savedTheme === 'dark') {
        body.classList.add('dark-mode');
        themeToggle.innerHTML = '<i class="bi bi-sun-fill"></i>';
      }

      themeToggle.addEventListener('click', function() {
        body.classList.toggle('dark-mode');
        
        if (body.classList.contains('dark-mode')) {
          localStorage.setItem('theme', 'dark');
          themeToggle.innerHTML = '<i class="bi bi-sun-fill"></i>';
        } else {
          localStorage.setItem('theme', 'light');
          themeToggle.innerHTML = '<i class="bi bi-moon-fill"></i>';
        }
      });
    </script>
  </body>
</html>