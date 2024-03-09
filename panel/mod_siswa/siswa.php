<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>
<?php if ($ac == '') : ?>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-solid'>
                <div class='box-header with-border '>
                    <h3 class='box-title'><i class="fas fa-user-friends fa-fw   "></i> Peserta Ujian</h3>
                    <div class='box-tools pull-right'>
                        <?php if ($pengawas['level'] == 'admin') : ?>
                            <?php if ($setting['server'] == 'pusat') : ?>
                                <a data-toggle='modal' data-backdrop="static" data-target='#tambahsiswa' class='btn btn-sm btn-primary'><i class='glyphicon glyphicon-plus'></i> <span class='hidden-xs'>Tambah</span></a>
                            <?php endif; ?>
                            <a href='?pg=uplfotosiswa' class='btn btn-sm btn-danger'><i class='fa fa-image'></i> <span class='hidden-xs'>Upload Foto</span></a>
                            <a href='mod_siswa/ekspor_siswa.php' class='btn btn-sm btn-success'><i class='fa fa-download'></i> <span class='hidden-xs'>Download Data</span></a>
                        <?php endif ?>
                    </div>
                </div><!-- /.box-header -->
                <div class='box-body'>
                    <div class='table-responsive'>
                        <table style="font-size: 11px" id='tabelsiswa' class='table table-bordered table-striped'>
                            <thead>
                                <tr>
                                    <th width='3px'></th>
                                    <th>No_Peserta</th>
                                    <th>Nama</th>
                                    <th>Level</th>
                                    <th>Kelas</th>
                                    <th>Jurusan</th>
                                    <th>sesi</th>
                                    <th>ruang</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Server</th>
                                    <th>Agama</th>
                                    <th>Status</th>
                                    <?php if ($pengawas['level'] == 'admin') : ?>
                                        <?php if ($setting['server'] == 'pusat') : ?>
                                            <th width='70px'></th>
                                        <?php endif ?>
                                    <?php endif ?>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class='modal fade' id='tambahsiswa' style='display: none;'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header bg-maroon'>
                                    <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                                    <h4 class='modal-title'><i class="fas fa-user-friends fa-fw   "></i> Tambah Siswa</h4>
                                </div>
                                <div class='modal-body'>
                                    <form id='form-tambah' action=''>
                                        <div class='form-group'>
                                            <div class='row'>
                                                <div class='col-md-6'>
                                                    <label>NIS</label>
                                                    <input type='text' name='nis' class='form-control' required='true' />
                                                </div>
                                                <div class='col-md-6'>
                                                    <label>Nomor Peserta</label>
                                                    <input type='text' name='no_peserta' class='form-control' required='true' />
                                                </div>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <label>Nama</label>
                                            <input type='text' name='nama' class='form-control' required='true' />
                                        </div>
                                        <div class='form-group'>
                                            <div class='row'>
                                                <div class='col-md-4'>
                                                    <label>Kelas</label>
                                                    <select name='id_kelas' class='form-control' required='true'>
                                                        <option value=''></option>
                                                        <?php
                                                        $kelasQ = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama ASC");
                                                        while ($kelas = mysqli_fetch_array($kelasQ)) {
                                                            echo "<option value='$kelas[id_kelas]' $s>$kelas[nama]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class='col-md-4'>
                                                    <label>Level</label>
                                                    <select name='level' class='form-control' required='true'>
                                                        <option value=''></option>
                                                        <?php
                                                        $pkQ = mysqli_query($koneksi, "SELECT * FROM level ");
                                                        while ($pk = mysqli_fetch_array($pkQ)) {
                                                            echo "<option value='$pk[kode_level]'>$pk[kode_level]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class='col-md-4'>
                                                    <label>Jurusan</label>
                                                    <select name='idpk' class='form-control' required='true'>
                                                        <option value=''></option>
                                                        <?php
                                                        $pkQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY program_keahlian ASC");
                                                        while ($pk = mysqli_fetch_array($pkQ)) {
                                                            echo "<option value='$pk[id_pk]'>$pk[program_keahlian]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class='row'>
                                                <div class='col-md-4'>
                                                    <label>Sesi</label>
                                                    <select name='idsesi' class='form-control' required='true'>
                                                        <option value=''></option>
                                                        <?php
                                                        $sesiQ = mysqli_query($koneksi, "SELECT * FROM sesi ");
                                                        while ($sesi = mysqli_fetch_array($sesiQ)) {

                                                            echo "<option value='$sesi[kode_sesi]' $s>$sesi[kode_sesi]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class='col-md-4'>
                                                    <label>Ruang</label>
                                                    <select name='ruang' class='form-control' required='true'>
                                                        <option value=''></option>
                                                        <?php
                                                        $pkQ = mysqli_query($koneksi, "SELECT * FROM ruang ");
                                                        while ($pk = mysqli_fetch_array($pkQ)) {
                                                            echo "<option value='$pk[kode_ruang]'>$pk[kode_ruang]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class='col-md-4'>
                                                    <label>Server</label>
                                                    <select name='server' class='form-control' required='true'>
                                                        <option value=''></option>
                                                        <?php
                                                        $pkQ = mysqli_query($koneksi, "SELECT * FROM server ");
                                                        while ($sr = mysqli_fetch_array($pkQ)) {
                                                            echo "<option value='$sr[kode_server]'>$sr[kode_server]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label>Username</label>
                                                    <input type='text' name='username' class='form-control' required='true' />
                                                </div>
                                            </div>
                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label>Agama</label>
                                                    <input type='text' name='agama' class='form-control' required='true' />
                                                </div>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class='row'>
                                                <div class='col-md-6'>
                                                    <label>Password</label>
                                                    <input type='password' name='pass1' class='form-control' required='true' />
                                                </div>
                                                <div class='col-md-6'>
                                                    <label>Ulang Password</label>
                                                    <input type='password' name='pass2' class='form-control' required='true' />
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <div class='form-group'>
                                                    <label>No hp</label>
                                                    <input type='text' name='hp' class='form-control' />
                                                </div>
                                            </div>

                                        </div>
                                        <div class='modal-footer'>
                                            <div class='box-tools pull-right btn-group'>
                                                <button type='submit' name='tambahsiswa' class='btn btn-sm btn-primary'><i class='fa fa-check'></i> Simpan</button>
                                                <button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
<?php elseif ($ac == 'edit') : ?>
    <?php
    $id = $_GET['id'];
    $siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$id'"));
    ?>
    <div class='row'>
        <div class='col-md-2'></div>
        <div class='col-md-7'>
            <form id="form-edit" method='post'>
                <div class='box box-success'>
                    <div class='box-header with-border'>
                        <h3 class='box-title'>Edit</h3>
                        <div class='box-tools pull-right btn-group'>
                            <button type='submit' name='submit' class='btn btn-sm btn-success'><i class='fa fa-check'></i> Simpan</button>
                            <a href='?pg=<?= $pg ?>' class='btn btn-sm btn-danger' title='Batal'><i class='fa fa-times'></i></a>
                        </div>
                    </div><!-- /.box-header -->
                    <div class='box-body'>
                        <input type='hidden' name='idu' value="<?= $siswa['id_siswa'] ?>" />
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label>NIS</label>
                                    <input type='text' name='nis' class='form-control' value="<?= $siswa['nis'] ?>" required='true' />
                                </div>
                                <div class='col-md-6'>
                                    <label>Nomor Peserta</label>
                                    <input type='text' name='no_peserta' class='form-control' value="<?= $siswa['no_peserta'] ?>" required='true' />
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label>Nama</label>
                            <input type='text' name='nama' class='form-control' value="<?= $siswa['nama'] ?>" required='true' />
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-4'>
                                    <label>Kelas</label>
                                    <select name='id_kelas' class='form-control' required='true'>
                                        <option value=''></option>
                                        <?php
                                        $kelasQ = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama ASC");
                                        while ($kelas = mysqli_fetch_array($kelasQ)) {
                                            ($kelas['id_kelas'] == $siswa['id_kelas']) ? $s = 'selected' : $s = '';
                                            echo "<option value='$kelas[id_kelas]' $s>$kelas[nama]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class='col-md-4'>
                                    <label>Level</label>
                                    <select name='level' class='form-control' required='true'>
                                        <option value=''></option>
                                        <?php
                                        $pkQ = mysqli_query($koneksi, "SELECT * FROM level ");
                                        while ($pk = mysqli_fetch_array($pkQ)) {
                                            ($pk['kode_level'] == $siswa['level']) ? $s = 'selected' : $s = '';
                                            echo "<option value='$pk[kode_level]' $s>$pk[kode_level]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class='col-md-4'>
                                    <label>Jurusan</label>
                                    <select name='idpk' class='form-control' required='true'>
                                        <option value=''></option>
                                        <?php
                                        $pkQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY program_keahlian ASC");
                                        while ($pk = mysqli_fetch_array($pkQ)) {
                                            ($pk['id_pk'] == $siswa['idpk']) ? $s = 'selected' : $s = '';
                                            echo "<option value='$pk[id_pk]' $s>$pk[program_keahlian]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-4'>
                                    <label>Sesi</label>
                                    <select name='idsesi' class='form-control' required='true'>
                                        <option value=''></option>
                                        <?php
                                        $sesiQ = mysqli_query($koneksi, "SELECT * FROM sesi ");
                                        while ($sesi = mysqli_fetch_array($sesiQ)) {
                                            ($sesi['kode_sesi'] == $siswa['sesi']) ? $s = 'selected' : $s = '';
                                            echo "<option value='$sesi[kode_sesi]' $s>$sesi[kode_sesi]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class='col-md-4'>
                                    <label>Ruang</label>
                                    <select name='ruang' class='form-control' required='true'>
                                        <option value=''></option>
                                        <?php
                                        $pkQ = mysqli_query($koneksi, "SELECT * FROM ruang ");
                                        while ($pk = mysqli_fetch_array($pkQ)) {
                                            ($pk['kode_ruang'] == $siswa['ruang']) ? $s = 'selected' : $s = '';
                                            echo "<option value='$pk[kode_ruang]' $s>$pk[kode_ruang]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class='col-md-4'>
                                    <label>Server</label>
                                    <select name='server' class='form-control' required='true'>
                                        <option value=''></option>
                                        <?php
                                        $pkQ = mysqli_query($koneksi, "SELECT * FROM server ");
                                        while ($sr = mysqli_fetch_array($pkQ)) {
                                            ($sr['kode_server'] == $siswa['server']) ? $s = 'selected' : $s = '';
                                            echo "<option value='$sr[kode_server]' $s>$sr[kode_server]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Username</label>
                                    <input type='text' name='username' class='form-control' value="<?= $siswa['username'] ?>" required='true' />
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>Agama</label>
                                    <input type='text' name='agama' class='form-control' value="<?= $siswa['agama'] ?>" required='true' />
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label>Password</label>
                                    <input type='password' name='pass1' class='form-control' />
                                </div>
                                <div class='col-md-6'>
                                    <label>Ulang Password</label>
                                    <input type='password' name='pass2' class='form-control' />
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <label>No hp</label>
                                    <input type='text' name='hp' class='form-control' value="<?= $siswa['hp'] ?>" />
                                </div>
                            </div>

                        </div>
                        <label>
                            <input type='checkbox' class='icheckbox_square-green' name='status' value='aktif' <?php if ($siswa['status'] == 'aktif') {
                                                                                                                    echo "checked='true'";
                                                                                                                } ?> /> Status Siswa aktif / tidak
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php endif ?>

<script>
    $(document).ready(function() {
        var t = $('#tabelsiswa').DataTable({
            'ajax': 'mod_siswa/crud_siswa.php?pg=ambil_siswa',
            'order': [
                [1, 'asc']
            ],
            'columns': [{
                    'data': null,
                    'width': '10px',
                    'sClass': 'text-center'
                },
                {
                    'data': 'no_peserta'
                },
                {
                    'data': 'nama'
                },
                {
                    'data': 'level'
                },
                {
                    'data': 'id_kelas'
                },
                {
                    'data': 'idpk'
                },
                {
                    'data': 'sesi'
                },
                {
                    'data': 'ruang'
                },
                {
                    'data': 'username'
                },
                {
                    'data': 'password'
                },
                {
                    'data': 'server'
                },
                {
                    'data': 'agama'
                },
                {
                    'data': 'status'
                },
                <?php if ($pengawas['level'] == 'admin') { ?>
                    <?php if ($setting['server'] == 'pusat') { ?> {
                            'data': 'id_siswa',
                            'width': '60px',
                            'sClass': 'text-center',
                            'orderable': false,
                            'mRender': function(data) {
                                return '<a class="btn btn-flat btn-xs bg-yellow" href="?pg=siswa&ac=edit&id=' + data + '"><i class="fas fa-edit"></i></a>\n\
                                <a class="btn btn-flat btn-xs bg-maroon hapus" data-id="' + data + '" ><i class="fa fa-trash"></i></a>';
                            }
                        }
                    <?php } ?>
                <?php } ?>
            ]
        });
        t.on('order.dt search.dt', function() {
            t.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
    $('#form-tambah').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'mod_siswa/crud_siswa.php?pg=tambah',
            data: $(this).serialize(),
            beforeSend: function() {
                $('form button').on("click", function(e) {
                    e.preventDefault();
                });
            },
            success: function(data) {
                console.log(data);
                if (data == 'OK') {
                    iziToast.success({
                        title: 'Mantap!',
                        message: 'data berhasil disimpan',
                        position: 'topRight'
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    iziToast.error({
                        title: 'Maaf!',
                        message: data,
                        position: 'topRight'
                    });
                }

            }
        });
        return false;
    });
    $('#form-edit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'mod_siswa/crud_siswa.php?pg=ubah',
            data: $(this).serialize(),

            success: function(data) {
                console.log(data);
                if (data == 'OK') {
                    iziToast.success({
                        title: 'Mantap!',
                        message: 'data berhasil disimpan',
                        position: 'topRight'
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    iziToast.error({
                        title: 'Maaf!',
                        message: data,
                        position: 'topRight'
                    });
                }

            }
        });
        return false;
    });
    $('#tabelsiswa').on('click', '.hapus', function() {
        var id = $(this).data('id');
        console.log(id);
        swal({
            title: 'Are you sure?',
            text: 'Akan menghapus data ini!',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'iya, hapus'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'mod_siswa/crud_siswa.php?pg=hapus',
                    method: "POST",
                    data: 'id_siswa=' + id,
                    success: function(data) {
                        iziToast.error({
                            title: 'Horee!',
                            message: 'Data Berhasil dihapus',
                            position: 'topRight'
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                });
            }
            return false;
        })

    });
</script>