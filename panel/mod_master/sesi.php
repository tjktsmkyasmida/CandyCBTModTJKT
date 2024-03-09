<?php
if (isset($_POST['submit'])) {
    $sesi = str_replace(' ', '', $_POST['sesi']);
    $nama = $_POST['nama'];

    $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM sesi WHERE kode_sesi='$sesi'"));
    if ($cek > 0) {
        $info = info("Kelompok Test atau Sesi $sesi sudah ada!", "NO");
    } else {
        $exec = mysqli_query($koneksi, "INSERT INTO sesi (kode_sesi,nama_sesi) VALUES ('$sesi','$nama')");
        if (!$exec) {
            $info = info("Gagal menyimpan!", "NO");
        } else {
            jump("?pg=$pg");
        }
    }
}
?>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'>Sesi atau Kelompok Test</h3>
                <div class='box-tools pull-right'>
                    <button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahsesi'><i class='fa fa-check'></i> Tambah Kelompok</button>
                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <table id='tablesesi' class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th width='5px'>#</th>
                            <th>Kode Sesi</th>
                            <th>Nama Sesi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $adminQ = mysqli_query($koneksi, "SELECT * FROM sesi"); ?>
                        <?php while ($adm = mysqli_fetch_array($adminQ)) : ?>
                            <?php $no++; ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $adm['kode_sesi'] ?></td>
                                <td><?= $adm['nama_sesi'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class='modal fade' id='tambahsesi' style='display: none;'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header bg-blue'>
                    <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                    <h3 class='modal-title'>Tambah Sesi</h3>
                </div>
                <div class='modal-body'>
                    <form action='' method='post'>
                        <div class='form-group'>
                            <label>Kode Sesi</label>
                            <input type='text' name='sesi' class='form-control' required='true' />
                        </div>
                        <div class='form-group'>
                            <label>Nama Sesi</label>
                            <input type='text' name='nama' class='form-control' required='true' />
                        </div>
                        <div class='modal-footer'>
                            <div class='box-tools pull-right '>
                                <button type='submit' name='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
                                <button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>