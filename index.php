<?php
    include_once("koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, 
    initial-scale=1.0">

    <!-- Bootstrap offline sesuai lokasi file disimpan -->
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.css">  -->

    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">   <!-- Gunakan salah satu cara saja -->
    
    <title>To Do List</title>   <!--Judul Halaman-->
</head>
<body>
    <div class="container mt-3">
        <h3>
            To Do List
            <small class="text-muted">
                Catat semua hal yang akan kamu kerjakan disini.
            </small>
        </h3>
        <hr>
        <!-- Form -->
        <form class="form row" method="POST" action="" name="myForm"">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
            $isi = '';
            $tgl_awal = '';
            $tgl_akhir = '';
            if (isset($_GET['id'])) {
                $ambil = mysqli_query($mysqli,
                "SELECT * FROM todolist
                WHERE id='" . $_GET['id'] . "'");
                while ($row = mysqli_fetch_array($ambil)) {
                    $isi = $row['isi'];
                    $tgl_awal = $row['tgl_awal'];
                    $tgl_akhir = $row['tgl_akhir'];
                }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
            }
        ?>
            <div class="col mb-2">
                <label for="inputIsi" class="form-label fw-bold">
                    Kegiatan
                </label>
                <input type="text" class="form-control" name="isi" id="inputIsi" placeholder="Kegiatan" value="<?php echo $isi; ?>">
            </div>
            <div class="col mb-2">
                <label for="inputTanggalAwal" class="form-label fw-bold">
                    Tanggal Awal
                </label>
                <input type="date" class="form-control" name="tgl_awal" id="inputTanggalAwal" placeholder="Tanggal Awal" value="<?php echo $tgl_awal; ?>">
            </div>
                <div class="col mb-2">
                <label for="inputTanggalAkhir" class="form-label fw-bold">
                    Tanggal Akhir
                </label>
                <input type="date" class="form-control" name="tgl_akhir" id="inputTanggalAkhir" placeholder="Tanggal Akhir" value="<?php echo $tgl_akhir; ?>">
            </div>
            <div class="col mb-2 d-flex">
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
            </div>
        </form>
        <!-- Form -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kegiatan</th>
                    <th scope="col">Awal</th>
                    <th scope="col">Akhir</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Kode PHP untuk menampilkan semua isi dari tabel urut berdasarkan status dan tanggal awal-->
                <?php
                    $result = mysqli_query($mysqli, "SELECT * FROM todolist ORDER BY status, tgl_awal");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $no++; ?></th>
                        <td><?php echo $data['isi']; ?></td>
                        <td><?php echo $data['tgl_awal']; ?></td>
                        <td><?php echo $data['tgl_akhir']; ?></td>
                        <td>
                            <?php
                            if ($data['status'] == '1') {
                            ?>
                                <a class="btn btn-success rounded-pill px-3" type="button"
                                href="index.php?id=<?php echo $data['id']; ?>&aksi=ubah_status&status=0">
                                Sudah
                                </a>
                            <?php
                            } else {
                            ?>
                                <a class="btn btn-warning rounded-pill px-3" type="button"
                                href="index.php?id=<?php echo $data['id']; ?>&aksi=ubah_status&status=1">
                                Belum
                                </a>
                            <?php
                            }
                            ?>
                        </td>
                        <td>
                            <a class="btn btn-info rounded-pill px-3"
                            href="index.php?id=<?php echo $data['id']; ?>">Ubah
                            </a>
                            <a class="btn btn-danger rounded-pill px-3"
                            href="index.php?id=<?php echo $data['id']; ?>&aksi=hapus">Hapus
                            </a>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Load js secara offline sesuai lokasi file disimpan -->
    <script src="js/bootstrap.bundle.js"></script> 
    <!-- Load JS online -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>   
    <!-- cukup gunakan salah satu saja -->
</body>
</html>

<?php
    if (isset($_POST['simpan'])) { // Corrected $_POST
        if (isset($_POST['id'])) {
            // mengubah/update data
            $ubah = mysqli_query($mysqli, "UPDATE todolist SET
                                            isi = '" . $_POST['isi'] . "',
                                            tgl_awal = '" . $_POST['tgl_awal'] . "',
                                            tgl_akhir = '" . $_POST['tgl_akhir'] . "'
                                            WHERE id = '" . $_POST['id'] . "'");
        } else {
            // menambahkan data
            $tambah = mysqli_query($mysqli, "INSERT INTO todolist(isi, tgl_awal, tgl_akhir, status)
                                             VALUES (
                                                 '" . $_POST['isi'] . "',
                                                 '" . $_POST['tgl_awal'] . "',
                                                 '" . $_POST['tgl_akhir'] . "',
                                                 '0'
                                             )");
        }

        // Redirect setelah mengubah data
        echo "<script>
                document.location='index.php';
              </script>";
    }

    if (isset($_GET['aksi'])) { // Corrected $_GET
        if ($_GET['aksi'] == 'hapus') {
            // Hapus data
            $hapus = mysqli_query($mysqli, "DELETE FROM todolist WHERE id = '" . $_GET['id'] . "'");
        } else if ($_GET['aksi'] == 'ubah_status') {
            // mengubah/update status 
            $ubahstatus = mysqli_query($mysqli, "UPDATE todolist SET
                                                 status = '" . $_GET['status'] . "'
                                                 WHERE id = '" . $_GET['id'] . "'");
        }

        // Redirect setelah mengubah status
        echo "<script>
                document.location='index.php';
              </script>";
    }
?>