<?php
include "koneksi.php";

$keyword = $_POST['keyword'];

if ($keyword != '') {
    $sql = "SELECT * FROM gallery 
            WHERE deskripsi LIKE ? 
            OR created_at LIKE ? 
            OR created_by LIKE ?
            ORDER BY created_at DESC";

    $stmt = $conn->prepare($sql);
    $search = "%" . $keyword . "%";
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $hasil = $stmt->get_result();
} else {
    $hasil = $conn->query("SELECT * FROM gallery ORDER BY created_at DESC");
}

$no = 1;
while ($row = $hasil->fetch_assoc()) {
?>
<tr>
    <td><?= $no++ ?></td>
    <td>
        <strong><?= $row["deskripsi"] ?></strong>
        <br>pada : <?= $row["created_at"] ?>
        <br>oleh : <?= $row["created_by"] ?>
    </td>
    <td>
        <?php
        if ($row["gambar"] != '') {
            if (file_exists('img/' . $row["gambar"])) { 
                echo '<img src="img/' . $row["gambar"] . '" class="img-fluid" style="max-width:250px;">'; 
            }
        }
        ?>
    </td>
    <td>
        <a href="#" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>">✏</a>
        <a href="#" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>">✖</a>

        <!-- MODAL EDIT -->
        <div class="modal fade" id="modalEdit<?= $row["id"] ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="gallery.php" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5>Edit Gallery</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                            <textarea name="deskripsi" class="form-control mb-2" required><?= $row["deskripsi"] ?></textarea>
                            <input type="file" name="gambar" class="form-control">
                            <br>
                            <img src="img/<?= $row["gambar"] ?>" class="img-fluid" style="max-width:200px;">
                            <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL HAPUS -->
        <div class="modal fade" id="modalHapus<?= $row["id"] ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="gallery.php">
                        <div class="modal-header">
                            <h5>Hapus Gallery</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Yakin hapus data ini?
                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                            <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </td>
</tr>
<?php } ?>
