<?php

// koneksi database -----------------------------------------
$koneksi = mysqli_connect("localhost", "root", "", "database");

// start session ---------------------------------------------
session_start();


// function register user -------------------------------------
function register($data)
{
    global $koneksi;

    $username = $data['Username'];
    $email = $data['Email'];
    $password = $data['Password'];
    $cpassword = $data['CPassword'];

    if ($password != $cpassword) {
        echo "<script>alert('Password tidak sama');</script>";
        return false;
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user VALUES('','$username', '$email', '$password', 'admin')";
        mysqli_query($koneksi, $query);
        return mysqli_affected_rows($koneksi);
    }
}

// menambah data kriteria / alternatif
function tambahData($tabel, $nama)
{
    global $koneksi;

    $query     = "INSERT INTO $tabel (nama) VALUES ('$nama')";
    $tambah    = mysqli_query($koneksi, $query);

    if (!$tambah) {
        echo "Gagal mmenambah data" . $tabel;
        exit();
    }
}

// count kriteria
function getJumlahKriteria()
{
    global $koneksi;

    $query  = "SELECT count(*) FROM kriteria";
    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_array($result)) {
        $jmlData = $row[0];
    }

    return $jmlData;
}

// mencari ID kriteria
// berdasarkan urutan ke berapa (C1, C2, C3)
function getKriteriaID($no_urut)
{
    global $koneksi;
    $query  = "SELECT id FROM kriteria ORDER BY id";
    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_array($result)) {
        $listID[] = $row['id'];
    }

    return $listID[($no_urut)];
}

// mencari nama kriteria
function getKriteriaNama($no_urut)
{
    global $koneksi;

    $query  = "SELECT nama FROM kriteria ORDER BY id";
    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_array($result)) {
        $nama[] = $row['nama'];
    }
    return $nama[($no_urut)];
}

// hapus kriteria
function deleteKriteria($id)
{
    global $koneksi;

    // hapus record dari tabel kriteria
    $query     = "DELETE FROM kriteria WHERE id=$id";
    mysqli_query($koneksi, $query);

    // hapus record dari tabel pv_kriteria
    $query     = "DELETE FROM pv_kriteria WHERE id_kriteria=$id";
    mysqli_query($koneksi, $query);

    // hapus record dari tabel pv_alternatif
    $query     = "DELETE FROM pv_alternatif WHERE id_kriteria=$id";
    mysqli_query($koneksi, $query);

    $query     = "DELETE FROM perbandingan_kriteria WHERE kriteria1=$id OR kriteria2=$id";
    mysqli_query($koneksi, $query);

    $query     = "DELETE FROM perbandingan_alternatif WHERE pembanding=$id";
    mysqli_query($koneksi, $query);
}

// mencari priority vector kriteria
function getKriteriaPV($id_kriteria)
{
    global $koneksi;
    $query = "SELECT nilai FROM pv_kriteria WHERE id_kriteria=$id_kriteria";
    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_array($result)) {
        $pv = $row['nilai'];
    }

    return $pv;
}

// mencari nilai bobot perbandingan kriteria
function getNilaiPerbandinganKriteria($kriteria1, $kriteria2)
{
    global $koneksi;

    $id_kriteria1 = getKriteriaID($kriteria1);
    $id_kriteria2 = getKriteriaID($kriteria2);

    $query  = "SELECT nilai FROM perbandingan_kriteria WHERE kriteria1 = $id_kriteria1 AND kriteria2 = $id_kriteria2";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Error !!!";
        exit();
    }

    if (mysqli_num_rows($result) == 0) {
        $nilai = 1;
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $nilai = $row['nilai'];
        }
    }

    return $nilai;
}

// memasukkan bobot nilai perbandingan kriteria
function inputDataPerbandinganKriteria($kriteria1, $kriteria2, $nilai)
{
    global $koneksi;

    $id_kriteria1 = getKriteriaID($kriteria1);
    $id_kriteria2 = getKriteriaID($kriteria2);

    $query  = "SELECT * FROM perbandingan_kriteria WHERE kriteria1 = $id_kriteria1 AND kriteria2 = $id_kriteria2";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Error !!!";
        exit();
    }

    // jika result kosong maka masukkan data baru
    // jika telah ada maka diupdate
    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO perbandingan_kriteria (kriteria1,kriteria2,nilai) VALUES ($id_kriteria1,$id_kriteria2,$nilai)";
    } else {
        $query = "UPDATE perbandingan_kriteria SET nilai=$nilai WHERE kriteria1=$id_kriteria1 AND kriteria2=$id_kriteria2";
    }

    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "Gagal memasukkan data perbandingan";
        exit();
    }
}

// memasukkan nilai priority vektor kriteria
function inputKriteriaPV($id_kriteria, $pv)
{
    global $koneksi;

    $query = "SELECT * FROM pv_kriteria WHERE id_kriteria=$id_kriteria";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Error !!!";
        exit();
    }

    // jika result kosong maka masukkan data baru
    // jika telah ada maka diupdate
    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO pv_kriteria (id_kriteria, nilai) VALUES ($id_kriteria, $pv)";
    } else {
        $query = "UPDATE pv_kriteria SET nilai=$pv WHERE id_kriteria=$id_kriteria";
    }


    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "Gagal memasukkan / update nilai priority vector kriteria";
        exit();
    }
}

// count alternatif
function getJumlahAlternatif()
{
    global $koneksi;

    $query  = "SELECT count(*) FROM alternatif";
    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_array($result)) {
        $jmlData = $row[0];
    }

    return $jmlData;
}

// mencari ID alternatif
// berdasarkan urutan ke berapa (A1, A2, A3)
function getAlternatifID($no_urut)
{
    global $koneksi;
    $query  = "SELECT id FROM alternatif ORDER BY id";
    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_array($result)) {
        $listID[] = $row['id'];
    }

    return $listID[($no_urut)];
}

// mencari nama alternatif
function getAlternatifNama($no_urut)
{
    global $koneksi;
    $query  = "SELECT nama FROM alternatif ORDER BY id";
    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_array($result)) {
        $nama[] = $row['nama'];
    }

    return $nama[($no_urut)];
}

// mencari priority vector alternatif
function getAlternatifPV($id_alternatif, $id_kriteria)
{
    global $koneksi;
    $query = "SELECT nilai FROM pv_alternatif WHERE id_alternatif=$id_alternatif AND id_kriteria=$id_kriteria";
    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_array($result)) {
        $pv = $row['nilai'];
    }


    return $pv;
}

// hapus alternatif
function deleteAlternatif($id)
{
    global $koneksi;

    // hapus record dari tabel alternatif
    $query     = "DELETE FROM alternatif WHERE id=$id";
    mysqli_query($koneksi, $query);

    // hapus record dari tabel pv_alternatif
    $query     = "DELETE FROM pv_alternatif WHERE id_alternatif=$id";
    mysqli_query($koneksi, $query);

    // hapus record dari tabel ranking
    $query     = "DELETE FROM ranking WHERE id_alternatif=$id";
    mysqli_query($koneksi, $query);

    $query     = "DELETE FROM perbandingan_alternatif WHERE alternatif1=$id OR alternatif2=$id";
    mysqli_query($koneksi, $query);
}

// mencari nilai bobot perbandingan alternatif
function getNilaiPerbandinganAlternatif($alternatif1, $alternatif2, $pembanding)
{
    global $koneksi;

    $id_alternatif1 = getAlternatifID($alternatif1);
    $id_alternatif2 = getAlternatifID($alternatif2);
    $id_pembanding  = getKriteriaID($pembanding);

    $query  = "SELECT nilai FROM perbandingan_alternatif WHERE alternatif1 = $id_alternatif1 AND alternatif2 = $id_alternatif2 AND pembanding = $id_pembanding";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Error !!!";
        exit();
    }
    if (mysqli_num_rows($result) == 0) {
        $nilai = 1;
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $nilai = $row['nilai'];
        }
    }

    return $nilai;
}

// memasukkan bobot nilai perbandingan alternatif
function inputDataPerbandinganAlternatif($alternatif1, $alternatif2, $pembanding, $nilai)
{
    global $koneksi;


    $id_alternatif1 = getAlternatifID($alternatif1);
    $id_alternatif2 = getAlternatifID($alternatif2);
    $id_pembanding  = getKriteriaID($pembanding);

    $query  = "SELECT * FROM perbandingan_alternatif WHERE alternatif1 = $id_alternatif1 AND alternatif2 = $id_alternatif2 AND pembanding = $id_pembanding";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Error !!!";
        exit();
    }

    // jika result kosong maka masukkan data baru
    // jika telah ada maka diupdate
    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO perbandingan_alternatif (alternatif1,alternatif2,pembanding,nilai) VALUES ($id_alternatif1,$id_alternatif2,$id_pembanding,$nilai)";
    } else {
        $query = "UPDATE perbandingan_alternatif SET nilai=$nilai WHERE alternatif1=$id_alternatif1 AND alternatif2=$id_alternatif2 AND pembanding=$id_pembanding";
    }

    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "Gagal memasukkan data perbandingan";
        exit();
    }
}

// memasukkan nilai priority vektor alternatif
function inputAlternatifPV($id_alternatif, $id_kriteria, $pv)
{
    global $koneksi;

    $query  = "SELECT * FROM pv_alternatif WHERE id_alternatif = $id_alternatif AND id_kriteria = $id_kriteria";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Error !!!";
        exit();
    }

    // jika result kosong maka masukkan data baru
    // jika telah ada maka diupdate
    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO pv_alternatif (id_alternatif,id_kriteria,nilai) VALUES ($id_alternatif,$id_kriteria,$pv)";
    } else {
        $query = "UPDATE pv_alternatif SET nilai=$pv WHERE id_alternatif=$id_alternatif AND id_kriteria=$id_kriteria";
    }

    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "Gagal memasukkan / update nilai priority vector alternatif";
        exit();
    }
}

// count user
function getJumlahUser()
{
    global $koneksi;

    $query  = "SELECT count(*) FROM user";
    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_array($result)) {
        $jmlData = $row[0];
    }

    return $jmlData;
}

// get role user
function getRoleUser($username)
{
    global $koneksi;

    $query  = "SELECT role FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_array($result)) {
        $role = $row[0];
    }
    return $role;
}

// menampilkan nilai IR
function getNilaiIR($jmlKriteria)
{
    global $koneksi;
    $query  = "SELECT nilai FROM ir WHERE jumlah=$jmlKriteria";
    $result = mysqli_query($koneksi, $query);
    while ($row = mysqli_fetch_array($result)) {
        $nilaiIR = $row['nilai'];
    }

    return $nilaiIR;
}

// mencari Principe Eigen Vector (λ maks)
function getEigenVector($matrik_a, $matrik_b, $n)
{
    $eigenvektor = 0;
    for ($i = 0; $i <= ($n - 1); $i++) {
        $eigenvektor += ($matrik_a[$i] * (($matrik_b[$i]) / $n));
    }

    return $eigenvektor;
}

// mencari Cons Index
function getConsIndex($matrik_a, $matrik_b, $n)
{
    $eigenvektor = getEigenVector($matrik_a, $matrik_b, $n);
    $consindex = ($eigenvektor - $n) / ($n - 1);

    return $consindex;
}

// Mencari Consistency Ratio
function getConsRatio($matrik_a, $matrik_b, $n, $jenis)
{
    $consindex = getConsIndex($matrik_a, $matrik_b, $n);
    $nilaiIR = getNilaiIR($n);
    if ($nilaiIR == 0) {
        header("Location: ../samples/error-404.php?Ir=0&jenis=$jenis");
    } else {
        $consratio = $consindex / $nilaiIR;
    }


    return $consratio;
}

// function untuk menghitung nilai bobot berdasarkan kriteria
function showTabelPerbandingan($jenis, $kriteria)
{
    global $koneksi;


    if ($kriteria == 'kriteria') {
        $n = getJumlahKriteria();
    } else {
        $n = getJumlahAlternatif();
    }

    $query = "SELECT nama FROM $kriteria ORDER BY id";
    $result    = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "Error koneksi database!!!";
        exit();
    }

    // buat list nama pilihan
    while ($row = mysqli_fetch_array($result)) {
        $pilihan[] = $row['nama'];
    }

    // tampilkan tabel
?>
    <form action="../../pages-admin/kelola-data/hitung.php" method="post">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="2">Pilih Yang Penting</th>
                    <th>Nilai Kepentingan</th>
                </tr>
            </thead>

            <tbody>
                <?php

                //inisialisasi
                $urut = 0;

                for ($x = 0; $x <= ($n - 2); $x++) {
                    for ($y = ($x + 1); $y <= ($n - 1); $y++) {

                        $urut++;

                ?>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="pilih<?php echo $urut ?>" value="1" checked="" class="hidden" />
                                        <?php echo $pilihan[$x]; ?>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="pilih<?php echo $urut ?>" value="2" class="hidden" />
                                        <?php echo $pilihan[$y]; ?>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="field">

                                    <?php
                                    if ($kriteria == 'kriteria') {
                                        $nilai = getNilaiPerbandinganKriteria($x, $y);
                                    } else {
                                        $nilai = getNilaiPerbandinganAlternatif($x, $y, ($jenis - 1));
                                    }

                                    ?>
                                    <input type="text" name="bobot<?php echo $urut ?>" value="<?php echo $nilai ?>" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" required>
                                </div>
                            </td>
                        </tr>
                <?php
                    }
                }

                ?>
            </tbody>
        </table>
        <input type="text" name="jenis" value="<?php echo $jenis; ?>" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" hidden>
        <br><br><button type="submit" name="submit" class="btn btn-gradient-primary mb-2 float-right">CHECK</button>
    </form>

<?php
}

?>