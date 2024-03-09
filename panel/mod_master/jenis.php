<?php
if (isset($_POST['tambahujian'])) :
    $id = str_replace(' ', '', $_POST['idujian']);
    $nama = $_POST['nama'];
    $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM jenis WHERE id_jenis='$id'"));
    if ($cek > 0) {
        $info = info("Jenis Ujian dengan kode $id sudah ada!", "NO");
    } else {
        $exec = mysqli_query($koneksi, "INSERT INTO jenis (id_jenis,nama,status) VALUES ('$id','$nama','tidak')");
        if (!$exec) {
            $info = info("Gagal menyimpan!", "NO");
        } else {
            jump("?pg=$pg");
        }
    }
endif;
$info = '';
?>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'>JENIS UJIAN</h3>
                <div class='box-tools pull-right'>
                    <button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahujian'><i class='fa fa-check'></i> Tambah Ujian</button>
                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <?= $info ?>
                <table id='tablejenis' class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th width='5px'>#</th>
                            <th>Kode Ujian</th>
                            <th>Nama Ujian</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $adminQ = mysqli_query($koneksi, "SELECT * FROM jenis ORDER BY id_jenis ASC"); ?>
                        <?php while ($adm = mysqli_fetch_array($adminQ)) : ?>
                            <?php $no++; ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $adm['id_jenis'] ?></td>
                                <td><?= $adm['nama'] ?></td>
                                <td><?= $adm['status'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class='modal fade' id='tambahujian' style='display: none;'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header bg-blue'>
                    <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                    <h3 class='modal-title'>Tambah Ujian</h3>
                </div>
                <div class='modal-body'>
                    <form action='' method='post'>
                        <div class='form-group'>
                            <label>Kode Ujian</label>
                            <input type='text' name='idujian' class='form-control' required='true' />
                        </div>
                        <div class='form-group'>
                            <label>Nama Ujian</label>
                            <input type='text' name='nama' class='form-control' required='true' />
                        </div>
                        <div class='modal-footer'>
                            <div class='box-tools pull-right '>
                                <button type='submit' name='tambahujian' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
                                <button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>