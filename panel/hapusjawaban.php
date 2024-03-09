<?php

require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
cek_session_admin();
$exec = mysqli_query($koneksi, "DELETE jawaban FROM jawaban JOIN nilai ON jawaban.id_ujian=nilai.id_ujian where nilai.ujian_selesai<>''");
if ($exec) {
    echo "Hapus Berhasil";
} else {
    echo mysqli_error($koneksi);
}
