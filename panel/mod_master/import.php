<?php
$format = 'template/importdatamaster.xlsx';
if (isset($_POST['importsiswa'])) :
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $ext = explode('.', $file);
    $ext = end($ext);
    if ($ext <> 'xls') {
        $info = info('Gunakan file Ms. Excel 93-2007 Workbook (.xls)', 'NO');
    } else {
        $data = new Spreadsheet_Excel_Reader($temp);
        $hasildata = $data->rowcount($sheet_index = 0);
        $sukses = $gagal = 0;
        $exec = mysqli_query($koneksi, "TRUNCATE siswa");
        for ($i = 2; $i <= $hasildata; $i++) {
            $id_siswa = $data->val($i, 1);
            $nis = $data->val($i, 2);
            $no_peserta = $data->val($i, 3);
            $nama = $data->val($i, 4);
            $nama = addslashes($nama);
            $level = str_replace(' ', '', $data->val($i, 5));
            $kelas = str_replace(' ', '', $data->val($i, 6));
            $pk = str_replace(' ', '', $data->val($i, 7));
            $sesi = str_replace(' ', '', $data->val($i, 8));
            $ruang = str_replace(' ', '', $data->val($i, 9));
            $username = $data->val($i, 10);
            $username = str_replace("'", "", $username);
            $username = str_replace("-", "", $username);
            $password = $data->val($i, 11);
            $foto = $data->val($i, 12);
            $server = $data->val($i, 13);
            $agama = $data->val($i, 14);
            $nohp = $data->val($i, 15);
            if ($nama <> '') {
                $qkelas = mysqli_query($koneksi, "SELECT id_kelas FROM kelas WHERE id_kelas='$kelas'");
                $cekkelas = mysqli_num_rows($qkelas);
                if (!$cekkelas <> 0) {
                    $exec = mysqli_query($koneksi, "INSERT INTO kelas (id_kelas,level,nama)VALUES('$kelas','$level','$kelas')");
                }

                $qpk = mysqli_query($koneksi, "SELECT id_pk FROM pk WHERE id_pk='$pk'");
                $cekpk = mysqli_num_rows($qpk);
                if (!$cekpk <> 0) {
                    $exec = mysqli_query($koneksi, "INSERT INTO pk (id_pk,program_keahlian)VALUES('$pk','$pk')");
                }

                $qlevel = mysqli_query($koneksi, "SELECT kode_level FROM level WHERE kode_level='$level'");
                $ceklevel = mysqli_num_rows($qlevel);
                if (!$ceklevel <> 0) {
                    $exec = mysqli_query($koneksi, "INSERT INTO level (kode_level,keterangan)VALUES('$level','$level')");
                }
                $qruang = mysqli_query($koneksi, "SELECT kode_ruang FROM ruang WHERE kode_ruang='$ruang'");
                $cekruang = mysqli_num_rows($qruang);
                if (!$cekruang <> 0) {
                    $exec = mysqli_query($koneksi, "INSERT INTO ruang (kode_ruang,keterangan)VALUES('$ruang','$ruang')");
                }
                $qsesi = mysqli_query($koneksi, "SELECT kode_sesi FROM sesi WHERE kode_sesi='$sesi'");
                $ceksesi = mysqli_num_rows($qsesi);
                if (!$ceksesi <> 0) {
                    $exec = mysqli_query($koneksi, "INSERT INTO sesi (kode_sesi,nama_sesi)VALUES('$sesi','$sesi')");
                }
                $qserver = mysqli_query($koneksi, "SELECT kode_server FROM server WHERE kode_server='$server'");
                $cekserver = mysqli_num_rows($qserver);
                if (!$cekserver <> 0) {
                    $exec = mysqli_query($koneksi, "INSERT INTO server (kode_server,nama_server,status)VALUES('$server','$server','aktif')");
                }

                $exec = mysqli_query($koneksi, "INSERT INTO siswa (id_siswa,id_kelas,idpk,nis,no_peserta,nama,level,sesi,ruang,username,password,foto,server,agama,hp) VALUES ('$id_siswa','$kelas','$pk','$nis','$no_peserta','$nama','$level','$sesi','$ruang','$username','$password','$foto','$server','$agama','$nohp')");

                ($exec) ? $sukses++ : $gagal++;
            }
        }
        $total = $hasildata - 1;
        $info = info("Berhasil: $sukses | Gagal: $gagal | Dari: $total", 'OK');
    }

endif;
?>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border '>
                <h3 class='box-title'>Import Data Master</h3>
                <div class='box-tools pull-right '>
                    <a href='<?= $format ?>' class='btn btn-sm btn-flat btn-success'><i class='fa fa-file-excel-o'></i> Download Format</a>
                    <a href='?pg=siswa' class='btn btn-sm btn-flat btn-success' title='Batal'><i class='fa fa-times'></i></a>
                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>

                <div class='box box-solid'>
                    <div class='box-body'>
                        <div class='form-group'>
                            <div class='row'>
                                <form id='formsiswa' enctype='multipart/form-data'>
                                    <div class='col-md-4'>
                                        <label>Pilih File</label>
                                        <input type='file' name='file' class='form-control' required='true' />
                                    </div>
                                    <div class='col-md-4'>
                                        <label>&nbsp;</label><br>
                                        <button type='submit' name='submit' class='btn btn-flat btn-success'><i class='fa fa-check'></i> Import Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <span class="label label-primary">Import bukan ajax (harus xlx)</span>
                        <div class='form-group'>
                            <div class='row'>
                                <form action="" method="post" enctype='multipart/form-data'>
                                    <div class='col-md-4'>
                                        <label>Pilih File</label>
                                        <input type='file' name='file' class='form-control' required='true' />
                                    </div>
                                    <div class='col-md-4'>
                                        <label>&nbsp;</label><br>
                                        <button type='submit' name='importsiswa' class='btn btn-flat btn-success'><i class='fa fa-check'></i> Import Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?= $info ?>
                        <p>Menu ini berfungsi untuk import data Master</p>
                        <p><strong>*Import Data Siswa, Jurusan, Kelas, Ruangan, Sesi dan Level</strong></p>
                        <p>Sebelum meng-import pastikan file yang akan anda import sudah dalam bentuk Ms. Excel 97-2003 Workbook (.xls) dan format penulisan harus sesuai dengan yang telah ditentukan.</p>
                        <div id='progressbox'></div>
                        <div id='hasilimport'></div>
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div class='box-footer'></div>
        </div><!-- /.box -->
    </div>
</div>
<script>
    $('#formsiswa').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'mod_master/import_master.php',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('#progressbox').html('<div class="progress"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div>');
                $('.progress-bar').animate({
                    width: "30%"
                }, 100);
            },
            success: function(response) {
                setTimeout(function() {
                    $('.progress-bar').css({
                        width: "100%"
                    });
                    setTimeout(function() {
                        $('#hasilimport').html(response);
                    }, 100);
                }, 500);
            }
        });
    });
</script>