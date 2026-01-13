<?php
// Pastikan session sudah dimulai dan koneksi database tersedia
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (!isset($conn)) {
    die("Koneksi database tidak tersedia");
}

// Ambil data user yang sedang login
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$data_user = $result->fetch_assoc();
$stmt->close();

if (!$data_user) {
    die("Data user tidak ditemukan");
}

include "upload_foto.php";

// Proses update profile
if (isset($_POST['simpan'])) {
    $username = $_SESSION['username'];
    $password_baru = trim($_POST['password_baru']);
    $foto_profil = $data_user['foto']; // default foto lama
    $nama_gambar = $_FILES['foto']['name'];

    // Cek apakah user ingin ganti foto
    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES["foto"]);
        
        if ($cek_upload['status']) {
            $foto_profil = $cek_upload['message'];
            
            // Hapus foto lama jika ada dan bukan default
            if ($data_user['foto'] != '' && file_exists("img/" . $data_user['foto'])) {
                unlink("img/" . $data_user['foto']);
            }
        } else {
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=profile';
            </script>";
            die;
        }
    }

    // Update data user
    if ($password_baru != '') {
        // Jika ada password baru, update password dan foto
        $password_hash = md5($password_baru);
        $stmt = $conn->prepare("UPDATE user SET password=?, foto=? WHERE username=?");
        $stmt->bind_param("sss", $password_hash, $foto_profil, $username);
    } else {
        // Jika tidak ada password baru, hanya update foto
        $stmt = $conn->prepare("UPDATE user SET foto=? WHERE username=?");
        $stmt->bind_param("ss", $foto_profil, $username);
    }

    $update = $stmt->execute();

    if ($update) {
        echo "<script>
            alert('Update profile berhasil');
            document.location='admin.php?page=profile';
        </script>";
    } else {
        echo "<script>
            alert('Update profile gagal');
            document.location='admin.php?page=profile';
        </script>";
    }

    $stmt->close();
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background-color:#a58cff;">
                <h5 class="mb-0"><i class="bi bi-person-circle"></i> Manajemen Profile</h5>
            </div>
            <div class="card-body">
                <form method="post" action="" enctype="multipart/form-data">
                    <!-- Username (Readonly) -->
                    <div class="mb-3">
                        <label for="username" class="form-label fw-bold">Username</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?= htmlspecialchars($data_user['username']) ?>" readonly>
                        <small class="text-muted">Username tidak dapat diubah</small>
                    </div>

                    <!-- Ganti Password -->
                    <div class="mb-3">
                        <label for="password_baru" class="form-label fw-bold">Ganti Password</label>
                        <input type="password" class="form-control" id="password_baru" 
                               name="password_baru" 
                               placeholder="Tuliskan Password Baru Jika Ingin Mengganti Password Saja">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                    </div>

                    <!-- Ganti Foto Profil -->
                    <div class="mb-3">
                        <label for="foto" class="form-label fw-bold">Ganti Foto Profil</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                    </div>

                    <!-- Foto Profil Saat Ini -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Profil Saat Ini</label>
                        <div class="border rounded p-3 text-center bg-light">
                            <?php
                            if (!empty($data_user['foto']) && file_exists('img/' . $data_user['foto'])) {
                                echo '<img src="img/' . htmlspecialchars($data_user['foto']) . '" class="img-thumbnail" style="max-width: 250px; max-height: 250px;" alt="Foto Profil">';
                            } else {
                                echo '<div class="text-muted py-4">';
                                echo '<i class="bi bi-person-circle" style="font-size: 5rem;"></i>';
                                echo '<p class="mt-2">Belum ada foto profil</p>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="admin.php?page=dashboard" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" name="simpan" class="btn text-white" style="background-color:#a58cff;">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>