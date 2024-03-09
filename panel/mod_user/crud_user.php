<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_admin();
(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';
if ($pg == 'ubah') {

    if ($_POST['password'] <> "") {
        $data = [
            'username'     => $_POST['username'],
            'nama'   => $_POST['nama'],
            'level'         => $_POST['level'],
            'password'      => password_hash($_POST['password'], PASSWORD_DEFAULT)

        ];
    } else {
        $data = [
            'username'     => $_POST['username'],
            'nama'   => $_POST['nama'],
            'level'         => $_POST['level']

        ];
    }
    $id_pengawas = $_POST['id_user'];
    $exec = update($koneksi, 'pengawas', $data, ['id_pengawas' => $id_pengawas]);
    echo $exec;
}
if ($pg == 'tambah') {
    $data = [
        'nip'          => '-',
        'username'     => $_POST['username'],
        'nama'   => $_POST['nama'],
        'level'         => $_POST['level'],
        'password'      => password_hash($_POST['password'], PASSWORD_DEFAULT)

    ];
    $exec = insert($koneksi, 'pengawas', $data);
    echo $exec;
}
if ($pg == 'hapus') {
    $id_pengawas = $_POST['id_user'];
    delete($koneksi, 'pengawas', ['id_pengawas' => $id_pengawas]);
}
