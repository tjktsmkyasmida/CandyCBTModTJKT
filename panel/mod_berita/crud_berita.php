<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_admin();
(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';
if ($pg == 'tambah') {
    $ujian = fetch($koneksi, 'ujian', ['id_ujian' => $_POST['id_ujian']]);
    $id_mapel = $ujian['id_mapel'];
    $sesi = $_POST['sesi'];
    $ruang = $_POST['ruang'];
    $kode_ujian = $ujian['kode_ujian'];
    $mulai = $_POST['mulai'];
    $selesai = $_POST['selesai'];
    $nama_proktor = $_POST['nama_proktor'];
    $nip_proktor = $_POST['nip_proktor'];
    $nama_pengawas = $_POST['nama_pengawas'];
    $nip_pengawas = $_POST['nip_pengawas'];
    $catatan = $_POST['catatan'];
    $tgl_ujian = $_POST['tgl_ujian'];
    $nosusulan = serialize($_POST['nosusulan']);
    $hadir = $_POST['hadir'];
    $tidakhadir = $_POST['tidakhadir'];
    $data = array(
        'id_mapel' => $id_mapel,
        'sesi' => $sesi,
        'ruang' => $ruang,
        'jenis' => $kode_ujian,
        'mulai' => $mulai,
        'selesai' => $selesai,
        'nama_proktor' => $nama_proktor,
        'nip_proktor' => $nip_proktor,
        'nama_pengawas' => $nama_pengawas,
        'nip_pengawas' => $nip_pengawas,
        'catatan' => $catatan,
        'tgl_ujian' => $tgl_ujian,
        'no_susulan' => $nosusulan,
        'ikut' => $hadir,
        'susulan' => $tidakhadir
    );
    $where = [
        'id_mapel' => $id_mapel,
        'sesi' => $sesi,
        'ruang' => $ruang
    ];
    $cekberita = rowcount($koneksi, 'berita', $where);
    if ($cekberita == 0) {
        $tabel = 'berita';
        $cek = insert($koneksi, $tabel, $data);
        echo mysqli_error($koneksi);
        if ($cek == true) {
            echo "oke";
        } else {
            echo "no";
        }
    } else {
        echo "berita acara gagal dibuat";
    }
}

if ($pg == 'hapus') {
    $kode = $_POST['id'];
    $exec = mysqli_query($koneksi, "DELETE FROM berita WHERE id_berita='$kode'");
}

if ($pg == 'list_siswa') {
    $sesi = $_POST['sesi'];
    $ruang = $_POST['ruang'];
    $sql = mysqli_query($koneksi, "SELECT * FROM siswa WHERE ruang ='$ruang' and sesi='$sesi'");
    echo "<option value=''>Pilih Siswa</option>";
    while ($siswa = mysqli_fetch_array($sql)) {
        echo "<option value='$siswa[no_peserta]'>$siswa[no_peserta] - $siswa[nama]</option>";
    }
}
