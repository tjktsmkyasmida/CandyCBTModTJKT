<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>
<div class='modal fade' id='tambahjadwal' style='display: none;'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header bg-maroon'>
                <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                <h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Tambah Jadwal Ujian</h4>
            </div>
            <div class='modal-body'>
                <form id="formtambahujian" method='post'>
                    <div class='form-group'>
                        <label>Nama Bank Soal</label>
                        <select name='idmapel' class='form-control' required='true'>
                            <?php
                            if ($pengawas['level'] == 'admin') {
                                $namamapelx = mysqli_query($koneksi, "SELECT * FROM mapel where status='1' order by nama ASC");
                            } else {
                                $namamapelx = mysqli_query($koneksi, "SELECT * FROM mapel where status='1' and idguru='$id_pengawas' order by nama ASC");
                            }
                            while ($namamapel = mysqli_fetch_array($namamapelx)) {
                                $dataArray = unserialize($namamapel['kelas']);
                                echo "<option value='$namamapel[id_mapel]'>$namamapel[kode] [$namamapel[nama]] - $namamapel[level] - ";
                                foreach ($dataArray as $key => $value) {
                                    echo "$value ";
                                }
                                echo "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class='form-group'>
                        <label>Nama Jenis Ujian</label>
                        <select name='kode_ujian' class='form-control' required='true'>
                            <option value=''>Pilih Jenis Ujian </option>
                            <?php
                            $namaujianx = mysqli_query($koneksi, "SELECT * FROM jenis where status='aktif' order by nama ASC");
                            while ($ujian = mysqli_fetch_array($namaujianx)) {
                                echo "<option value='$ujian[id_jenis]'>$ujian[id_jenis] - $ujian[nama] </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label>Tanggal Mulai Ujian</label>
                                <input type='text' name='tgl_ujian' class='tgl form-control' autocomplete='off' required='true' />
                            </div>
                            <div class='col-md-6'>
                                <label>Tanggal Waktu Expired</label>
                                <input type='text' name='tgl_selesai' class='tgl form-control' autocomplete='off' required='true' />
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-3'>
                            <div class='form-group'>
                                <label>Sesi</label>
                                <select name='sesi' class='form-control' required='true'>
                                    <?php
                                    $sesix = mysqli_query($koneksi, "SELECT * from sesi");
                                    while ($sesi = mysqli_fetch_array($sesix)) {
                                        echo "<option value='$sesi[kode_sesi]'>$sesi[kode_sesi]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class='form-group'>
                                <label>Lama ujian (menit)</label>
                                <input type='number' name='lama_ujian' class='form-control' required='true' />
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <label>Selesai (Menit)</label>
                            <input type='number' name='btn_selesai' class='form-control' required='true' />
                        </div>
                        <div class='col-md-3'>
                            <label>Pelanggaran (detik)</label>
                            <input type='number' name='pelanggaran' class='form-control' required='true' />
                        </div>
                    </div>

                    <div class='form-group'>
                        <label></label><br>
                        <label>
                            <input type='checkbox' class='icheckbox_square-green' name='acak' value='1' /> Acak Soal
                        </label>
                        <label>
                            <input type='checkbox' class='icheckbox_square-green' name='acakopsi' value='1' /> Acak Opsi
                        </label>
                        <label>
                            <input type='checkbox' class='icheckbox_square-green' name='token' value='1' /> Token Soal
                        </label>

                        <label>
                            <input type='checkbox' class='icheckbox_square-green' name='hasil' value='1' /> Hasil Tampil
                        </label>
                        <label>
                            <input type='checkbox' class='icheckbox_square-green' name='reset' value='1' /> Reset Login
                        </label>
                        <label>
                            <input type='checkbox' class='icheckbox_square-green' name='ulangkkm' value='1' /> Ulang KKM
                        </label>
                    </div>
                    <div class='modal-footer'>
                        <button name='tambahjadwal' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan Semua</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border '>
                <h3 class='box-title'><i class="fas fa-envelope-open-text    "></i> Aktifasi Ujian</h3>
                <div class='box-tools pull-right '>
                    <?php if ($setting['server'] == 'pusat') : ?>

                        <button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-backdrop='static' data-target='#tambahjadwal'><i class='glyphicon glyphicon-plus'></i> <span class='hidden-xs'>Tambah Jadwal</span></button>
                    <?php endif ?>
                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <div class="col-md-1">
                </div>
                <div class="col-md-6">
                    <form id='formaktivasi' action="">
                        <div class="form-group">
                            <label for="">Pilih Jadwal Ujian</label>
                            <select class="form-control select2" name="ujian[]" style="width:100%" multiple='true' required>
                                <?php if ($pengawas['level'] == 'admin') {
                                    $jadwal = mysqli_query($koneksi, "SELECT * FROM ujian ORDER BY tgl_ujian ASC, waktu_ujian ASC");
                                } else {
                                    $jadwal = mysqli_query($koneksi, "SELECT * FROM ujian where id_guru='$id_pengawas' ORDER BY tgl_ujian ASC, waktu_ujian ASC");
                                } ?>
                                <?php while ($ujian = mysqli_fetch_array($jadwal)) : ?>

                                    <option value="<?= $ujian['id_ujian'] ?>"><?= $ujian['kode_nama'] . " - " . $ujian['nama'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Pilih Kelompok Test / Sesi</label>
                                    <select class="form-control select2" name="sesi" id="">
                                        <?php $sesi = mysqli_query($koneksi, "select * from siswa group by sesi"); ?>
                                        <?php while ($ses = mysqli_fetch_array($sesi)) : ?>
                                            <option value="<?= $ses['sesi'] ?>"><?= $ses['sesi'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Pilih Aksi</label>
                                    <select class="form-control select2" name="aksi" required>

                                        <option value=""></option>
                                        <option value="1">aktif</option>
                                        <option value="0">non aktif</option>
                                        <option value="hapus">hapus</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button name="simpan" class="btn btn-success">Simpan Semua</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="box-body">
                        <div class='small-box bg-aqua'>
                            <div class='inner'>
                                <?php $token = mysqli_fetch_array(mysqli_query($koneksi, "select token from token")) ?>
                                <h3><span name='token' id='isi_token'><?= $token['token'] ?></span></h3>
                                <p>Token Tes</p>
                            </div>
                            <div class='icon'>
                                <i class='fa fa-barcode'></i>
                            </div>
                        </div>
                        <a id="btntoken" href="#"><i class='fa fa-spin fa-refresh'></i> Refreh Sekarang</a>
                        <p>Token akan refresh setiap 15 menit
                    </div>
                </div>
            </div><!-- /.box -->
        </div>

    </div>




</div>


<div class=''>
    <div id='tablereset' class='table-responsive'>
        <table class='table table-bordered table-striped ' id="example1">
            <thead>
                <tr>

                    <th width='5px'>#</th>
                    <th>Bank Soal</th>
                    <th>Level/Jur/Kelas</th>
                    <th>Durasi</th>
                    <th>Tgl Waktu Ujian</th>
                    <th>Opsi Ujian</th>
                    <th>Status Ujian</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php

                if ($pengawas['level'] == 'admin') {
                    $mapelQ = mysqli_query($koneksi, "SELECT * FROM ujian ORDER BY tgl_ujian ASC, waktu_ujian ASC");
                } else {
                    $mapelQ = mysqli_query($koneksi, "SELECT * FROM ujian where id_guru='$id_pengawas' ORDER BY tgl_ujian ASC, waktu_ujian ASC");
                }
                ?>
                <?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
                    <?php if ($mapel['tgl_ujian'] > date('Y-m-d H:i:s') and $mapel['tgl_selesai'] > date('Y-m-d H:i:s')) {
                        $color = "bg-gray";
                        $status = "BELUM MULAI";
                    } elseif ($mapel['tgl_ujian'] < date('Y-m-d H:i:s') and $mapel['tgl_selesai'] > date('Y-m-d H:i:s')) {
                        $color = "bg-blue";
                        $status = "<i class='fa fa-spinner fa-spin'></i> MULAI UJIAN";
                    } else {
                        $color = "bg-red";
                        $status = "<i class='fa fa-times'></i> WAKTU HABIS";
                    } ?>
                    <?php
                    $tgl = explode(" ", $mapel['tgl_ujian']);
                    $tgl = $tgl[0];
                    $no++;
                    ?>

                    <tr>
                        <td><?= $no ?></td>
                        <td>
                            <?php
                            if ($mapel['id_pk'] == '0') {
                                $jur = 'Semua';
                            } else {
                                $jur = $mapel['id_pk'];
                            }
                            ?>

                            <small class='badge bg-purple'><?= $mapel['kode_nama'] ?></small>
                        </td>
                        <td>
                            <i class="fa fa-tag"></i> <?= $mapel['kode_ujian'] ?> &nbsp;
                            <i class="fa fa-user"></i> <?= $mapel['level'] ?> &nbsp;
                            <i class="fa fa-wrench"></i>
                            <?php
                            $dataArray = unserialize($mapel['id_pk']);
                            foreach ($dataArray as $key => $value) :
                                echo $value . " ";
                            endforeach;
                            ?>
                            <br>
                            <?php
                            $dataArray = unserialize($mapel['kelas']);
                            foreach ($dataArray as $key => $value) :
                                echo $value . " ";
                            endforeach;
                            ?>
                        </td>
                        <td>
                            <small class='badge bg-yellow'>
                                <?= $mapel['tampil_pg'] ?> Soal / <?= $mapel['lama_ujian'] ?> m / <?= $mapel['opsi'] ?> opsi</small>
                        </td>
                        <td>
                            <small class="text-green"> <?= $mapel['tgl_ujian'] ?></small><br>
                            <small class="text-red"><?= $mapel['tgl_selesai'] ?></small>
                        </td>

                        <td>
                            <?php
                            if ($mapel['acak'] == 1) {
                                echo "<span class='badge bg-green' data-toggle='tooltip' data-placement='top' title='soal acak yes'>Y</span> ";
                            } elseif ($mapel['acak'] == 0) {
                                echo "<span class='badge bg-red' data-toggle='tooltip' data-placement='top' title='soal acak no'>N</span> ";
                            }
                            if ($mapel['ulang'] == 1) {
                                echo "<span class='badge bg-green' data-toggle='tooltip' data-placement='top' title='acak opsi yes'>Y</span> ";
                            } elseif ($mapel['ulang'] == 0) {
                                echo "<span class='badge bg-red' data-toggle='tooltip' data-placement='top' title='acak opsi no'>N</span> ";
                            }
                            if ($mapel['token'] == 1) {
                                echo "<span class='badge bg-green' data-toggle='tooltip' data-placement='top' title='token ujian yes'>Y</span> ";
                            } elseif ($mapel['token'] == 0) {
                                echo "<span class='badge bg-red' data-toggle='tooltip' data-placement='top' title='token ujian no'>N</span> ";
                            }
                            if ($mapel['hasil'] == 1) {
                                echo "<span class='badge bg-green' data-toggle='tooltip' data-placement='top' title='tampilkan nilai yes'>Y</span> ";
                            } elseif ($mapel['hasil'] == 0) {
                                echo "<span class='badge bg-red' data-toggle='tooltip' data-placement='top' title='tampilkan nilai no'>N</span> ";
                            }

                            if ($mapel['reset'] == 1) {
                                echo "<span class='badge bg-green' data-toggle='tooltip' data-placement='top' title='reset yes'>Y</span> ";
                            } elseif ($mapel['reset'] == 0) {
                                echo "<span class='badge bg-red' data-toggle='tooltip' data-placement='top' title='reset no'>N</span> ";
                            }
                            if ($mapel['ulang_kkm'] == 1) {
                                echo "<span class='badge bg-green' data-toggle='tooltip' data-placement='top' title='ulang kkm yes'>Y</span> ";
                            } elseif ($mapel['ulang_kkm'] == 0) {
                                echo "<span class='badge bg-red' data-toggle='tooltip' data-placement='top' title='ulang kkm no'>N</span> ";
                            }
                            ?>
                        </td>
                        <td style="text-align:center">
                            <?php
                            if ($mapel['status'] == 1) {
                                echo " <label class='badge bg-green'>Aktif</label> <label class='badge bg-red'>Sesi $mapel[sesi]</label>";
                            } elseif ($mapel['status'] == 0) {
                                echo "<label class='badge bg-red'>Tidak Aktif</label>";
                            }
                            ?>
                        </td>
                        <td style="text-align:center">
                            <?=
                                $status
                            ?> <br>
                            <i class="fa fa-circle text-green" data-toggle="tooltip" title="Peserta Online"></i>
                            <?=
                                $useronline = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_mapel='$mapel[id_mapel]' and id_ujian='$mapel[id_ujian]' and ujian_selesai is null"));
                            ?>
                            <i class="fa fa-circle text-danger" data-toggle="tooltip" title="Peserta Offline"></i>
                            <?=
                                $userend = mysqli_num_rows(mysqli_query($koneksi, "select * from nilai where id_mapel='$mapel[id_mapel]' and id_ujian='$mapel[id_ujian]' and ujian_selesai <> ''"));
                            ?>
                        </td>
                        <td style="text-align:center">
                            <div class='btn-grou'>
                                <a class='btn btn-warning ' data-id="<?= $mapel['id_ujian'] ?>" data-toggle='modal' data-target="#edit<?= $mapel['id_ujian'] ?>" title='Edit Waktu Ujian'><i class='fa fa-edit'></i></a>
                                <a href="?pg=status&id=<?= $mapel['id_ujian'] ?>" class='btn btn-danger ' data-toggle='tooltip' data-placement='top' title='Lihat Status Peserta'><i class='fa fa-users'></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php

                    if ($setting['server'] == 'pusat') {
                        $dis = '';
                    } else {
                        $dis = 'disabled';
                    }
                    ?>
                    <div class='modal fade' id='edit<?= $mapel['id_ujian'] ?>' style='display: none;'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header bg-blue'>
                                    <h5 class='modal-title'>Edit Waktu Ujian</h5>

                                </div>
                                <form id="formedit<?= $mapel['id_ujian'] ?>">
                                    <div class='modal-body'>
                                        <input type='hidden' name='idm' value="<?= $mapel['id_ujian'] ?>" />
                                        <div class="form-group">
                                            <label for="mulaiujian">Waktu Mulai Ujian</label>
                                            <input type="text" class="tgl form-control" name="tgl_ujian" value="<?= $mapel['tgl_ujian'] ?>" aria-describedby="helpId" placeholder="">
                                            <small id="helpId" class="form-text text-muted">Tanggal dan waktu ujian dibuka</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="selesaiujian">Waktu Ujian Ditutup</label>
                                            <input type="text" class="tgl form-control" name="tgl_selesai" value="<?= $mapel['tgl_selesai'] ?>" aria-describedby="helpId" placeholder="">
                                            <small id="helpId" class="form-text text-muted">Tanggal dan waktu ujian ditutup</small>
                                        </div>
                                        <div class='form-group'>
                                            <div class='row'>
                                                <div class='col-md-3'>
                                                    <label>Lama Ujian (menit)</label>
                                                    <input type='number' name='lama_ujian' value="<?= $mapel['lama_ujian'] ?>" class='form-control' required='true' />
                                                </div>
                                                <div class='col-md-3'>
                                                    <label>Sesi</label>
                                                    <input type='number' name='sesi' value="<?= $mapel['sesi'] ?>" class='form-control' required='true' />
                                                </div>
                                                <div class='col-md-3'>
                                                    <label>Selesai (menit)</label>
                                                    <input type='number' name='btn_selesai' value="<?= $mapel['btn_selesai'] ?>" class='form-control' required='true' />
                                                </div>
                                                <div class='col-md-3'>
                                                    <label>Pelanggaran (detik)</label>
                                                    <input type='number' name='pelanggaran' value="<?= $mapel['pelanggaran'] ?>" class='form-control' required='true' />
                                                </div>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <label>
                                                <input type='checkbox' class='icheckbox_square-green' name='acak' value='1' <?php if ($mapel['acak'] == 1) {
                                                                                                                                echo "checked='true'";
                                                                                                                            } ?> /> Acak Soal
                                            </label>
                                            <label>
                                                <input type='checkbox' class='icheckbox_square-green' name='acakopsi' value='1' <?php if ($mapel['ulang'] == 1) {
                                                                                                                                    echo "checked='true'";
                                                                                                                                } ?> /> Acak Opsi
                                            </label>
                                            <label>
                                                <input type='checkbox' class='icheckbox_square-green' name='token' value='1' <?php if ($mapel['token'] == 1) {
                                                                                                                                    echo "checked='true'";
                                                                                                                                } ?> /> Token Soal
                                            </label>
                                            <label>
                                                <input type='checkbox' class='icheckbox_square-green' name='hasil' value='1' <?php if ($mapel['hasil'] == 1) {
                                                                                                                                    echo "checked='true'";
                                                                                                                                } ?> /> Hasil Tampil
                                            </label>
                                            <label>
                                                <input type='checkbox' class='icheckbox_square-green' name='reset' value='1' <?php if ($mapel['reset'] == 1) {
                                                                                                                                    echo "checked='true'";
                                                                                                                                } ?> /> Reset Login
                                            </label>
                                            <label>
                                                <input type='checkbox' class='icheckbox_square-green' name='ulangkkm' value='1' <?php if ($mapel['ulang_kkm'] == 1) {
                                                                                                                                    echo "checked='true'";
                                                                                                                                } ?> /> Ulang KKM
                                            </label>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <center>
                                            <button type="submit" class='btn btn-primary' name='simpan'><i class='fa fa-save'></i> Ganti Waktu Ujian</button>
                                        </center>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        $("#formedit<?= $mapel['id_ujian'] ?>").submit(function(e) {
                            e.preventDefault();
                            $.ajax({
                                type: 'POST',
                                url: 'mod_jadwal/crud_jadwal.php?pg=ubah',
                                data: $(this).serialize(),
                                success: function(data) {
                                    iziToast.success({
                                        title: 'Mantap!',
                                        message: data,
                                        position: 'topRight'
                                    });
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);
                                }
                            });
                            return false;
                        });
                    </script>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>


    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        var autoRefresh = setInterval(
            function() {
                $('#isi_token').load('mod_jadwal/crud_jadwal.php?pg=token');
            }, 900000
        );
        $(document).ready(function() {
            $("#btntoken").click(function() {
                $.ajax({
                    url: "mod_jadwal/crud_jadwal.php?pg=token",
                    type: "POST",
                    success: function(respon) {
                        $('#isi_token').html(respon);
                        iziToast.success({
                            title: 'Mantap!',
                            message: 'Token diperbarui',
                            position: 'topRight'
                        });
                    }
                });
                return false;
            })
            $('#formaktivasi').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'mod_jadwal/crud_jadwal.php?pg=aktivasi',
                    data: $(this).serialize(),
                    success: function(data) {

                        iziToast.success({
                            title: 'Mantap!',
                            message: data,
                            position: 'topRight'
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);


                    }
                });
                return false;
            });

        });
    </script>
    <script>
        $('#formtambahujian').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'mod_jadwal/crud_jadwal.php?pg=tambah',
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
    </script>