<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_guru();
(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';
if ($pg == 'ubah') {
    $id = $_POST['idu'];
    if (isset($_POST['status'])) {
        $status = $_POST['status'];
    } else {
        $status = 'tidak';
    }
    if (isset($_POST['idpk'])) {
        $pk = $_POST['idpk'];
    } else {
        $pk = 'semua';
    }
    if ($_POST['pass1'] <> '') {

        $data = [
            'id_kelas'     => $_POST['id_kelas'],
            'idpk'         => $pk,
            'nis'          => $_POST['nis'],
            'no_peserta'   => $_POST['no_peserta'],
            'nama'         => str_replace("'", "&#39;", $_POST['nama']),
            'sesi'         => $_POST['idsesi'],
            'ruang'        => $_POST['ruang'],
            'level'        => $_POST['level'],
            'username'     => $_POST['username'],
            'password'     => $_POST['pass1'],
            'server'       => $_POST['server'],
            'agama'        => $_POST['agama'],
            'status'       => $status,
            'hp'        => $_POST['hp']
        ];
    } else {
        $data = [
            'id_kelas'     => $_POST['id_kelas'],
            'idpk'         => $pk,
            'nis'          => $_POST['nis'],
            'no_peserta'   => $_POST['no_peserta'],
            'nama'         => str_replace("'", "&#39;", $_POST['nama']),
            'sesi'         => $_POST['idsesi'],
            'ruang'        => $_POST['ruang'],
            'level'        => $_POST['level'],
            'username'     => $_POST['username'],

            'server'       => $_POST['server'],
            'agama'        => $_POST['agama'],
            'status'       => $status,
            'hp'        => $_POST['hp']
        ];
    }

    if ($_POST['pass1'] <> $_POST['pass2']) {
        echo "password tidak sama";
    } else {
        $exec = update($koneksi, 'siswa', $data, ['id_siswa' => $id]);
        echo $exec;
    }
}
if ($pg == 'tambah') {
    if (isset($_POST['idpk'])) {
        $pk = $_POST['idpk'];
    } else {
        $pk = 'semua';
    }
    $data = [
        'id_kelas'     => $_POST['id_kelas'],
        'idpk'         => $pk,
        'nis'          => $_POST['nis'],
        'no_peserta'   => $_POST['no_peserta'],
        'nama'         => str_replace("'", "&#39;", $_POST['nama']),
        'sesi'         => $_POST['idsesi'],
        'ruang'        => $_POST['ruang'],
        'level'        => $_POST['level'],
        'username'     => $_POST['username'],
        'password'     => $_POST['pass1'],
        'server'       => $_POST['server'],
        'agama'        => $_POST['agama'],
        'hp'        => $_POST['hp']
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
if ($pg == 'hapus') {
    $id_siswa = $_POST['id_siswa'];
    delete($koneksi, 'siswa', ['id_siswa' => $id_siswa]);
}
if ($pg == 'ambil_siswa') {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
        // include '../config/config.default.php';
        $query = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY nama ASC");
        $jsonResult = '{"data" : [ ';
        $i = 0;
        while ($data = mysqli_fetch_assoc($query)) {
            if ($i != 0) {
                $jsonResult .= ',';
            }
            $jsonResult .= json_encode($data);
            $i++;
        }
        $jsonResult .= ']}';
        echo $jsonResult;
    } else {
        echo '<script>window.location="404.html"</script>';
    }
}
if ($pg == 'uploadfoto') {
    if (isset($_POST["uplod"])) {
        $output = '';
        if ($_FILES['zip_file']['name'] != '') {
            $file_name = $_FILES['zip_file']['name'];
            $array = explode(".", $file_name);
            $name = $array[0];
            $ext = $array[1];
            if ($ext == 'zip') {
                $path = '../foto/fotosiswa/';
                $location = $path . $file_name;
                if (move_uploaded_file($_FILES['zip_file']['tmp_name'], $location)) {
                    $zip = new ZipArchive;
                    if ($zip->open($location)) {
                        $zip->extractTo($path);
                        $zip->close();
                    }
                    $files = scandir($path);
                    foreach ($files as $file) {
                        $file_ext = pathinfo($file, PATHINFO_EXTENSION);
                        $allowed_ext = array('jpg', 'JPG', 'png');
                        if (in_array($file_ext, $allowed_ext)) {
                            $tmp = explode(".", $file);
                            $nama = $tmp[0];
                            $output .= '<div class="col-md-3"><div style="padding:16px; border:1px solid #CCC;"><img class="img img-responsive" style="height:150px;" src="../foto/fotosiswa/' . $file . '" /></div></div>';
                            mysqli_query($koneksi, "UPDATE siswa set foto='$file' where username='$nama'");
                        }
                    }
                    unlink($location);
                    $pesan = "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-check'></i> Info</h4>Upload File zip berhasil</div>";
                }
            } else {
                $pesan = "<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-info'></i> Gagal Upload</h4>Mohon Upload file zip</div>";
            }
        }
    }
}
