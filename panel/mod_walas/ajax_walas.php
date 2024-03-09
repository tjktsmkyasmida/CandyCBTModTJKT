<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_guru();
(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';
if ($pg == 'selesaikan') {
    $idnilai = $_POST['id'];
    $nilai = fetch($koneksi, 'nilai', array('id_nilai' => $idnilai));
    $idm = $nilai['id_mapel'];
    $ids = $nilai['id_siswa'];
    $idu = $nilai['id_ujian'];
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
    $bagi = $mapel['jml_soal'] / 100;
    $bobot = $mapel['bobot_pg'] / 100;
    $skor = ($benar / $bagi) * $bobot;
    $data = array(
        'ujian_selesai' => $datetime,
        'jml_benar' => $benar,
        'jml_salah' => $salah,
        'skor' => round($skor, 2),
        'total' => round($skor, 2),
        'online' => 0,
        'jawaban' => serialize($arrayjawab),
        'jawaban_esai' => serialize($arrayjawabesai)
    );
    $simpan = update($koneksi, 'nilai', $data, $where);
    if ($simpan) {
        echo "Berhasil diselesaikan";
    }
    echo mysqli_error($koneksi);
    mysqli_query($koneksi, "INSERT INTO log (id_siswa,type,text,date) VALUES ('$ids','login','Selesai Ujian','$tanggal $waktu')");
}
if ($pg == 'selesaisemua') {
    if (empty($_GET['id'])) {
        $query = mysqli_query($koneksi, "SELECT * FROM nilai where skor is null");
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM nilai where skor is null and id_ujian='$_GET[id]'");
    }

    while ($nilai = mysqli_fetch_assoc($query)) {
        $idm = $nilai['id_mapel'];
        $ids = $nilai['id_siswa'];
        $idu = $nilai['id_ujian'];
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
        $bagi = $mapel['jml_soal'] / 100;
        $bobot = $mapel['bobot_pg'] / 100;
        $skor = ($benar / $bagi) * $bobot;
        $skor = round($skor, 2);
        $data = array(
            'ujian_selesai' => $datetime,
            'jml_benar' => $benar,
            'jml_salah' => $salah,
            'skor' => $skor,
            'total' => $skor,
            'online' => 0,
            'jawaban' => serialize($arrayjawab),
            'jawaban_esai' => serialize($arrayjawabesai)
        );
        $simpan = update($koneksi, 'nilai', $data, $where);
        if ($simpan) {
            echo "Berhasil diselesaikan";
        }
        echo mysqli_error($koneksi);
        mysqli_query($koneksi, "INSERT INTO log (id_siswa,type,text,date) VALUES ('$ids','login','Selesai Ujian','$tanggal $waktu')");
    }
}
if ($pg == 'resetlogin') {
    $kode = $_POST['kode'];
    $query = mysqli_query($koneksi, "UPDATE nilai set online='0' where id_nilai in (" . $kode . ")");
    if ($query) {
        echo 1;
    } else {
        echo 0;
    }
}
if ($pg == 'ulangujian') {
    $idnilai = $_POST['id'];
    $nilai = fetch($koneksi, 'nilai', array('id_nilai' => $idnilai));
    $idu = $nilai['id_ujian'];
    $idm = $nilai['id_mapel'];
    $ids = $nilai['id_siswa'];
    $where2 = array(
        'id_mapel' => $idm,
        'id_siswa' => $ids,
        'id_ujian' => $idu
    );
    delete($koneksi, 'nilai', ['id_nilai' => $idnilai]);
    delete($koneksi, 'jawaban', $where2);
}

if ($pg == 'statusaktif') {
    $kode = $_POST['kode'];
    $query = mysqli_query($koneksi, "UPDATE siswa set status='aktif' where id_siswa in (" . $kode . ")");
    if ($query) {
        echo 1;
    } else {
        echo 0;
    }
}
if ($pg == 'statusnonaktif') {
    $kode = $_POST['kode'];
    $query = mysqli_query($koneksi, "UPDATE siswa set status='tidak' where id_siswa in (" . $kode . ")");
    if ($query) {
        echo 1;
    } else {
        echo 0;
    }
}
