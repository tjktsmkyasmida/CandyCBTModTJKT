<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
require("../../config/excel_reader2.php");
cek_session_guru();
(isset($_GET['pg'])) ? $pg = $_GET['pg'] : $pg = '';
if ($pg == 'import_candy') {
    if (isset($_FILES['file']['name'])) {
        $id_mapel = $_POST['id_mapel'];
        $file = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $ext = explode('.', $file);
        $ext = end($ext);
        if ($ext <> 'xls') {
            echo "harap pilih file excel .xls";
        } else {
            $data = new Spreadsheet_Excel_Reader($temp);
            $hasildata = $data->rowcount($sheet_index = 0);
            $sukses = $gagal = 0;
            $exec = mysqli_query($koneksi, "DELETE FROM soal WHERE id_mapel='$id_mapel' ");
            for ($i = 2; $i <= $hasildata; $i++) :
                $no = $data->val($i, 1);
                $soal = addslashes($data->val($i, 2));
                $pilA = addslashes($data->val($i, 3));
                $pilB = addslashes($data->val($i, 4));
                $pilC = addslashes($data->val($i, 5));
                $pilD = addslashes($data->val($i, 6));
                $pilE = addslashes($data->val($i, 7));
                $jawaban = $data->val($i, 8);
                $jenis = $data->val($i, 9);
                $file1 = $data->val($i, 10);
                $file2 = $data->val($i, 11);
                $fileA = $data->val($i, 12);
                $fileB = $data->val($i, 13);
                $fileC = $data->val($i, 14);
                $fileD = $data->val($i, 15);
                $fileE = $data->val($i, 16);
                $id_mapel = $_POST['id_mapel'];

                if ($soal <> '' and $jenis <> '') {
                    $exec = mysqli_query($koneksi, "INSERT INTO soal (id_mapel,nomor,soal,pilA,pilB,pilC,pilD,pilE,jawaban,jenis,file,file1,fileA,fileB, fileC,fileD,fileE) VALUES ('$id_mapel','$no','$soal','$pilA','$pilB','$pilC','$pilD','$pilE','$jawaban','$jenis','$file1','$file2','$fileA','$fileB','$fileC','$fileD','$fileE')");
                    if ($file1 <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$file1','$id_mapel')");
                    }
                    if ($file2 <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$file2','$id_mapel')");
                    }
                    if ($fileA <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileA','$id_mapel')");
                    }
                    if ($fileB <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileB','$id_mapel')");
                    }
                    if ($fileC <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileC','$id_mapel')");
                    }
                    if ($fileD <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileD','$id_mapel')");
                    }
                    if ($fileE <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileE','$id_mapel')");
                    }

                    ($exec) ? $sukses++ : $gagal++;
                } else {
                    $gagal++;
                }
            endfor;
            $total = $hasildata - 1;
            echo "Berhasil: $sukses | Gagal: $gagal | Dari: $total";
        }
    } else {
        echo "gagal";
    }
}
if ($pg == 'import_bee') {
    if (isset($_FILES['file']['name'])) :
        $id_mapel = $_POST['id_mapel'];
        $file = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $ext = explode('.', $file);
        $ext = end($ext);
        if ($ext <> 'xls') {
            $infobee = info('Gunakan file Ms. Excel 93-2007 Workbook (.xls)', 'NO');
        } else {

            $data = new Spreadsheet_Excel_Reader($temp);
            $hasildata = $data->rowcount($sheet_index = 0);
            $sukses = $gagal = 0;
            $exec = mysqli_query($koneksi, "delete from soal where id_mapel='$id_mapel' ");
            for ($i = 3; $i <= $hasildata; $i++) :
                $no = $data->val($i, 1);
                $soal = addslashes($data->val($i, 5));
                $pilA = addslashes($data->val($i, 6));
                $pilB = addslashes($data->val($i, 8));
                $pilC = addslashes($data->val($i, 10));
                $pilD = addslashes($data->val($i, 12));
                $pilE = addslashes($data->val($i, 14));
                $jawab = $data->val($i, 19);
                if ($jawab == '1') {
                    $jawaban = 'A';
                } elseif ($jawab == '2') {
                    $jawaban = 'B';
                } elseif ($jawab == '3') {
                    $jawaban = 'C';
                } elseif ($jawab == '4') {
                    $jawaban = 'D';
                } elseif ($jawab == '5') {
                    $jawaban = 'E';
                }
                $jenis = $data->val($i, 2);
                $file1 = $data->val($i, 18);
                $file2 = $data->val($i, 17);
                $fileA = $data->val($i, 7);
                $fileB = $data->val($i, 9);
                $fileC = $data->val($i, 11);
                $fileD = $data->val($i, 13);
                $fileE = $data->val($i, 15);
                $id_mapel = $_POST['id_mapel'];

                if ($jenis <> '' and $soal <> '') {
                    $exec = mysqli_query($koneksi, "INSERT INTO soal (id_mapel,nomor,soal,pilA,pilB,pilC,pilD,pilE,jawaban,jenis,file,file1,fileA,fileB, fileC,fileD,fileE) VALUES ('$id_mapel','$no','$soal','$pilA','$pilB','$pilC','$pilD','$pilE','$jawaban','$jenis','$file1','$file2','$fileA','$fileB','$fileC','$fileD','$fileE')");
                    ($exec) ? $sukses++ : $gagal++;
                    if ($file1 <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$file1','$id_mapel')");
                    }
                    if ($file2 <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$file2','$id_mapel')");
                    }
                    if ($fileA <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileA','$id_mapel')");
                    }
                    if ($fileB <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileB','$id_mapel')");
                    }
                    if ($fileC <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileC','$id_mapel')");
                    }
                    if ($fileD <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileD','$id_mapel')");
                    }
                    if ($fileE <> '') {
                        $sql = mysqli_query($koneksi, "insert into file_pendukung (nama_file,id_mapel) values ('$fileE','$id_mapel')");
                    }
                } else {
                    $gagal++;
                }
            endfor;
            $total = $hasildata - 1;
            echo "Berhasil: $sukses | Gagal: $gagal | Dari: $total";
        }
    endif;
}
if ($pg == 'import_file') {
    $output = '';
    if (isset($_FILES['zip_file']['name'])) {

        $file_name = $_FILES['zip_file']['name'];
        $array = explode(".", $file_name);
        $name = $array[0];
        $ext = $array[1];
        if ($ext == 'zip') {
            $path = '../../temp/';
            $location = $path . $file_name;
            if (move_uploaded_file($_FILES['zip_file']['tmp_name'], $location)) {
                $zip = new ZipArchive;
                if ($zip->open($location)) {
                    $zip->extractTo($path);
                    $zip->close();
                }
                $files = scandir($path);
                //$name is extract folder from zip file  
                foreach ($files as $file) {
                    $tmp = explode(".", $file);
                    $file_ext = end($tmp);
                    $allowed_ext = array('jpg', 'png', 'jpeg', 'gif', 'mp3', 'wav');
                    if (in_array($file_ext, $allowed_ext)) {
                        if (copy($path . $file, '../../files/' . $file)) {
                            unlink($path . $file);
                        }
                        $output .= '<div class="col-md-3"><div style="padding:16px; border:1px solid #CCC;"><img class="img img-responsive" style="height:150px;" src="../../files/' . $file . '"   /></div></div>';
                    }
                }
                $files    = glob($path . "*");
                foreach ($files as $file) {
                    if (is_file($file))
                        unlink($file); // hapus file
                }
                echo "OK";
            }
        } else {
            echo "GAGAL";
        }
    }
}
