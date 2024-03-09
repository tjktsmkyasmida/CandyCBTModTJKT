<?php
require "../config/config.default.php";
require "../config/config.function.php";
cek_session_admin();
if ($setting['server'] == 'pusat') {
    $status = 'lokal';
} else {
    $status = 'pusat';
}
$exec = mysqli_query($koneksi, "update setting set server='$status' where id_setting='1'");
