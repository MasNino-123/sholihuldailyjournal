<?php
// Query untuk mengambil data user yang sedang login
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$data_user = $result->fetch_assoc();
$stmt->close();

// Query untuk mengambil data article
$sql1 = "SELECT * FROM article ORDER BY tanggal DESC";
$hasil1 = $conn->query($sql1);
$jumlah_article = $hasil1->num_rows;

// Query untuk mengambil data gallery
$sql2 = "SELECT * FROM gallery ORDER BY created_at DESC";
$hasil2 = $conn->query($sql2);
$jumlah_gallery = $hasil2->num_rows;
?>

<style>
    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .welcome-section {
        text-align: center;
        padding: 2rem 0;
    }
    .welcome-section h5 {
        color: #6c757d;
        font-weight: 400;
        margin-bottom: 1rem;
    }
    .welcome-section h2 {
        color: #dc3545;
        font-weight: 700;
        margin-bottom: 2rem;
    }
    .stat-card {
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }
    .stat-card .icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #6c757d;
    }
    .stat-card h5 {
        color: #333;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .stat-badge {
        display: inline-block;
        background: #dc3545;
        color: white;
        width: 60px;
        height: 60px;
        line-height: 60px;
        border-radius: 50%;
        font-size: 1.5rem;
        font-weight: 700;
    }
</style>

<!-- Welcome Section -->
<div class="welcome-section">
    <h5 class="mb-3">Selamat Datang,</h5>
    
    <!-- Profile Avatar -->
    <div class="mb-3">
        <?php
        if (!empty($data_user['foto']) && file_exists('img/' . $data_user['foto'])) {
            echo '<img src="img/' . htmlspecialchars($data_user['foto']) . '" alt="Profile" class="profile-avatar">';
        } else {
            echo '<div class="profile-avatar d-inline-flex align-items-center justify-content-center bg-light">';
            echo '<i class="bi bi-person-circle" style="font-size: 6rem; color: #6c757d;"></i>';
            echo '</div>';
        }
        ?>
    </div>
    
    <!-- Username -->
    <h2><?= htmlspecialchars($data_user['username']) ?></h2>
</div>

<!-- Statistics Cards -->
<div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center mt-4">
    <!-- Article Card -->
    <div class="col" style="max-width: 300px;">
        <a href="admin.php?page=article" class="text-decoration-none">
            <div class="stat-card">
                <div class="icon">
                    <i class="bi bi-newspaper"></i>
                </div>
                <h5>Article</h5>
                <div class="stat-badge">
                    <?= $jumlah_article ?>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Gallery Card -->
    <div class="col" style="max-width: 300px;">
        <a href="admin.php?page=gallery" class="text-decoration-none">
            <div class="stat-card">
                <div class="icon">
                    <i class="bi bi-images"></i>
                </div>
                <h5>Gallery</h5>
                <div class="stat-badge">
                    <?= $jumlah_gallery ?>
                </div>
            </div>
        </a>
    </div>
</div>
