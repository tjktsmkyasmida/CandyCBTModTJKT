<?php

require("../config/config.default.php");
require("../config/config.function.php");
cek_session_admin();
$kode = $_POST['id'];

$exec = mysqli_query($koneksi, "DELETE FROM nilai WHERE id_ujian='$kode' and ujian_selesai<>''");
