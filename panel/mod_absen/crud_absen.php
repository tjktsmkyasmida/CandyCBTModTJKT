<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_admin();
(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';
if ($pg == 'ambil_ruang') {
    $sql = mysqli_query($koneksi, "SELECT * FROM siswa  GROUP BY ruang");
    echo "<option value=''>Pilih Ruang</option>";
    while ($ruang = mysqli_fetch_array($sql)) {
        echo "<option value='$ruang[ruang]'>$ruang[ruang]</option>";
    }
}
if ($pg == 'ambil_kelas') {
    $id_mapel = $_POST['mapel_id'];
    $ruang = $_POST['ruang'];
    $sesi = $_POST['sesi'];
    $sql = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$id_mapel'"));
    $dataArray = unserialize($sql['kelas']);
    if (count($dataArray) == 1) {
        if ($dataArray[0] == "semua") {
            $status = 0;
            if ($sql['level'] == "semua") {
                $data = mysqli_query($koneksi, "SELECT * FROM siswa where ruang='$ruang' and sesi='$sesi' group by id_kelas");
            } else {
                $tingkat = $sql['level'];
                $data = mysqli_query($koneksi, "SELECT * FROM siswa WHERE ruang='$ruang' and sesi='$sesi' and level='$tingkat' group by id_kelas");
            }
            echo "<option value=''>Pilih Kelas</option>";
            while ($kelas = mysqli_fetch_array($data)) {
                echo "<option value='$kelas[id_kelas]'>$kelas[id_kelas]</option>";
            }
        } else {
            echo "<option value=''>Pilih Kelas</option>";
            foreach ($dataArray as $key => $value) {
                echo "<option value='$value'>$value</option>";
            }
        }
    } elseif (count($dataArray) > 1) {
        echo "<option value=''>Pilih Kelas</option>";
        foreach ($dataArray as $key => $value) {
            echo "<option value='$value'>$value</option>";
        }
    }
}
if ($pg == 'ambil_sesi') {
    $ruang = $_POST['ruang'];
    $sql = mysqli_query($koneksi, "SELECT * FROM siswa WHERE ruang ='$ruang' GROUP BY sesi");
    echo "<option value=''>Pilih Sesi</option>";
    while ($sesi = mysqli_fetch_array($sql)) {
        echo "<option value='$sesi[sesi]'>$sesi[sesi]</option>";
    }
}
