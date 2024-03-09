<?php
$pesan = '';
if (isset($_POST['simpanmapel'])) {
    $kode = str_replace(' ', '', $_POST['kodemapel']);
    $nama = addslashes($_POST['namamapel']);
    $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mata_pelajaran WHERE kode_mapel='$kode'"));
    if ($cek == 0) {
        $exec = mysqli_query($koneksi, "INSERT INTO mata_pelajaran (kode_mapel,nama_mapel)value('$kode','$nama')");
        $pesan = "<div class='alert alert-success alert-dismissible'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <i class='icon fa fa-info'></i>
    Data Berhasil ditambahkan ..</div>";
    } else {
        $pesan = "<div class='alert alert-warning alert-dismissible'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <i class='icon fa fa-info'></i>
    Maaf Kode Mapel Sudah ada !</div>";
    }
}
if (isset($_POST['importmapel'])) {
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
        for ($i = 2; $i <= $hasildata; $i++) {
            $kode = addslashes($data->val($i, 2));
            $nama = addslashes($data->val($i, 3));
            $kode = str_replace(' ', '', $kode);
            $nama = addslashes($nama);
            $cek = mysqli_num_rows(mysqli_query($koneksi, "select * from mata_pelajaran where kode_mapel='$kode'"));
            if ($kode <> '' and $nama <> '') {
                if ($cek == 0) {
                    $exec = mysqli_query($koneksi, "INSERT INTO mata_pelajaran (kode_mapel,nama_mapel) VALUES ('$kode','$nama')");
                    ($exec) ? $sukses++ : $gagal++;
                }
            } else {
                $gagal++;
            }
        }
        $total = $hasildata - 1;
        $info = info("Berhasil: $sukses | Gagal: $gagal | Dari: $total", 'OK');
    }
}
?>
<div class='row'>
    <div class='col-md-12'><?= $pesan ?></div>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'>Mata Pelajaran</h3>
                <div class='box-tools pull-right '>
                    <button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahmapel'><i class='fa fa-check'></i> Tambah Mapel</button>
                    <button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#importmapel'><i class='fa fa-upload'></i> Import Mapel</button>
                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <div class='table-responsive'>
                    <table id='tablemapel' class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th width='5px'>#</th>
                                <th>Kode Mapel</th>
                                <th>Mata Pelajaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $mapelQ = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran ORDER BY nama_mapel ASC"); ?>
                            <?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
                                <?php $no++; ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $mapel['kode_mapel'] ?></td>
                                    <td><?= $mapel['nama_mapel'] ?></td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class='modal fade' id='tambahmapel' style='display: none;'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header bg-blue'>
                    <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                    <h3 class='modal-title'>Tambah Mata Pelajaran</h3>
                </div>
                <div class='modal-body'>
                    <form action='' method='post'>
                        <div class='form-group'>
                            <label>Kode Mapel</label>
                            <input type='text' name='kodemapel' class='form-control' required='true' />
                        </div>
                        <div class='form-group'>
                            <label>Nama Pelajaran</label>
                            <input type='text' name='namamapel' class='form-control' required='true' />
                        </div>
                        <div class='modal-footer'>
                            <div class='box-tools pull-right '>
                                <button type='submit' name='simpanmapel' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
                                <button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class='modal fade' id='importmapel' style='display: none;'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header bg-blue'>
                    <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                    <h3 class='modal-title'>Tambah Mata Pelajaran</h3>
                </div>
                <div class='modal-body'>
                    <form action='' method='post' enctype='multipart/form-data'>
                        <div class='form-group'>
                            <label>Pilih File</label>
                            <input type='file' name='file' class='form-control' required='true' />
                        </div>
                        <p>
                            Sebelum meng-import pastikan file yang akan anda import sudah dalam bentuk Ms. Excel 97-2003 Workbook (.xls) dan format penulisan harus sesuai dengan yang telah ditentukan. <br />
                        </p>

                        <a href='template/importdatamapel.xls'><i class='fa fa-file-excel-o'></i> Download Format</a>

                        <div class='modal-footer'>
                            <div class='box-tools pull-right '>
                                <button type='submit' name='importmapel' class='btn btn-sm btn-flat btn-success'><i class='fa fa-upload'></i> Simpan</button>
                                <button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>