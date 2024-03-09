<?php

if (isset($_POST['tambahPK'])) :
    $idpk = str_replace(' ', '', $_POST['idpk']);
    $nama = $_POST['nama'];
    $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pk WHERE id_pk='$idpk'"));
    if ($cek > 0) {
        $info = info("Jurusan dengan kode $idpk sudah ada!", "NO");
    } else {
        $exec = mysqli_query($koneksi, "INSERT INTO pk (id_pk,program_keahlian) VALUES ('$idpk','$nama')");
        if (!$exec) :
            $info = info("Gagal menyimpan!", "NO");
        else :
            jump("?pg=$pg");
        endif;
    }
endif;
$info = '';
?>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'>Jurusan</h3>
                <div class='box-tools pull-right'>
                    <button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahPK'><i class='fa fa-check'></i> Tambah Jurusan</button>
                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <?= $info ?>
                <table id='tablejurusan' class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th width='5px'>#</th>
                            <th>Kode Jurusan</th>
                            <th>Nama Jurusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $adminQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY id_pk ASC"); ?>
                        <?php while ($adm = mysqli_fetch_array($adminQ)) : ?>
                            <?php $no++; ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $adm['id_pk'] ?></td>
                                <td><?= $adm['program_keahlian'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class='modal fade' id='tambahPK' style='display: none;'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header bg-blue'>
                    <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                    <h3 class='modal-title'>Tambah Jurusan</h3>
                </div>
                <div class='modal-body'>
                    <form action='' method='post'>
                        <div class='form-group'>
                            <label>Kode Jurusan</label>
                            <input type='text' name='idpk' class='form-control' required='true' />
                        </div>
                        <div class='form-group'>
                            <label>Nama Jurusan</label>
                            <input type='text' name='nama' class='form-control' required='true' />
                        </div>
                        <div class='modal-footer'>
                            <div class='box-tools pull-right '>
                                <button type='submit' name='tambahPK' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
                                <button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>