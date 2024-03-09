<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_guru();
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
    $mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel where id_mapel='$id_mapel' "));
    echo "<option value=''>Pilih kelas</option>";
    $kelas = unserialize($mapel['kelas']);
    $kk = implode("", $kelas);
    if ($kk == 'semua') {
        if ($mapel['level'] == 'semua') {
            $qkelas = mysqli_query($koneksi, "SELECT * FROM kelas");
        } else {
            $qkelas = mysqli_query($koneksi, "SELECT * FROM kelas where level='$mapel[level]'");
        }

        while ($data = mysqli_fetch_array($qkelas)) {
            echo "<option value='$data[id_kelas]'>$data[id_kelas]</option>";
        }
    } else {
        foreach ($kelas as $kelas) {
            echo "<option value='$kelas'>$kelas</option>";
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
