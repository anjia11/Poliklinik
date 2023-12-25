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
        $ubah = mysqli_query($mysqli, "UPDATE periksa SET
                                            tgl_periksa = '" . $_POST['tgl_periksa'] . "',
                                            catatan = '" . $_POST['catatan'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
    }
    echo "<script> 
                document.location='indexDokter.php?page=periksa';
                </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
                document.location='indexDokter.php?page=periksa';
                </script>";
}
?>
<h2>Periksa Pasien</h2>
<br>
<div class="container">
    <!--Form Input Data-->
    <?php
        if (isset($_GET["id"])) {
    ?>
            <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
                <!-- Kode php untuk menghubungkan form dengan database -->
                <?php
                $nama_pasien = '';
                $nama_dokter = '';
                $tgl_periksa;
                $catatan = '';
                $biaya_periksa = '';
                if (isset($_GET['id'])) {
                    // $ambil = mysqli_query($mysqli, "SELECT * FROM pasien 
                    //         WHERE id='" . $_GET['id'] . "'");
                    $ambil = mysqli_query($mysqli, "SELECT pr.*, dp.keluhan, ps.nama as nama_pasien, dk.nama as nama_dokter
                                                        FROM periksa AS pr
                                                            JOIN daftar_poli AS dp ON pr.id_daftar_poli = dp.id
                                                            JOIN pasien AS ps ON dp.id_pasien = ps.id
                                                            JOIN jadwal_periksa AS jp ON jp.id = dp.id_jadwal
                                                            JOIN dokter AS dk ON dk.id = jp.id_dokter
                                                            WHERE pr.id = '" . $_GET['id'] . "'"
                                                        );
                    while ($row = mysqli_fetch_array($ambil)) {
                        $nama_pasien = $row['nama_pasien'];
                        $nama_dokter = $row['nama_dokter'];
                        $tgl_periksa = $row['tgl_periksa'];
                        $catatan = $row['catatan'];
                        $biaya_periksa = $row['biaya_periksa'];
                    }
                ?>
                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <?php
                }
                ?>
                <div class="row">
                    <label for="inputNama" class="form-label fw-bold">
                        Nama Pasien
                    </label>
                    <div>
                        <input type="text" readonly class="form-control" name="nama_pasien" id="inputNama" placeholder="Nama Pasien" value="<?php echo $nama_pasien ?>">
                    </div>
                </div>
                <div class="row mt-1">
                    <label for="inputNama" class="form-label fw-bold">
                        Nama Dokter
                    </label>
                    <div>
                        <input type="text" readonly class="form-control" name="nama_dokter" id="inputNama" placeholder="Nama Dokter" value="<?php echo $nama_dokter ?>">
                    </div>
                </div>
                <div class="row mt-1">
                    <label for="inputJadwal" class="form-label fw-bold">
                        Tanggal Periksa
                    </label>
                    <div>
                        <input type="datetime-local" class="form-control" name="tgl_periksa" id="inputJadwal" placeholder="Tanggal Periksa" value="<?php echo $tgl_periksa ?>">
                    </div>

                </div>
                <div class="row mt-1">
                    <label for="inputCatatan" class="form-label fw-bold">
                        Catatan
                    </label>
                    <div>
                        <input type="text" class="form-control" name="catatan" id="inputCatatan" placeholder="Catatan" value="<?php echo $catatan ?>">
                    </div>
                </div>
                <div class="row mt-1">
                    <label for="biaya" class="form-label fw-bold">
                        Biaya Periksa
                    </label>
                    <div>
                        <input type="text" readonly class="form-control" name="biaya_periksa" id="biaya" placeholder="Biaya Periksa" value="<?php echo $biaya_periksa ?>">
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
                <th scope="col">Pasien</th>
                <th scope="col">Dokter</th>
                <th scope="col">Tanggal Periksa</th>
                <th scope="col">Catatan</th>
                <th scope="col">Biaya Periksa</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT pr.*, dp.keluhan, ps.nama as nama_pasien, dk.nama as nama_dokter
                                                FROM periksa AS pr
                                                    JOIN daftar_poli AS dp ON pr.id_daftar_poli = dp.id
                                                    JOIN pasien AS ps ON dp.id_pasien = ps.id
                                                    JOIN jadwal_periksa AS jp ON jp.id = dp.id_jadwal
                                                    JOIN dokter AS dk ON dk.id = jp.id_dokter");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama_pasien'] ?></td>
                    <td><?php echo $data['nama_dokter'] ?></td>
                    <td><?php echo $data['tgl_periksa'] ?></td>
                    <td><?php echo $data['catatan'] ?></td>
                    <td><?php echo $data['biaya_periksa'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="indexDokter.php?page=periksa&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3" href="indexDokter.php?page=periksa&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>