<?php
if (isset($_POST['submit'])) :
    $level = str_replace(' ', '', $_POST['level']);
    $ket = $_POST['keterangan'];

    $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM level WHERE kode_level='$level'"));
    if ($cek > 0) {
        $info = info("Level atau tingkat $level sudah ada!", "NO");
    } else {
        $exec = mysqli_query($koneksi, "INSERT INTO level (kode_level,keterangan) VALUES ('$level','$ket')");
        if (!$exec) {
            $info = info("Gagal menyimpan!", "NO");
        } else {
            jump("?pg=$pg");
        }
    }
endif;
?>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'>Level atau Tingkat</h3>
                <div class='box-tools pull-right'>
                    <button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahlevel'><i class='fa fa-check'></i> Tambah Level</button>
                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <table id='tablelevel' class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th width='5px'>#</th>
                            <th>Kode Level</th>
                            <th>Nama Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $adminQ = mysqli_query($koneksi, "SELECT * FROM level"); ?>
                        <?php while ($adm = mysqli_fetch_array($adminQ)) : ?>
                            <?php $no++; ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $adm['kode_level'] ?></td>
                                <td><?= $adm['keterangan'] ?></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class='modal fade' id='tambahlevel' style='display: none;'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header bg-blue'>
                    <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                    <h3 class='modal-title'>Tambah Level</h3>
                </div>
                <div class='modal-body'>
                    <form action='' method='post'>
                        <div class='form-group'>
                            <label>Kode Level</label>
                            <input type='text' name='level' class='form-control' required='true' />
                        </div>
                        <div class='form-group'>
                            <label>Nama Level</label>
                            <input type='text' name='keterangan' class='form-control' required='true' />
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