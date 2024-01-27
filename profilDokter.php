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
    if (isset($_SESSION['id_dokter'])) {
        $update_query = "UPDATE dokter SET 
                                nama = '" . $_POST['nama'] . "',
                                nip = '" . $_POST['nip'] . "',
                                alamat = '" . $_POST['alamat'] . "',
                                no_hp = '" . $_POST['no_hp'] . "',
                                id_poli = '" . $_POST['id_poli'] . "'
                                WHERE
                                id = '" . $_SESSION['id_dokter'] . "'";
        if (mysqli_query($mysqli, $update_query)) {
            echo "<script>
                alert('Update Berhasil'); 
                </script>";
        } else {
            echo "<script>
                alert('Update Gagal'); 
                </script>";
        }
    }
    echo "<script> 
                document.location='index.php?page=profilDokter';
                </script>";
}

if (isset($_POST['simpan_password'])) {
    $password_lama = $_POST['pass_lama'];
    $password_baru = $_POST['pass_baru'];
    $konfirmasi_pass = $_POST['k_pass_baru'];


    $query = "SELECT * FROM dokter WHERE id = '" . $_SESSION['id_dokter'] . "'";
    $result = $mysqli->query($query);

    if (!$result) {
        die("Query error: " . $mysqli->error);
    }

    if ($result->num_rows == 1) {
        if ($password_baru == $konfirmasi_pass) {
            $row = $result->fetch_assoc();
            if (password_verify($password_lama, $row['password'])) {
                $hashed_password_baru = password_hash($password_baru, PASSWORD_DEFAULT);

                $update_pass_query = "UPDATE dokter SET 
                                            password = '" . $hashed_password_baru . "'
                                            WHERE
                                            id = '" . $_SESSION['id_dokter'] . "'";
                if (mysqli_query($mysqli, $update_pass_query)) {
                    echo "<script>
                            alert('Update Berhasil'); 
                            document.location='index.php?page=profilDokter';
                            </script>";
                } else {
                    echo "<script>
                            alert('Update Gagal');
                            document.location='index.php?page=profilDokter';
                            </script>";
                }
            } else {
                $error = "Password salah";
            }
        } else {
            $error = "Password tidak sesuai";
        }
    }
}
?>


<h2>Profil Dokter</h2>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <!--Form Input Data-->
            <h4>Ubah Profil Dokter</h4>
            <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
                <!-- Kode php untuk menghubungkan form dengan database -->
                <?php
                $nama_dokter = '';
                $nip = '';
                $alamat = '';
                $no_hp = '';
                $nama_poli = '';
                $id_poli = '';
                if (isset($_SESSION['id_dokter'])) {
                    $ambil = mysqli_query($mysqli, "SELECT dok.*, po.nama_poli FROM dokter AS dok JOIN poli AS po ON dok.id_poli = po.id
                            WHERE dok.id='" . $_SESSION['id_dokter'] . "'");
                    while ($row = mysqli_fetch_array($ambil)) {
                        $nama_dokter = $row["nama"];
                        $nip = $row["nip"];
                        $alamat = $row["alamat"];
                        $no_hp = $row["no_hp"];
                        $nama_poli = $row["nama_poli"];
                        $id_poli = $row["id_poli"];
                    }
                ?>
                    <!-- <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"> -->
                <?php
                }
                ?>
                <div class="row">
                    <label for="inputNama" class="form-label fw-bold">
                        Nama
                    </label>
                    <div>
                        <input type="text" class="form-control" name="nama" id="inputNama" required placeholder="Nama" value="<?php echo $nama_dokter ?>">
                    </div>
                </div>
                <div class="row mt-1">
                    <label for="inputNIP" class="form-label fw-bold">
                        NIP
                    </label>
                    <div>
                        <input type="text" class="form-control" name="nip" id="inputNIP" required placeholder="NIP" value="<?php echo $nip ?>">
                    </div>
                </div>
                <div class="row mt-1">
                    <label for="inputAlamat" class="form-label fw-bold">
                        Alamat
                    </label>
                    <div>
                        <input type="text" class="form-control" name="alamat" id="inputAlamat" required placeholder="Alamat" value="<?php echo $alamat ?>">
                    </div>

                </div>
                <div class="row mt-1">
                    <label for="inputHP" class="form-label fw-bold">
                        No.HP
                    </label>
                    <div>
                        <input type="text" class="form-control" name="no_hp" id="inputHP" required placeholder="No.HP" value="<?php echo $no_hp ?>">
                    </div>

                </div>
                <div class="row mt-1">
                    <label for="id_poli" class="form-label fw-bold">
                        Nama Poli
                    </label>
                    <div>
                        <select class="form-select" aria-label="Default select example" name="id_poli" id="id_poli" required>
                            <option value="<?php echo $id_poli ?>"><?php echo $nama_poli ?></option>
                            <?php
                            $ambilPoli = mysqli_query($mysqli, "SELECT * FROM poli");

                            while ($row = mysqli_fetch_array($ambilPoli)) {
                                echo "<option value='" . $row["id"] . "'>" . $row["nama_poli"] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class=col>
                        <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-4">

            <!--Form Input Data-->
            <h4>Ubah Password</h4>
            <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
                <?php
                if (isset($error)) {
                    echo '<div class="alert alert-danger">' . $error . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                }
                ?>
                <div class="row">
                    <label for="inputPWLama" class="form-label fw-bold">
                        Password Lama
                    </label>
                    <div>
                        <input type="text" class="form-control" name="pass_lama" id="inputPWLama" required placeholder="Masukkan Password Lama">
                    </div>
                </div>
                <div class="row mt-1">
                    <label for="inputPWBaru" class="form-label fw-bold">
                        Password Baru
                    </label>
                    <div>
                        <input type="text" class="form-control" name="pass_baru" id="inputPWBaru" required placeholder="Masukkan Password Baru">
                    </div>
                </div>
                <div class="row mt-1">
                    <label for="konfirmasiPWBaru" class="form-label fw-bold">
                        Konfirmasi Password Baru
                    </label>
                    <div>
                        <input type="text" class="form-control" name="k_pass_baru" id="konfirmasiPWBaru" required placeholder="Masukkan Password Baru">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class=col>
                        <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan_password">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>