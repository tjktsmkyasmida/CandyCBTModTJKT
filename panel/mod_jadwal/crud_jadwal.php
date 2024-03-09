<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_guru();
(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';
if ($pg == 'ubah') {
    $wkt = explode(" ",  $_POST['tgl_ujian']);
    $wkt_ujian = $wkt[1];
    $id = $_POST['idm'];
    $acak = (isset($_POST['acak'])) ? 1 : 0;
    $token = (isset($_POST['token'])) ? 1 : 0;
    $hasil = (isset($_POST['hasil'])) ? 1 : 0;
    $acakopsi = (isset($_POST['acakopsi'])) ? 1 : 0;
    $reset = (isset($_POST['reset'])) ? 1 : 0;
    $ulangkkm = (isset($_POST['ulangkkm'])) ? 1 : 0;
    $data = [
        'lama_ujian'         => $_POST['lama_ujian'],
        'tgl_ujian'        => $_POST['tgl_ujian'],
        'tgl_selesai'        => $_POST['tgl_selesai'],
        'waktu_ujian' => $wkt_ujian,
        'sesi'       => $_POST['sesi'],
        'acak'        => $acak,
        'token'        => $token,
        'hasil'        => $hasil,
        'ulang'        => $acakopsi,
        'reset'        => $reset,
        'btn_selesai'       => $_POST['btn_selesai'],
        'ulang_kkm'        => $ulangkkm,
        'pelanggaran'       => $_POST['pelanggaran']
    ];
    $exec = update($koneksi, 'ujian', $data, ['id_ujian' => $id]);
    echo mysqli_error($koneksi);
}
if ($pg == 'tambah') {
    $wkt = explode(" ",  $_POST['tgl_ujian']);
    $wkt_ujian = $wkt[1];
    $acak = (isset($_POST['acak'])) ? 1 : 0;
    $token = (isset($_POST['token'])) ? 1 : 0;
    $hasil = (isset($_POST['hasil'])) ? 1 : 0;
    $acakopsi = (isset($_POST['acakopsi'])) ? 1 : 0;
    $reset = (isset($_POST['reset'])) ? 1 : 0;
    $ulangkkm = (isset($_POST['ulangkkm'])) ? 1 : 0;
    $bank = fetch($koneksi, 'mapel', ['id_mapel' => $_POST['idmapel']]);
    $data = [
        'id_pk'     => $bank['idpk'],
        'id_mapel'         => $_POST['idmapel'],
        'nama'          => $bank['kode'],
        'jml_soal'   => $bank['jml_soal'],
        'jml_esai'         => $bank['jml_esai'],
        'lama_ujian'         => $_POST['lama_ujian'],
        'tgl_ujian'        => $_POST['tgl_ujian'],
        'tgl_selesai'        => $_POST['tgl_selesai'],
        'waktu_ujian'     => $wkt_ujian,
        'level'     => $bank['level'],
        'sesi'       => $_POST['sesi'],
        'acak'        => $acak,
        'token'        => $token,
        'status'        => 1,
        'bobot_pg'        => $bank['bobot_pg'],
        'bobot_esai'        => $bank['bobot_esai'],
        'id_guru'        => $_SESSION['id_pengawas'],
        'tampil_pg'        => $bank['tampil_pg'],
        'tampil_esai'        => $bank['tampil_esai'],
        'hasil'        => $hasil,
        'kelas'        => $bank['kelas'],
        'opsi'        => $bank['opsi'],
        'kode_ujian'        => $_POST['kode_ujian'],
        'kkm'        => $bank['kkm'],
        'ulang'        => $acakopsi,
        'soal_agama'        => $bank['soal_agama'],
        'kode_nama'        => $bank['kode'],
        'reset'        => $reset,
        'btn_selesai'       => $_POST['btn_selesai'],
        'ulang_kkm'        => $ulangkkm,
        'pelanggaran'       => $_POST['pelanggaran']
    ];
    $cek = rowcount($koneksi, 'ujian', ['kode_nama' => $bank['kode'], 'sesi' => $_POST['sesi']]);
    if ($cek > 0) {
        echo "jadwal sudah ada";
    } else {
        $exec = insert($koneksi, 'ujian', $data);
        if ($exec) {
            echo $exec;
        } else {
            echo mysqli_error($koneksi);
        }
    }
}
if ($pg == 'aktivasi') {
    foreach ($_POST['ujian'] as $ujian) {
        if ($_POST['aksi'] <> 'hapus') {
            $exec = update($koneksi, 'ujian', ['status' => $_POST['aksi'], 'sesi' => $_POST['sesi']], ['id_ujian' => $ujian]);
            if ($exec) {
                echo "update";
            }
        } else {
            $exec = delete($koneksi, 'ujian', ['id_ujian' => $ujian]);
            if ($exec) {
                echo "hapus";
            }
        }
    }
}
if ($pg == 'token') {
    function create_random($length)
    {
        $data = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $pos = rand(0, strlen($data) - 1);
            $string .= $data[$pos];
        }
        return $string;
    }
    $token = create_random(6);
    $now = date('Y-m-d H:i:s');
    echo $token;
    $cek = rowcount($koneksi, 'token');
    if ($cek <> 0) {
        $query = fetch($koneksi, 'token');
        $time = $query['time'];
        $tgl = buat_tanggal('H:i:s', $time);
        $exec = update($koneksi, 'token', ['token' => $token, 'time' => $now], ['id_token' => 1]);
    } else {
        $exec = insert($koneksi, 'token', ['token' => $token, 'masa_berlaku' => '00:15:00']);
    }
}
