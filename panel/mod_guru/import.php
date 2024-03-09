<?php
if (isset($_POST['submit'])) :
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
        $exec = mysqli_query($koneksi, "delete from pengawas where level='guru'");
        for ($i = 2; $i <= $hasildata; $i++) : $nip = $data->val($i, 2);
            $nama = $data->val($i, 3);
            $nama = addslashes($nama);
            $username = $data->val($i, 4);
            $username = str_replace("'", "", $username);
            $password = password_hash($data->val($i, 5), PASSWORD_DEFAULT);
            $walas = $data->val($i, 6);
            if ($nama <> '') {
                $exec = mysqli_query($koneksi, "INSERT INTO pengawas (nip,nama,username,password,level,jabatan) VALUES ('$nip','$nama','$username','$password','guru','$walas')");
                ($exec) ? $sukses++ : $gagal++;
            } else {
                $gagal++;
            }
        endfor;
        $total = $hasildata - 1;
        $info = info("Berhasil: $sukses | Gagal: $gagal | Dari: $total", 'OK');
    }
endif;
?>
<div class='row'>
    <div class='col-md-3'></div>
    <div class='col-md-6'>
        <form action='' method='post' enctype='multipart/form-data'>
            <div class='box box-solid'>
                <div class='box-header with-border'>
                    <h3 class='box-title'>Import Guru</h3>
                    <div class='box-tools pull-right '>
                        <button type='submit' name='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Import</button>
                        <a href='?pg=guru' class='btn btn-sm btn-default' title='Batal'><i class='fa fa-times'></i></a>
                    </div>
                </div><!-- /.box-header -->
                <div class='box-body'>
                    <?= $info ?>
                    <div class='form-group'>
                        <label>Pilih File</label>
                        <input type='file' name='file' class='form-control' required='true' />
                    </div>
                    <p>Sebelum meng-import pastikan file yang akan anda import sudah dalam bentuk Ms. Excel 97-2003 Workbook (.xls) dan format penulisan harus sesuai dengan yang telah ditentukan.</p>
                </div><!-- /.box-body -->
                <div class='box-footer'>
                    <a href='template/importdataguru.xls'><i class='fa fa-file-excel-o'></i> Download Format</a>
                </div>
            </div><!-- /.box -->
        </form>
    </div>
</div>