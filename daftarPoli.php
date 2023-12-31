<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['role'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=pendaftaranPasien");
    exit;
}

if (isset($_POST['simpan'])) {
    $query_ambil_jumlah_daftar = "SELECT COUNT(id) AS jumlah_daftar FROM daftar_poli";
    $data = mysqli_fetch_assoc(mysqli_query($mysqli, $query_ambil_jumlah_daftar));
    $no_antrian = $data["jumlah_daftar"]+1;
    if (isset($_SESSION['id_pasien'])){
        $tambah = mysqli_query($mysqli, "INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan, no_antrian) 
                                            VALUES (
                                                '" . $_SESSION['id_pasien'] . "',
                                                '" . $_POST['new_id_jadwal'] . "',
                                                '" . $_POST['keluhan'] . "' ,
                                                '" . $no_antrian . "' 
                                            )");
    }
    echo "<script> 
                document.location='index.php?page=daftarPoli';
                </script>";
}


?>




<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-4">
            <div class="card">
                <div class="card-header text-center" style="font-weight: bold; font-size: 32px;">Daftar Poli</div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=daftarPoli">
                        <div class="form-group">
                            <label for="No.RM">No.Rekam Medis</label>
                            <input type="text" readonly name="no_rm" class="form-control" required placeholder="<?php echo $_SESSION['no_rm'] ?>">
                        </div>
                        <div class="form-group mt-1">
                            <label for="inputPoli">Pilih Poli</label>
                            <div>
                                <select class="form-select" aria-label="Default select example" name="new_id_poli" id ="inputPoli">
                                    <option selected>Buka untuk Pilih Poli</option>
                                    <?php
                                        $ambilPoli = mysqli_query($mysqli, "SELECT * FROM poli");
                                        while ($row = mysqli_fetch_array($ambilPoli)) {
                                            echo "<option value='" . $row["id"] . "'>" . $row["nama_poli"] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mt-1">
                            <label for="jadwalDokter">Jadwal Poli</label>
                            <select class="form-select" aria-label="Disabled select example" name="new_id_jadwal" id="jadwalDokter">
                                <option selected>Dokter dan Jadwal</option>
                                <?php
                                    $ambilDokter = mysqli_query($mysqli, "SELECT po.*, dk.*, jp.*, jp.id AS jp_id FROM poli AS po 
                                                                            JOIN dokter AS dk ON po.id = dk.id_poli
                                                                            JOIN jadwal_periksa AS jp ON dk.id = jp.id_dokter");
                                    while ($row = mysqli_fetch_array($ambilDokter)) {
                                        echo "<option value='" . $row["jp_id"] . "'>" . $row["nama"] .'-'.$row["hari"].'-'.$row["nama_poli"]."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputKeluhan">Keluhan</label>
                            <textarea class="form-control" name="keluhan" id="inputKeluhan" rows="3"></textarea>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary btn-block" name="simpan">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <table class="table table-hover">
                <!--thead atau baris judul-->
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Pasien</th>
                        <th scope="col">Dokter</th>
                        <th scope="col">Tanggal Periksa</th>
                        <th scope="col">No RM</th>
                        <th scope="col">Catatan</th>
                        <th scope="col">Obat</th>
                        <th scope="col">Biaya</th>
                    </tr>
                </thead>
                <!--tbody berisi isi tabel sesuai dengan judul atau head-->
                <tbody>
                    <tr>
                        <th scope="row">0</th>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('inputPoli').addEventListener('change', function() {
        var selectedPoli = this.value;

        // Buat objek XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Tentukan metode, URL, dan apakah permintaan bersifat asynchronous
        xhr.open('GET', 'getDokterJadwal.php?idpoli=' + selectedPoli, true);
        
        //atur header agar respon diharapkan html
        xhr.setRequestHeader('Content-Type', 'text/html');

        // Tambahkan fungsi callback untuk menangani respons
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Perbarui elemen select Dokter dan Jadwal dengan data yang diterima dari server
                document.getElementById('jadwalDokter').innerHTML = xhr.responseText;
            }
        };

        // Kirim permintaan
        xhr.send();
    });
</script>
