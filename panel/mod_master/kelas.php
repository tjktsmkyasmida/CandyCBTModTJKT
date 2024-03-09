<?php
if (isset($_POST['submit'])) :
    $idkelas = str_replace(' ', '', $_POST['idkelas']);
    $nama = $_POST['nama'];
    $level = $_POST['level'];
    $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$idkelas'"));
    if ($cek > 0) {
        $info = info("Kelas dengan kode $idkelas sudah ada!", "NO");
    } else {
        $exec = mysqli_query($koneksi, "INSERT INTO kelas (id_kelas,nama,level) VALUES ('$idkelas','$nama','$level')");
        if (!$exec) :
            $info = info("Gagal menyimpan!", "NO");
        else :
            jump("?pg=$pg");
        endif;
    }
endif;
?>
<div class='row'>
    <div class='col-md-12'>
        <div class='alert alert-warning '>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
            <i class='icon fa fa-info'></i>
            Level Kelas harus sama dengan Kode Level di data master
        </div>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'>Kelas</h3>
                <div class='box-tools pull-right'>
                    <button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahkelas'><i class='fa fa-check'></i> Tambah Kelas</button>
                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <table id='tablekelas' class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th width='5px'>#</th>
                            <th>Kode Kelas</th>
                            <th>Level Kelas</th>
                            <th>Nama Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $adminQ = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama ASC"); ?>
                        <?php while ($adm = mysqli_fetch_array($adminQ)) : ?>
                            <?php $no++; ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $adm['id_kelas'] ?></td>
                                <td><?= $adm['level'] ?></td>
                                <td><?= $adm['nama'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class='modal fade' id='tambahkelas' style='display: none;'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header bg-blue'>
                    <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                    <h3 class='modal-title'>Tambah Kelas</h3>
                </div>
                <div class='modal-body'>
                    <form action='' method='post'>
                        <div class='form-group'>
                            <label>Kode Kelas</label>
                            <input type='text' name='idkelas' class='form-control' required='true' />
                        </div>
                        <div class='form-group'>
                            <label>Level</label>
                            <select name='level' class='form-control' required='true'>
                                <option value=''></option>
                                <?php
                                $levelQ = mysqli_query($koneksi, "SELECT * FROM level ");
                                while ($level = mysqli_fetch_array($levelQ)) {
                                    echo "<option value='$level[kode_level]'>$level[kode_level]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class='form-group'>
                            <label>Nama Kelas</label>
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