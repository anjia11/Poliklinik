<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['role'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: indexDokter.php?page=loginDokter");
    exit;
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE pasien SET 
                                            nama = '" . $_POST['nama'] . "',
                                            alamat = '" . $_POST['alamat'] . "',
                                            no_ktp = '" . $_POST['no_ktp'] . "',
                                            no_hp = '" . $_POST['no_hp'] . "',
                                            no_rm = '" . $_POST['no_rm'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) 
                                            VALUES (
                                                '" . $_POST['nama'] . "',
                                                '" . $_POST['alamat'] . "',
                                                '" . $_POST['no_ktp'] . "',
                                                '" . $_POST['no_hp'] . "',
                                                '" . $_POST['no_rm'] . "'
                                            )");
    }
    echo "<script> 
                document.location='indexDokter.php?page=pasien';
                </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
                document.location='indexDokter.php?page=pasien';
                </script>";
}
?>
<h2>Riwayat Pasien</h2>
<br>
<div class="container">
    <?php
    if (isset($_GET["id"])) {
    ?>
        <!--Form Input Data-->

        <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
            <!-- Kode php untuk menghubungkan form dengan database -->
            <?php
            $nama_pasien = '';
            $alamat = '';
            $no_ktp = '';
            $no_hp = '';
            $no_rm = '';
            if (isset($_GET['id'])) {
                $ambil = mysqli_query($mysqli, "SELECT * FROM pasien 
                        WHERE id='" . $_GET['id'] . "'");
                while ($row = mysqli_fetch_array($ambil)) {
                    $nama_pasien = $row['nama'];
                    $alamat = $row['alamat'];
                    $no_ktp = $row['no_ktp'];
                    $no_hp = $row['no_hp'];
                    $no_rm = $row['no_rm'];
                }
            ?>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <?php
            }
            ?>
            <div class="row">
                <label for="inputNama" class="form-label fw-bold">
                    Nama
                </label>
                <div>
                    <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama" value="<?php echo $nama_pasien ?>">
                </div>
            </div>
            <div class="row mt-1">
                <label for="inputAlamat" class="form-label fw-bold">
                    Alamat
                </label>
                <div>
                    <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="alamat" value="<?php echo $alamat ?>">
                </div>
            </div>
            <div class="row mt-1">
                <label for="inputNoKtp" class="form-label fw-bold">
                    No KTP
                </label>
                <div>
                    <input type="text" class="form-control" name="no_ktp" id="inputNoKtp" placeholder="No KTP" value="<?php echo $no_ktp ?>">
                </div>

            </div>
            <div class="row mt-1">
                <label for="inputNoHp" class="form-label fw-bold">
                    No HP
                </label>
                <div>
                    <input type="text" class="form-control" name="no_hp" id="inputNoHp" placeholder="No KTP" value="<?php echo $no_hp ?>">
                </div>
            </div>
            <div class="row mt-1">
                <label for="inputNoRm" class="form-label fw-bold">
                    No RM
                </label>
                <div>
                    <input type="text" class="form-control" name="no_rm" id="inputNoRm" placeholder="No RM" value="<?php echo $no_rm ?>">
                </div>
            </div>
            <div class="row mt-3">
                <div class=col>
                    <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
                </div>
            </div>
        </form>
    <?php
        }
    ?>
    <br>
    <br>
    <!-- Table-->
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">No KTP</th>
                <th scope="col">No Hp</th>
                <th scope="col">No RM</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT * FROM pasien");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['no_ktp'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td><?php echo $data['no_rm'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="indexDokter.php?page=pasien&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3" href="indexDokter.php?page=pasien&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>