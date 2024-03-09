<?php
require "config/config.default.php";
require "config/config.function.php";
require "config/functions.crud.php";
cek_session_siswa();
$id_siswa = $_SESSION['id_siswa'];
(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';
if ($pg == 'statusonline') {
    $data = [
        'online' => 1
    ];
    $exec = update($koneksi, 'siswa', $data, ['id_siswa' => $id_siswa]);
}
if ($pg == 'statusoffline') {
    $data = [
        'online' => 0
    ];
    $exec = update($koneksi, 'siswa', $data, ['id_siswa' => $id_siswa]);
}
if ($pg == 'ulangujian') {
    $idnilai = $_POST['id'];
    $nilai = fetch($koneksi, 'nilai_temp', array('id_nilai' => $idnilai));
    $idu = $nilai['id_ujian'];
    $idm = $nilai['id_mapel'];
    $ids = $nilai['id_siswa'];
    $where2 = array(
        'id_mapel' => $idm,
        'id_siswa' => $ids,
        'id_ujian' => $idu
    );
    delete($koneksi, 'nilai_temp', ['id_nilai' => $idnilai]);
    delete($koneksi, 'jawaban', $where2);
}
