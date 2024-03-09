<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_admin();
(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';
if ($pg == 'setting_app') {
    $alamat = nl2br($_POST['alamat']);
    $header = nl2br($_POST['header']);
    $data = [
        'token_api' => $_POST['token_api'],
        'aplikasi' => $_POST['aplikasi'],
        'sekolah' => $_POST['sekolah'],
        'kode_sekolah' => $_POST['kode'],
        'jenjang' => $_POST['jenjang'],
        'kepsek' => $_POST['kepsek'],
        'nip' => $_POST['nip'],
        'alamat' => $alamat,
        'kecamatan' => $_POST['kecamatan'],
        'kota' => $_POST['kota'],
        'telp' => $_POST['telp'],
        'fax' => $_POST['fax'],
        'web' => $_POST['web'],
        'email' => $_POST['email'],
        'header' => $header,
        'ip_server' => $_POST['ipserver'],
        'waktu' => $_POST['waktu']
    ];
    $exec = update($koneksi, 'setting', $data, ['id_setting' => 1]);
    if ($exec) {
        $ektensi = ['jpg', 'png'];
        if ($_FILES['logo']['name'] <> '') {
            $logo = $_FILES['logo']['name'];
            $temp = $_FILES['logo']['tmp_name'];
            $ext = explode('.', $logo);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $dest = 'dist/img/logo' . rand(1, 100) . '.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $dest);
                if ($upload) {
                    $exec = update($koneksi, 'setting', ['logo' => $dest], ['id_setting' => 1]);
                } else {
                    echo "gagal";
                }
            }
        }
        if ($_FILES['ttd']['name'] <> '') {
            $logo = $_FILES['ttd']['name'];
            $temp = $_FILES['ttd']['tmp_name'];
            $ext = explode('.', $logo);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $dest = 'dist/img/ttd' . '.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $dest);
            }
        }
        if ($_FILES['bc']['name'] <> '') {
            $logo = $_FILES['bc']['name'];
            $temp = $_FILES['bc']['tmp_name'];
            $ext = explode('.', $logo);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                $dest = 'dist/img/bc' . '.' . $ext;
                $upload = move_uploaded_file($temp, '../../' . $dest);
                if ($upload) {
                    $exec = update($koneksi, 'setting', ['bc' => $dest], ['id_setting' => 1]);
                } else {
                    echo "gagal";
                }
            }
        }
    } else {
        echo "Gagal menyimpan";
    }
}
if ($pg == 'tambah') {
    $data = [
        'id_kelas'     => $_POST['id_kelas'],
        'idpk'         => $_POST['idpk'],
        'nis'          => $_POST['nis'],
        'no_peserta'   => $_POST['no_peserta'],
        'nama'         => str_replace("'", "&#39;", $_POST['nama']),
        'sesi'         => $_POST['idsesi'],
        'ruang'        => $_POST['ruang'],
        'level'        => $_POST['level'],
        'username'     => $_POST['username'],
        'password'     => $_POST['pass1'],
        'server'       => $_POST['server'],
        'agama'        => $_POST['agama']
    ];
    $cekuser = rowcount($koneksi, 'siswa', ['username' => $_POST['username']]);
    if ($cekuser > 0) {
        echo "username sudah ada";
    } else {
        if ($_POST['pass1'] <> $_POST['pass2']) {
            echo "password tidak sama";
        } else {
            $exec = insert($koneksi, 'siswa', $data);
            echo $exec;
        }
    }
}
if ($pg == 'setting_clear') {
    $pengawas = fetch($koneksi, 'pengawas', ['id_pengawas' => $_SESSION['id_pengawas']]);
    $password = $_POST['password'];
    if (!password_verify($password, $pengawas['password'])) {
        echo "password salah";
    } else {
        if (!empty($_POST['data'])) {
            $data = $_POST['data'];
            if ($data <> '') {
                foreach ($data as $table) {
                    if ($table <> 'pengawas') {
                        mysqli_query($koneksi, "TRUNCATE $table");
                    } else {
                        mysqli_query($koneksi, "DELETE FROM $table WHERE level!='admin'");
                    }
                }
                echo "ok";
            }
        }
    }
}
if ($pg == 'setting_restore') {
    function restore($file)
    {
        require("../../config/config.database.php");
        global $rest_dir;
        $nama_file    = $file['name'];
        $ukrn_file    = $file['size'];
        $tmp_file    = $file['tmp_name'];

        if ($nama_file == "") {
            echo "Fatal Error";
        } else {
            $alamatfile    = $rest_dir . $nama_file;
            $templine    = array();

            if (move_uploaded_file($tmp_file, $alamatfile)) {

                $templine    = '';

                $lines    = file($alamatfile);

                foreach ($lines as $line) {
                    if (substr($line, 0, 2) == '--' || $line == '')
                        continue;

                    $templine .= $line;

                    if (substr(trim($line), -1, 1) == ';') {
                        mysqli_query($koneksi, $templine);
                        $templine = '';
                    }
                }
            } else {
                echo "Proses upload gagal, kode error = " . $file['error'];
            }
        }
    }
    restore($_FILES['datafile']);
    if (isset($_FILES['datafile'])) {
        echo "data berhasil di restore";
    }
}
