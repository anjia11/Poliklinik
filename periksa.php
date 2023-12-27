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
                                            catatan = '" . $_POST['catatan'] . "',
                                            biaya_periksa = '" . $_POST['total_biaya_periksa'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
        $ubah = mysqli_query($mysqli, "UPDATE detail_periksa SET
                                            id_obat = '".$_POST['new_id_obat']."'
                                            WHERE
                                            id_periksa = '" . $_POST['id'] . "'
                                            ");
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
                $biaya_default = 150000;
                $harga_obat;
                $nama_pasien = '';
                $nama_dokter = '';
                $tgl_periksa;
                $catatan = '';
                $nama_obat ='';
                $id_obat = '';
                $biaya_periksa = '';
                if (isset($_GET['id'])) {
                    $ambil = mysqli_query($mysqli, "SELECT pr.*, dp.keluhan, ps.nama as nama_pasien, dk.nama as nama_dokter, dep.id_obat, o.nama_obat, o.harga
                                                        FROM periksa AS pr
                                                            JOIN daftar_poli AS dp ON pr.id_daftar_poli = dp.id
                                                            JOIN pasien AS ps ON dp.id_pasien = ps.id
                                                            JOIN jadwal_periksa AS jp ON jp.id = dp.id_jadwal
                                                            JOIN dokter AS dk ON dk.id = jp.id_dokter
                                                            JOIN detail_periksa AS dep ON pr.id = dep.id_periksa
                                                            JOIN obat AS o ON dep.id_obat = o.id
                                                            WHERE pr.id = '" . $_GET['id'] . "'"
                                                        );
                    while ($row = mysqli_fetch_array($ambil)) {
                        $harga_obat = $row["harga"];
                        $nama_pasien = $row['nama_pasien'];
                        $nama_dokter = $row['nama_dokter'];
                        $tgl_periksa = $row['tgl_periksa'];
                        $keluhan = $row['keluhan'];
                        $catatan = $row['catatan'];
                        $nama_obat = $row['nama_obat'];
                        $id_obat = $row['id_obat'];
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
                    <label for="inputKeluhan" class="form-label fw-bold">
                        Keluhan
                    </label>
                    <div>
                        <input type="text" readonly class="form-control" name="keluhan" id="inputKeluhan" placeholder="Keluhan" value="<?php echo $keluhan ?>">
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
                <label for="inputObat" class="form-label fw-bold">
                    Obat
                </label>
                <div>
                    <select class="form-select" aria-label="Default select example" name="new_id_obat" id ="inputObat">
                        <option value="<?php echo $id_obat?>"><?php echo $nama_obat?></option>
                        <?php
                            $ambilObat = mysqli_query($mysqli, "SELECT * FROM obat");
                            while ($row = mysqli_fetch_array($ambilObat)) {
                                echo "<option value='" . $row["id"] . "'>" . $row["nama_obat"] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                </div>
                <div class="row mt-1">
                    <label for="biaya" class="form-label fw-bold">
                        Biaya Periksa
                    </label>
                    <div>
                        <?php
                        
                        $biaya_periksa = $biaya_default + $harga_obat;
                        
                        ?>
                        <input type="text" readonly class="form-control" name="total_biaya_periksa" id="biaya" placeholder="Biaya Periksa" value="<?php echo $biaya_periksa ?>">
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
                <th scope="col">No. Antrian</th>
                <th scope="col">Pasien</th>
                <th scope="col">Dokter</th>
                <th scope="col">Tanggal Periksa</th>
                <th scope="col">Keluhan</th>
                <th scope="col">Catatan</th>
                <th scope="col">Obat</th>
                <th scope="col">Biaya Periksa</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT pr.*, dp.*, ps.nama as nama_pasien, dk.nama as nama_dokter, o.nama_obat
                                                FROM periksa AS pr
                                                    JOIN daftar_poli AS dp ON pr.id_daftar_poli = dp.id
                                                    JOIN pasien AS ps ON dp.id_pasien = ps.id
                                                    JOIN jadwal_periksa AS jp ON jp.id = dp.id_jadwal
                                                    JOIN dokter AS dk ON dk.id = jp.id_dokter
                                                    JOIN detail_periksa AS dep ON pr.id = dep.id_periksa
                                                    JOIN obat AS o ON dep.id_obat = o.id
                                                ORDER BY dp.no_antrian ASC"
                                                    );
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $data['no_antrian'] ?></td>
                    <td><?php echo $data['nama_pasien'] ?></td>
                    <td><?php echo $data['nama_dokter'] ?></td>
                    <td><?php echo $data['tgl_periksa'] ?></td>
                    <td><?php echo $data['keluhan'] ?></td>
                    <td><?php echo $data['catatan'] ?></td>
                    <td><?php echo $data['nama_obat'] ?></td>
                    <td><?php echo $data['biaya_periksa'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="indexDokter.php?page=periksa&id=<?php echo $data['id'] ?>">Ubah</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>