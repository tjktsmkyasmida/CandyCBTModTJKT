<?php
require("config/config.default.php");
require("config/config.function.php");
require("config/functions.crud.php");
cek_session_siswa();
$idm = $_POST['id_mapel'];
$ids = $_POST['id_siswa'];
$idu = $_POST['id_ujian'];
$where = array(
    'id_mapel' => $idm,
    'id_siswa' => $ids,
    'id_ujian' => $idu
);
$benar = $salah = 0;
$mapel = fetch($koneksi, 'mapel', array('id_mapel' => $idm));
$siswa = fetch($koneksi, 'siswa', array('id_siswa' => $ids));
$ceksoal = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 1));
$ceksoalesai = select($koneksi, 'soal', array('id_mapel' => $idm, 'jenis' => 2));

$arrayjawabesai = array();
foreach ($ceksoalesai as $getsoalesai) {
    $w2 = array(
        'id_siswa' => $ids,
        'id_mapel' => $idm,
        'id_soal' => $getsoalesai['id_soal'],
        'jenis' => 2
    );
    // $cekjwbesai = rowcount($koneksi, 'jawaban', $w2);
    // if ($cekjwbesai <> 0) {
    $getjwb2 = fetch($koneksi, 'jawaban', $w2);
    if ($getjwb2) {
        $jawabxx = str_replace("'", "`", $getjwb2['esai']);
        $jawabxx = str_replace("#", ">>", $jawabxx);
        $jawabxx = preg_replace('/[^A-Za-z0-9\@\<\>\$\_\&\-\+\(\)\/\?\!\;\:\`\"\[\]\*\{\}\=\%\~\`\÷\× ]/', '', $jawabxx);
        $arrayjawabesai[$getsoalesai['id_soal']] = $jawabxx;
    } else {
        $arrayjawabesai[$getsoalesai['id_soal']] = 'Tidak Diisi';
    }
}
$arrayjawab = array();
foreach ($ceksoal as $getsoal) {
    $w = array(
        'id_siswa' => $ids,
        'id_mapel' => $idm,
        'id_soal' => $getsoal['id_soal'],
        'jenis' => 1
    );
    $getjwb = fetch($koneksi, 'jawaban', $w);
    if ($getjwb) {
        $arrayjawab[$getsoal['id_soal']] = $getjwb['jawaban'];
    } else {
        $arrayjawab[$getsoal['id_soal']] = 'X';
    }
    ($getjwb['jawaban'] == $getsoal['jawaban']) ? $benar++ : $salah++;
}
$bagi = $mapel['tampil_pg'] / 100;
$bobot = $mapel['bobot_pg'] / 100;
$skor = ($benar / $bagi) * $bobot;
$data = array(
    'ujian_selesai' => $datetime,
    'jml_benar' => $benar,
    'jml_salah' => $mapel['tampil_pg'] - $benar,
    'skor' => round($skor, 2),
    'total' => round($skor, 2),
    'online' => 0,
    'jawaban' => serialize($arrayjawab),
    'jawaban_esai' => serialize($arrayjawabesai)
);
$simpan = update($koneksi, 'nilai', $data, $where);
if($simpan){
    //mysqli_query($koneksi, "INSERT INTO jawaban (id_jawaban,id_siswa,id_mapel,id_soal,id_ujian,jawaban,jawabx,jenis,esai,nilai_esai,ragu) select id_jawaban,jawaban_temp.id_siswa,jawaban_temp.id_mapel,jawaban_temp.id_soal,jawaban_temp.id_ujian,jawaban_temp.jawaban,jawaban_temp.jawabx,jawaban_temp.jenis,jawaban_temp.esai,jawaban_temp.nilai_esai,jawaban_temp.ragu from jawaban_temp, nilai where jawaban_temp.id_ujian=nilai.id_ujian and jawaban_temp.id_mapel=nilai.id_mapel and jawaban_temp.id_siswa=nilai.id_siswa and nilai.ujian_selesai<>''");
    
    mysqli_query($koneksi, "DELETE jawaban FROM jawaban,nilai_temp where jawaban.id_ujian='$idu' and jawaban.id_mapel='$idm' and jawaban.id_siswa='$ids' and nilai_temp.ujian_selesai<>''");
    mysqli_query($koneksi, "DELETE FROM nilai_temp where id_ujian='$idu' and id_mapel='$idm' and id_siswa='$ids'");
}
//delete($koneksi, 'jawaban', $where);

mysqli_query($koneksi, "INSERT INTO log (id_siswa,type,text,date) VALUES ('$ids','login','Selesai Ujian','$tanggal $waktu')");
