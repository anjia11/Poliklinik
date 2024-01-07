<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['role'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginUser");
    exit;
}

if (isset($_POST['simpan'])) {
    if ($_POST['hari'] == '999') {
        echo '
            <script>alert("Hari Tidak Boleh Kosong")</script>
        ';
        echo 'meta http-equiv="refresh" content="0>';
    } elseif ($_POST['aktif'] == '999') {
        echo '
            <script>alert("Status Tidak Boleh Kosong")</script>
        ';
        echo 'meta http-equiv="refresh" content="0>';
    } else {
        if (isset($_POST['id'])) {
            $ubah = mysqli_query($mysqli, "UPDATE jadwal_periksa SET 
                                                hari = '" . $_POST['hari'] . "',
                                                jam_mulai = '" . $_POST['jam_mulai'] . "',
                                                jam_selesai = '" . $_POST['jam_selesai'] . "',
                                                aktif = '" . $_POST['aktif'] . "'
                                                WHERE
                                                id = '" . $_POST['id'] . "'");
        } else {
            $tambah = mysqli_query($mysqli, "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai, aktif) 
                                                VALUES (
                                                    '" . $_SESSION['id_dokter'] . "',
                                                    '" . $_POST['hari'] . "',
                                                    '" . $_POST['jam_mulai'] . "',
                                                    '" . $_POST['jam_selesai'] . "',
                                                    '" . $_POST['aktif'] . "'
                                                )");
        }
    }
    echo "<script> 
                document.location='index.php?page=jadwalDokter';
                </script>";
}
// if (isset($_GET['aksi'])) {
//     if ($_GET['aksi'] == 'hapus') {
//         $hapus = mysqli_query($mysqli, "DELETE FROM jadwal_periksa WHERE id = '" . $_GET['id'] . "'");
//     }

//     echo "<script> 
//                 document.location='index.php?page=jadwalDokter';
//                 </script>";
// }
?>
<h2>Jadwal Dokter</h2>
<br>
<div class="container">
    <!--Form Input Data-->

    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
        $hari = '';
        $jam_mulai = '';
        $jam_selesai = '';
        $aktif = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa 
                    WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $hari = $row['hari'];
                $jam_mulai = $row['jam_mulai'];
                $jam_selesai = $row['jam_selesai'];
                $aktif = $row['aktif'];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="row">
            <label for="inputHari" class="form-label fw-bold">
                Hari
            </label>
            <select class="form-control" id="inputHari" name="hari">
                <?php
                if (!isset($_GET['id'])) {
                ?>
                    <option value="999" selected>Pilih Hari</option>
                <?php
                } else {
                ?>
                    <option value="<?php echo $hari ?>"><?php echo $hari ?></option>
                <?php
                }
                ?>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
            </select>
        </div>
        <div class="row mt-1">
            <label for="inputJamMulai" class="form-label fw-bold">
                Jam Mulai
            </label>
            <div>
                <input type="time" class="form-control" name="jam_mulai" id="inputJamMulai" required placeholder="Jam Mulai" value="<?php echo $jam_mulai ?>">
            </div>
        </div>
        <div class="row mt-1">
            <label for="inputJamSelesai" class="form-label fw-bold">
                Jam Selesai
            </label>
            <div>
                <input type="time" class="form-control" name="jam_selesai" id="inputJamSelesai" required placeholder="Jam Selesai" value="<?php echo $jam_selesai ?>">
            </div>
        </div>
        <div class="row">
            <label for="inputAktif" class="form-label fw-bold">
                Status
            </label>
            <select class="form-control" id="inputAktif" name="aktif">
                <?php
                if (!isset($_GET['id'])) {
                ?>
                    <option value="999" selected>Status Aktif/Tidak</option>
                <?php
                } else {
                ?>
                    <option value="<?php echo $aktif ?>"><?php echo $aktif ?></option>
                <?php
                }
                ?>
                <option value="Y">Y</option>
                <option value="N">N</option>
            </select>
        </div>
        <div class="row mt-3">
            <div class=col>
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
            </div>
        </div>
    </form>
    <br>
    <br>
    <!-- Table-->
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Dokter</th>
                <th scope="col">Hari</th>
                <th scope="col">Jam Mulai</th>
                <th scope="col">Jam Selesai</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            $result = mysqli_query($mysqli, "SELECT jp.*, dok.nama AS nama_dokter FROM jadwal_periksa AS jp
                                                    JOIN dokter AS dok ON id_dokter = dok.id
                                            WHERE id_dokter = '" . $_SESSION['id_dokter'] . "'");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
                $status = ($data["aktif"] == 'Y') ? "Aktif" : "Tidak Aktif";
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama_dokter'] ?></td>
                    <td><?php echo $data['hari'] ?></td>
                    <td><?php echo $data['jam_mulai'] ?></td>
                    <td><?php echo $data['jam_selesai'] ?></td>
                    <td><?php echo $status ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=jadwalDokter&id=<?php echo $data['id'] ?>">Ubah</a>
                        <!-- <a class="btn btn-danger rounded-pill px-3" href="index.php?page=jadwalDokter&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a> -->
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>