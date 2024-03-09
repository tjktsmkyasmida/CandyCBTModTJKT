<?php
require '../../config/config.default.php';
require '../../config/config.function.php';
cek_session_admin();
$datax = http_request($setting['url_host'] . "/syncsiswa.php?token=" . $setting['token_api'] .  "&server=" . $setting['id_server']);
$r = json_decode($datax, TRUE);
if ($r <> null) {
    echo "<h3 class='text-white'>Terhubung</h3>";
} else {
    echo "<h3 class='text-red'>Tidak Ada Koneksi</h3>";
}
