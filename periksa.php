<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['role'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginDokter");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['simpan'])) {
        $biaya_default = 150000;
        $id_daftar_poli = $_GET['dpid'];
        $tgl_periksa = $_POST['tgl_periksa'];
        $catatan = $_POST['catatan'];
        if (isset($_POST['obat'])) {
            $obat = $_POST['obat'];
            $id_obat = [];
            $total_biaya_obat = 0;

            for ($i = 0; $i < count($obat); $i++) {
                $data_obat = explode('|', $obat[$i]);
                $id_obat[] = $data_obat[0];

                $harga_obat = is_numeric($data_obat[1]) ? $data_obat[1] : 0;

                $total_biaya_obat += $harga_obat;
            }

            $total_biaya = $biaya_default + $total_biaya_obat;
            $query1 = "INSERT INTO periksa(id_daftar_poli, tgl_periksa, catatan, biaya_periksa)
                            VALUES ('$id_daftar_poli', '$tgl_periksa', '$catatan', '$total_biaya')";
            $result = mysqli_query($mysqli, $query1);

            $query2 = "INSERT INTO detail_periksa (id_periksa, id_obat) VALUES ";
            //query terakhir akan ditambahkan id
            $id_periksa = mysqli_insert_id($mysqli);
            for ($i = 0; $i < count($id_obat); $i++) {
                $query2 .= "($id_periksa, $id_obat[$i]),";
            }

            $query2 = substr($query2, 0, -1);
            $result2 = mysqli_query($mysqli, $query2);

            if ($result && $result2) {
                echo "<script>
                            alert('Berhasil diperiksa');
                            document.location='index.php?page=periksa';
                            </script>";
            } else {
                echo "<script>
                                alert('Update Gagal');
                                document.location='index.php?page=periksa';
                                </script>";
            }
        } else {
            echo "<script>
                            alert('Update Gagal');
                            document.location='index.php?page=periksa';
                            </script>";
        }
    }
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
            if (isset($_GET['id'])) {
                $ambil = mysqli_query(
                    $mysqli,
                    "SELECT ps.* FROM pasien AS ps WHERE ps.id = '" . $_GET['id'] . "'"
                );
                while ($row = mysqli_fetch_array($ambil)) {
                    $nama_pasien = $row['nama'];
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
                <label for="inputJadwal" class="form-label fw-bold">
                    Tanggal Periksa
                </label>
                <div>
                    <input type="datetime-local" class="form-control" name="tgl_periksa" id="inputJadwal" required placeholder="Tanggal Periksa">
                </div>
            </div>
            <div class="row mt-1">
                <label for="inputCatatan" class="form-label fw-bold">
                    Catatan
                </label>
                <div>
                    <input type="text" class="form-control" name="catatan" id="inputCatatan" required placeholder="Catatan">
                </div>
            </div>
            <div class="row mt-1">
                <label for="id_obat" class="form-label fw-bold">
                    Obat
                </label>
                <div>
                    <select class="form-select" aria-label="Default select example" name="obat[]" id="id_obat" multiple="multiple">
                        <?php
                        $ambilObat = mysqli_query($mysqli, "SELECT * FROM obat");
                        while ($row = mysqli_fetch_array($ambilObat)) {
                        ?>
                            <option value="<?= $row["id"]; ?>|<?= $row["harga"]; ?>"><?= $row["nama_obat"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class=col>
                    <button type="submit" id="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
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
                <th scope="col">Keluhan</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT ps.id, ps.nama AS nama_pasien, dp.id AS dpid, dp.keluhan, dp.no_antrian
                                                FROM daftar_poli AS dp
                                                    JOIN pasien AS ps ON ps.id = dp.id_pasien
                                                    JOIN jadwal_periksa AS jp ON dp.id_jadwal = dp.id_jadwal
                                                    JOIN dokter AS dok ON jp.id_dokter = dok.id
                                                WHERE  dp.id_jadwal = jp.id AND jp.id_dokter = '" . $_SESSION['id_dokter'] . "'
                                                    ");
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $data['no_antrian'] ?></td>
                    <td><?php echo $data['nama_pasien'] ?></td>
                    <td><?php echo $data['keluhan'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id'] ?>&dpid=<?php echo $data['dpid'] ?>">Periksa</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#id_obat').select2({
                placeholder: 'Pilih Obat',
                multiple: true
            });
        });
    </script>