<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');

$pesan = '';
$value = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$id'"));
$tgl_ujian = explode(' ', $value['tgl_ujian']);
if ($ac == '') :
?>
    <div class='row'>
        <div class='col-md-12'><?= $pesan ?>
            <div class='box box-solid '>
                <div class='box-header with-border '>
                    <h3 class='box-title'><i class='fa fa-briefcase'></i> Data Bank Soal</h3>
                    <div class='box-tools pull-right '>
                        <?php if ($setting['server'] == 'pusat') : ?>
                            <button id='btnhapusbank' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> <span class='hidden-xs'>Hapus</span></button>
                            <button class='btn btn-sm btn-flat btn-success' data-toggle='modal' data-target='#tambahbanksoal'><i class='glyphicon glyphicon-plus'></i> <span class='hidden-xs'>Tambah Bank Soal</span></button>
                        <?php endif ?>
                    </div>
                </div><!-- /.box-header -->
                <div class='box-body'>
                    <div id='tablereset' class='table-responsive'>
                        <table id='example1' class='table table-bordered table-striped'>
                            <thead>
                                <tr>
                                    <th width='5px'><input type='checkbox' id='ceksemua'></th>
                                    <th width='5px'>No</th>
                                    <th>Mata Pelajaran</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pengawas['level'] == 'admin') :
                                    $mapelQ = mysqli_query($koneksi, "SELECT * FROM mapel ORDER BY date ASC");
                                elseif ($pengawas['level'] == 'guru') :
                                    $mapelQ = mysqli_query($koneksi, "SELECT * FROM mapel WHERE idguru='$pengawas[id_pengawas]' ORDER BY date ASC");
                                endif;
                                ?>
                                <?php while ($mapel = mysqli_fetch_array($mapelQ)) : ?>
                                    <?php
                                    $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_mapel='$mapel[id_mapel]'"));
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-$no' value="<?= $mapel['id_mapel'] ?>"></td>
                                        <td><small class='label label-primary'><?= $no ?></small></td>
                                        <td>
                                            <?php

                                            if ($cek <> 0) {
                                                if ($mapel['status'] == '0') :
                                                    $status = '<label class="label label-danger">non aktif</label>';
                                                else :
                                                    $status = '<label class="label label-success"> aktif </label>';
                                                endif;
                                            } else {
                                                $status = '<label class="label label-warning"> Soal Kosong </label>';
                                            }
                                            $guruku = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE id_pengawas = '$mapel[idguru]'"));
                                            ?>
                                            <img src="../dist/img/soal.png" width=45 alt="">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?= $no ?>" class="" aria-expanded="true">
                                                <span style="font-size:15px"><?= $mapel['kode'] ?> </span>
                                                <smal>[<?= $mapel['nama'] ?>]</smal> <?= $status ?>
                                            </a>
                                            <div id="collapseThree<?= $no ?>" class="panel-collapse collapse" aria-expanded="true">
                                                <div class="box-body">
                                                    <p>Level :<small class='label label-primary'><?= $mapel['level'] ?></small>
                                                        Jurusan : <?php
                                                                    $dataArray = unserialize($mapel['idpk']);
                                                                    foreach ($dataArray as $key => $value) :
                                                                        echo "<small class='label label-success'>$value </small>&nbsp;";
                                                                    endforeach;
                                                                    ?></p>
                                                    <p>PG : <small class='label label-warning'><?= $mapel['tampil_pg'] ?>/<?= $mapel['jml_soal'] ?></small>
                                                        <small class='label label-danger'><?= $mapel['bobot_pg'] ?> %</small>
                                                        <small class='label label-danger'><?= $mapel['opsi'] ?> opsi</small>

                                                        Essai : <small class='label label-warning'><?= $mapel['tampil_esai'] ?>/<?= $mapel['jml_esai'] ?></small>
                                                        <small class='label label-danger'><?= $mapel['bobot_esai'] ?> %</small></p>
                                                    <p> KKM : <small class='label label-danger'><?= $mapel['kkm'] ?></small>
                                                        Kelas : <?php
                                                                $dataArray = unserialize($mapel['kelas']);
                                                                foreach ($dataArray as $key => $value) :
                                                                    echo "<small class='label label-success'>$value </small>&nbsp;";
                                                                endforeach;
                                                                ?></p>

                                                    <p> Guru : <small class='label label-primary'><?= $guruku['nama'] ?></small></p>
                                                    <p> Soal Agama : <small class='label label-success'><?= $mapel['soal_agama'] ?></small></p>

                                                    <?php if ($setting['server'] == 'pusat') : ?>

                                                        <div class=''>
                                                            <a href='?pg=<?= $pg ?>&ac=lihat&id=<?= $mapel['id_mapel'] ?>'><button class='btn  btn-success btn-sm'><i class='fa fa-search'></i> Soal</button></a>
                                                            <a href='?pg=<?= $pg ?>&ac=importsoal&id=<?= $mapel['id_mapel'] ?>'><button class='btn btn-info btn-sm'><i class='fa fa-upload'></i> Import</button></a>
                                                            <a><button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editbanksoal<?= $mapel['id_mapel'] ?>'><i class='fa fa-edit'></i> Edit</button></a>
                                                            <button class="btn btn-primary btn-sm" data-toggle='modal' data-target='#copybanksoal<?= $mapel['id_mapel'] ?>'><i class="fas fa-copy    "></i> Copy Bank</button>
                                                        </div>

                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="copybanksoal<?= $mapel['id_mapel'] ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Copy Bank Soal</h5>

                                                </div>
                                                <form id="formcopybank<?= $mapel['id_mapel'] ?>">
                                                    <div class="modal-body">
                                                        <input type='hidden' name='idm' value='<?= $mapel['id_mapel'] ?>' />
                                                        <div class="form-group">
                                                            <label for="">Kode Bank Soal</label>
                                                            <input type="text" class="form-control" name="kodebank" aria-describedby="helpId" placeholder="">
                                                            <small id="helpId" class="form-text text-muted">isi kode bank soal baru</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Copy Bank Soal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $('#formcopybank<?= $mapel['id_mapel'] ?>').submit(function(e) {
                                            e.preventDefault();
                                            $.ajax({
                                                type: 'POST',
                                                url: 'mod_banksoal/crud_banksoal.php?pg=copy_bank',
                                                data: $(this).serialize(),
                                                success: function(data) {
                                                    if (data == "OK") {
                                                        toastr.success("bank soal berhasil digandakan");
                                                    } else {
                                                        toastr.error(data);
                                                    }
                                                    $('#copybanksoal<?= $mapel['id_mapel'] ?>').modal('hide');
                                                    setTimeout(function() {
                                                        location.reload();
                                                    }, 2000);

                                                }
                                            });
                                            return false;
                                        });
                                    </script>
                                    <div class='modal fade' id='editbanksoal<?= $mapel['id_mapel'] ?>' style='display: none;'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header bg-blue'>
                                                    <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                                                    <h3 class='modal-title'>Edit Bank Soal</h3>
                                                </div>
                                                <form id="formeditbank<?= $mapel['id_mapel'] ?>">
                                                    <div class='modal-body'>
                                                        <input type='hidden' name='idm' value='<?= $mapel['id_mapel'] ?>' />
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Kode Bank Soal</label>
                                                                    <input type="text" class="form-control" name="kode" value="<?= $mapel['kode'] ?>" required>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class='form-group'>
                                                                    <label>Mata Pelajaran</label>
                                                                    <select name='nama' class='form-control' required='true'>
                                                                        <option value=''></option>
                                                                        <?php
                                                                        $pkQ = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran ORDER BY nama_mapel ASC");
                                                                        while ($pk = mysqli_fetch_array($pkQ)) : ($pk['kode_mapel'] == $mapel['nama']) ? $s = 'selected' : $s = '';
                                                                            echo "<option value='$pk[kode_mapel]' $s>$pk[nama_mapel]</option>";
                                                                        endwhile;
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if ($setting['jenjang'] == 'SMK') : ?>
                                                            <div class='form-group'>
                                                                <label>Program Keahlian</label>
                                                                <select name='id_pk[]' class='select2 form-control' required='true' multiple='multiple' style="width: 100%">
                                                                    <option value='semua'>Semua</option>
                                                                    <?php
                                                                    $pkQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY program_keahlian ASC");
                                                                    while ($pk = mysqli_fetch_array($pkQ)) :
                                                                        if (in_array($pk['id_pk'], unserialize($mapel['idpk']))) : ?>
                                                                            <option value="<?= $pk['id_pk'] ?>" selected><?= $pk['id_pk'] ?></option>"
                                                                        <?php else : ?>
                                                                            <option value="<?= $pk['id_pk'] ?>"><?= $pk['id_pk'] ?></option>"
                                                                        <?php endif; ?>
                                                                    <?php endwhile;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class='form-group'>
                                                            <div class='row'>
                                                                <div class='col-md-6'>
                                                                    <label>Pilih Level</label>
                                                                    <select name='level' class='form-control' required='true'>
                                                                        <option value='semua'>Semua Level</option>
                                                                        <?php
                                                                        $lev = mysqli_query($koneksi, "SELECT * FROM level");
                                                                        while ($level = mysqli_fetch_array($lev)) : ($level['kode_level'] == $mapel['level']) ? $s = 'selected' : $s = '';
                                                                            echo "<option value='$level[kode_level]' $s>$level[kode_level]</option>";
                                                                        endwhile;
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class='col-md-6'>
                                                                    <label>Pilih Kelas</label><br>
                                                                    <select name='kelas[]' class='form-control select2' style='width:100%' multiple required='true'>
                                                                        <option value='semua'>Semua Kelas</option>
                                                                        <?php $lev = mysqli_query($koneksi, "SELECT * FROM kelas"); ?>
                                                                        <?php while ($kelas = mysqli_fetch_array($lev)) : ?>
                                                                            <?php if (in_array($kelas['id_kelas'], unserialize($mapel['kelas']))) : ?>
                                                                                <option value="<?= $kelas['id_kelas'] ?>" selected><?= $kelas['id_kelas'] ?></option>"
                                                                            <?php else : ?>
                                                                                <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['id_kelas'] ?></option>"
                                                                            <?php endif; ?>
                                                                        <?php endwhile ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            <div class='row'>
                                                                <div class='col-md-3'>
                                                                    <label>Jumlah Soal PG</label>
                                                                    <input type='number' name='jml_soal' class='form-control' value="<?= $mapel['jml_soal'] ?>" required='true' />
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <label>Bobot Soal PG %</label>
                                                                    <input type='number' name='bobot_pg' class='form-control' value="<?= $mapel['bobot_pg'] ?>" required='true' />
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <label>Soal Tampil</label>
                                                                    <input type='number' name='tampil_pg' class='form-control' value="<?= $mapel['tampil_pg'] ?>" required='true' />
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <label>Opsi</label>
                                                                    <select name='opsi' class='form-control'>
                                                                        <?php
                                                                        $opsi = array("3", "4", "5");
                                                                        for ($x = 0; $x < count($opsi); $x++) {
                                                                            if ($mapel['opsi'] == $opsi[$x]) :
                                                                                echo "<option value='$opsi[$x]' selected>$opsi[$x]</option>";
                                                                            else :
                                                                                echo "<option value='$opsi[$x]'>$opsi[$x]</option>";
                                                                            endif;
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            <div class='row'>
                                                                <div class='col-md-3'>
                                                                    <label>Jumlah Soal Essai</label>
                                                                    <input type='number' name='jml_esai' class='form-control' value="<?= $mapel['jml_esai'] ?>" required='true' />
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <label>Bobot Soal Essai %</label>
                                                                    <input type='number' name='bobot_esai' class='form-control' value="<?= $mapel['bobot_esai'] ?>" required='true' />
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <label>Soal Tampil</label>
                                                                    <input type='number' name='tampil_esai' class='form-control' value="<?= $mapel['tampil_esai'] ?>" required='true' />
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <label>KKM</label>
                                                                    <input type='number' name='kkm' class='form-control' value="<?= $mapel['kkm'] ?>" required='true' />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            <div class='row'>
                                                                <?php if ($pengawas['level'] == 'admin') : ?>
                                                                    <div class='col-md-4'>
                                                                        <label>Guru Pengampu</label>
                                                                        <select name='guru' class='form-control' required='true'>
                                                                            <?php
                                                                            $guruku = mysqli_query($koneksi, "SELECT * FROM pengawas where level='guru' order by nama asc");
                                                                            while ($guru = mysqli_fetch_array($guruku)) {
                                                                                ($guru['id_pengawas'] == $mapel['idguru']) ? $s = 'selected' : $s = '';
                                                                                echo "<option value='$guru[id_pengawas]' $s>$guru[nama]</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class='col-md-4'>
                                                                    <label>Soal Agama</label>
                                                                    <select name='agama' class='form-control'>
                                                                        <option value=''>Bukan Soal Agama</option>
                                                                        <?php
                                                                        $agam = mysqli_query($koneksi, "SELECT * FROM siswa group by agama");
                                                                        while ($agama = mysqli_fetch_array($agam)) : ($agama['agama'] == $mapel['soal_agama']) ? $s = 'selected' : $s = '';
                                                                            echo "<option value='" . $agama['agama'] . "' $s>$agama[agama]</option>";
                                                                        endwhile;
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <label>Status Soal</label>
                                                                    <select name='status' class='form-control' required='true'>
                                                                        <option value='1'>Aktif</option>
                                                                        <option value='0'>Non Aktif</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <button type='submit' name='editbanksoal' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $('#formeditbank<?= $mapel['id_mapel'] ?>').submit(function(e) {
                                            e.preventDefault();
                                            $.ajax({
                                                type: 'POST',
                                                url: 'mod_banksoal/crud_banksoal.php?pg=ubah',
                                                data: $(this).serialize(),
                                                success: function(data) {

                                                    if (data == "OK") {
                                                        toastr.success("bank soal berhasil dirubah");
                                                    } else {
                                                        toastr.error(data);
                                                    }
                                                    $('#editbanksoal<?= $mapel['id_mapel'] ?>').modal('hide');
                                                    setTimeout(function() {
                                                        location.reload();
                                                    }, 2000);

                                                }
                                            });
                                            return false;
                                        });
                                    </script>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    <div class='modal fade' id='tambahbanksoal' style='display: none;'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header bg-blue'>
                    <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                    <h3 class='modal-title'>Tambah Bank Soal</h3>
                </div>
                <form id="formtambahbank">
                    <div class='modal-body'>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Kode Bank Soal</label>
                                    <input type="text" class="form-control" name="kode" placeholder="Masukan Kode Bank Soal" required>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class='form-group'>
                                    <label>Mata Pelajaran</label>
                                    <select name='nama' class='form-control' required='true'>
                                        <option value=''></option>";
                                        <?php
                                        $pkQ = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran ORDER BY nama_mapel ASC");
                                        while ($pk = mysqli_fetch_array($pkQ)) {
                                            echo "<option value='$pk[kode_mapel]'>$pk[nama_mapel]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <?php if ($setting['jenjang'] == 'SMK') : ?>
                            <div class='form-group'>
                                <label>Program Keahlian</label>
                                <select name='id_pk[]' class='form-control select2' multiple="multiple" style='width:100%' required='true'>
                                    <option value='semua'>Semua</option>
                                    <?php
                                    $pkQ = mysqli_query($koneksi, "SELECT * FROM pk ORDER BY program_keahlian ASC");
                                    while ($pk = mysqli_fetch_array($pkQ)) :
                                        echo "<option value='$pk[id_pk]'>$pk[program_keahlian]</option>";
                                    endwhile;
                                    ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label>Level Soal</label>
                                    <select name='level' id='soallevel' class='form-control' required='true'>
                                        <option value=''></option>
                                        <option value='semua'>Semua</option>
                                        <?php
                                        $lev = mysqli_query($koneksi, "SELECT * FROM level");
                                        while ($level = mysqli_fetch_array($lev)) {
                                            echo "<option value='$level[kode_level]'>$level[kode_level]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class='col-md-6'>
                                    <label>Pilih Kelas</label><br>
                                    <select name='kelas[]' id='soalkelas' class='form-control select2' multiple='multiple' style='width:100%' required='true'>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <label>Jumlah Soal PG</label>
                                    <input type='number' id='soalpg' name='jml_soal' class='form-control' required='true' />
                                </div>
                                <div class='col-md-3'>
                                    <label>Bobot Soal PG %</label>
                                    <input type='number' name='bobot_pg' class='form-control' required='true' />
                                </div>
                                <div class='col-md-3'>
                                    <label>Soal Tampil</label>
                                    <input type='number' id='tampilpg' name='tampil_pg' class='form-control' required='true' />
                                </div>
                                <div class='col-md-3'>
                                    <label>Opsi</label>
                                    <select name='opsi' class='form-control'>
                                        <option value='3'>3</option>
                                        <option value='4'>4</option>
                                        <option value='5'>5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    <label>Jumlah Soal Essai</label>
                                    <input type='number' id='soalesai' name='jml_esai' class='form-control' />
                                </div>
                                <div class='col-md-3'>
                                    <label>Bobot Soal Essai %</label>
                                    <input type='number' name='bobot_esai' class='form-control' />
                                </div>
                                <div class='col-md-3'>
                                    <label>Soal Tampil</label>
                                    <input type='number' id='tampilesai' name='tampil_esai' class='form-control' />
                                </div>
                                <div class='col-md-3'>
                                    <label>KKM</label>
                                    <input type='number' name='kkm' class='form-control' required='true' />
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class='row'>
                                <?php if ($pengawas['level'] == 'admin') : ?>
                                    <div class='col-md-4'>
                                        <label>Guru Pengampu</label>
                                        <select name='guru' class='form-control' required='true'>
                                            <?php
                                            $guruku = mysqli_query($koneksi, "SELECT * FROM pengawas where level='guru' order by nama asc");
                                            while ($guru = mysqli_fetch_array($guruku)) {
                                                echo "<option value='$guru[id_pengawas]'>$guru[nama]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <div class='col-md-4'>
                                    <label>Soal Agama</label>
                                    <select name='agama' class='form-control'>
                                        <option value=''>Bukan Soal Agama</option>
                                        <?php
                                        $agam = mysqli_query($koneksi, "SELECT * FROM siswa group by agama");
                                        while ($agama = mysqli_fetch_array($agam)) :
                                            echo "<option value='" . $agama['agama'] . "' $s>$agama[agama]</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                                <div class='col-md-4'>
                                    <label>Status Soal</label>
                                    <select name='status' class='form-control' required='true'>
                                        <option value='1'>Aktif</option>
                                        <option value='0'>Non Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='submit' name='tambahsoal' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php elseif ($ac == 'input') : ?>
    <?php include 'mod_banksoal/input_soal.php'; ?>
<?php elseif ($ac == 'lihat') : ?>
    <?php
    $id_mapel = $_GET['id'];
    if (isset($_REQUEST['tambah'])) {
        $sip = $_SERVER['SERVER_NAME'];
        $smax = mysqli_query($koneksi, "SELECT max(qid) AS maxi FROM savsoft_qbank");
        while ($hmax = mysqli_fetch_array($smax)) :
            $jumsoal = $hmax['maxi'];
        endwhile;
        $smaop = mysqli_query($koneksi, "SELECT max(oid) AS maxop FROM savsoft_options");
        while ($hmaop = mysqli_fetch_array($smaop)) {
            $jumop = $hmaop['maxop'];
        }

        $b_op = ($jumop != 0) ? ($jumop / $jumsoal) : 0;
        $no = 1;
        $sqlcek = mysqli_query($koneksi, "SELECT * FROM savsoft_qbank");
        while ($r = mysqli_fetch_array($sqlcek)) {
            $s_soal = mysqli_fetch_array(mysqli_query($koneksi, "select * from savsoft_qbank where qid='$no'"));
            $soal_tanya = $s_soal['question'];
            $l_soal = $s_soal['lid'];
            $c_id = $s_soal['cid'];
            $g_soal = $s_soal['description'];
            $g_soal = str_replace(" ", "", $g_soal);
            $smin = mysqli_query($koneksi, " select min(oid) as mini from savsoft_options where qid='$no'");
            while ($hmin = mysqli_fetch_array($smin)) {
                $min_op = $hmin['mini'];
            }
            $sqlopc = mysqli_query($koneksi, " select * from savsoft_options where qid='$no' and oid='$min_op'");
            $ropc = mysqli_fetch_array($sqlopc);
            $opj1 = $ropc['q_option'];
            $opj1 = str_replace(" &ndash;", "-", $opj1);
            $opjs1 = $ropc['score'];
            $fileA = $ropc['q_option_match'];
            $fileA = str_replace(" ", "", $fileA);

            $dele = mysqli_query($koneksi, "DELETE FROM savsoft_options WHERE qid='$no' AND oid='$min_op'");

            $smin = mysqli_query($koneksi, " select min(oid) as mini from savsoft_options where qid='$no'");
            while ($hmin = mysqli_fetch_array($smin)) {
                $min_op = $hmin['mini'];
            }

            $sqlopc = mysqli_query($koneksi, " select * from savsoft_options where qid='$no' and oid='$min_op'");
            $rubah = mysqli_query($koneksi, " select * from savsoft_options where qid='$no'");
            $ck_jum = mysqli_num_rows($rubah);

            $ropc = mysqli_fetch_array($sqlopc);
            $opj2 = $ropc['q_option'];
            $opj2 = str_replace(" &ndash;", "-", $opj2);
            $opjs2 = $ropc['score'];
            $fileB = $ropc['q_option_match'];
            $fileB = str_replace(" ", "", $fileB);
            $dele = mysqli_query($koneksi, " delete from savsoft_options where qid='$no' and oid='$min_op'");
            $smin = mysqli_query($koneksi, " select min(oid) as mini from savsoft_options where qid='$no'");
            while ($hmin = mysqli_fetch_array($smin)) {
                $min_op = $hmin['mini'];
            }
            $sqlopc = mysqli_query($koneksi, " select * from savsoft_options where qid='$no' and oid='$min_op'");
            $ropc = mysqli_fetch_array($sqlopc);
            $opj3 = $ropc['q_option'];
            $opj3 = str_replace(" &ndash;", "-", $opj3);
            $opjs3 = $ropc['score'];
            $fileC = $ropc['q_option_match'];
            $fileC = str_replace(" ", "", $fileC);
            $dele = mysqli_query($koneksi, " delete from savsoft_options where qid='$no' and oid='$min_op'");
            $smin = mysqli_query($koneksi, " select min(oid) as mini from savsoft_options where qid='$no'");
            while ($hmin = mysqli_fetch_array($smin)) {
                $min_op = $hmin['mini'];
            }

            $sqlopc = mysqli_query($koneksi, " select * from savsoft_options where qid='$no' and oid='$min_op'");
            $ropc = mysqli_fetch_array($sqlopc);
            $opj4 = $ropc['q_option'];
            $opj4 = str_replace(" &ndash;", "-", $opj4);
            $opjs4 = $ropc['score'];
            $fileD = $ropc['q_option_match'];
            $fileD = str_replace(" ", "", $fileD);
            $dele = mysqli_query($koneksi, " delete from savsoft_options where qid='$no' and oid='$min_op'");
            $smin = mysqli_query($koneksi, " select min(oid) as mini from savsoft_options where qid='$no'");
            while ($hmin = mysqli_fetch_array($smin)) {
                $min_op = $hmin['mini'];
            }

            $sqlopc = mysqli_query($koneksi, " select * from savsoft_options where qid='$no' and oid='$min_op'");
            $ropc = mysqli_fetch_array($sqlopc);
            $opj5 = $ropc['q_option'];
            $opj5 = str_replace(" &ndash;", "-", $opj5);
            $opjs5 = $ropc['score'];
            $fileE = $ropc['q_option_match'];
            $fileE = str_replace(" ", "", $fileE);
            $dele = mysqli_query($koneksi, " delete from savsoft_options where qid='$no' and oid='$min_op'");
            if ($opjs1 == 1) {
                $kunci = "A";
            }
            if ($opjs2 == 1) {
                $kunci = "B";
            }
            if ($opjs3 == 1) {
                $kunci = "C";
            }
            if ($opjs4 == 1) {
                $kunci = "D";
            }
            if ($opjs5 == 1) {
                $kunci = "E";
            }
            if ($ck_jum !== 0) {
                $jns = "1";
            }
            if ($ck_jum == 0) {
                $jns = "2";
            }
            // $jwb522 = str_replace("&amp;lt;", "<", $jwb521);
            // $jwb422 = str_replace("&amp;lt;", "<", $jwb421);
            // $jwb322 = str_replace("&amp;lt;", "<", $jwb321);
            // $jwb222 = str_replace("&amp;lt;", "<", $jwb221);
            // $jwb122 = str_replace("&amp;lt;", "<", $jwb121);
            $soal_tanya2 = str_replace("&amp;lt;", "<", $soal_tanya);
            // $jwb52 = str_replace("&amp;gt;", ">", $jwb522);
            // $jwb42 = str_replace("&amp;gt;", ">", $jwb422);
            // $jwb32 = str_replace("&amp;gt;", ">", $jwb322);
            // $jwb22 = str_replace("&amp;gt;", ">", $jwb222);
            // $jwb12 = str_replace("&amp;gt;", ">", $jwb122);
            $soal_tanya = str_replace("&amp;gt;", ">", $soal_tanya2);
            $exec = mysqli_query($koneksi, "INSERT INTO soal (id_mapel,nomor,soal,pilA,pilB,pilC,pilD,pilE,jawaban,jenis,file1,fileA,fileB,fileC,fileD,fileE) VALUES ('$id_mapel','$no','$soal_tanya','$opj1','$opj2','$opj3','$opj4','$opj5','$kunci','$jns','$g_soal','$fileA','$fileB','$fileC','$fileD','$fileE')");
            if ($g_soal <> "") {
                $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$g_soal','$id_mapel')");
            }
            if ($fileA <> "") {
                $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$fileA','$id_mapel')");
            }
            if ($fileB <> "") {
                $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$fileB','$id_mapel')");
            }
            if ($fileC <> "") {
                $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$fileC','$id_mapel')");
            }
            if ($fileD <> "") {
                $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$fileD','$id_mapel')");
            }
            if ($fileE <> "") {
                $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$fileE','$id_mapel')");
            }
            $no++;
        }
        $hasil2 = mysqli_query($koneksi, "TRUNCATE TABLE savsoft_qbank");
        $hasil2 = mysqli_query($koneksi, "TRUNCATE TABLE savsoft_options");
    }
    $namamapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$id_mapel'"));
    if ($namamapel['jml_esai'] == 0) {
        $hide = 'hidden';
    } else {
        $hide = '';
    }
    if ($namamapel['jml_soal'] == 0) {
        $hidex = 'hidden';
    } else {
        $hidex = '';
    }
    ?>

    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-solid'>
                <div class='box-header with-border '>
                    <h3 class='box-title'>Daftar Soal <?= $namamapel['nama'] ?></h3>
                    <div class='box-tools pull-right '>
                        <a href='?pg=<?= $pg ?>&ac=input&id=<?= $id_mapel ?>&no=1&jenis=1' class='btn btn-sm  btn-primary <?= $hidex ?>'><i class='fa fa-plus'></i><span class='hidden-xs'> Add</span> PG</a>
                        <a href='?pg=<?= $pg ?>&ac=input&id=<?= $id_mapel ?>&no=1&jenis=2' class='btn btn-sm btn-warning <?= $hide ?>'><i class='fa fa-plus'></i><span class='hidden-xs'> Add</span> Essai</a>
                        <a class='btn btn-sm btn-flat btn-success' href='mod_banksoal/soal_excel.php?m=<?= $id_mapel ?>'><i class="fas fa-file-excel    "></i><span class='hidden-xs'> Excel</span></a>
                        <button class='btn btn-sm btn-flat btn-success' onclick="frames['frameresult'].print()"><i class='fa fa-print'></i><span class='hidden-xs'> Print</span></button>
                        <button id="btnkosongsoal" data-id="<?= $id_mapel ?>" class='btn btn-sm btn-danger'><i class='fa fa-trash'></i><span class='hidden-xs'> Kosongkan </span></button>
                        <iframe name='frameresult' src='mod_banksoal/cetaksoal.php?id=<?= $id_mapel ?>' style='border:none;width:1px;height:1px;'></iframe>
                    </div>
                </div><!-- /.box-header -->
                <div class='box-body'>
                    <div class='nav-tabs-custom'>
                        <ul class='nav nav-tabs'>
                            <li class='active'><a aria-expanded='true' href='#detail' data-toggle='tab'><i class='fa fa-envelope-open'></i> Daftar Soal</a></li>

                        </ul>
                        <div class='tab-content'>
                            <div class='tab-pane active' id='detail'>
                                <div class='table-responsive'>
                                    <b>A. Soal Pilihan Ganda</b>
                                    <table class='table table-bordered table-striped'>
                                        <tbody>
                                            <?php $soalq = mysqli_query($koneksi, "SELECT * FROM soal where id_mapel='$id_mapel' and jenis='1' order by nomor "); ?>
                                            <?php while ($soal = mysqli_fetch_array($soalq)) : ?>

                                                <tr>
                                                    <td style='width:30px'>
                                                        <?= $soal['nomor'] ?>
                                                    </td>
                                                    <td style="text-align:justify">
                                                        <?php
                                                        if ($soal['file'] <> '') :
                                                            $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                            $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                            $ext = explode(".", $soal['file']);
                                                            $ext = end($ext);
                                                            if (in_array($ext, $image)) {
                                                                echo "<p style='margin-bottom: 5px'><img src='$homeurl/files/$soal[file]' style='max-width:200px;'/></p>";
                                                            } elseif (in_array($ext, $audio)) {
                                                                echo "<p style='margin-bottom: 5px'><audio controls><source src='$homeurl/files/$soal[file]' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
                                                            } else {
                                                                echo "File tidak didukung!";
                                                            }
                                                        endif;
                                                        ?>
                                                        <?= $soal['soal']; ?>
                                                        <?php
                                                        if ($soal['file1'] <> '') :
                                                            $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                            $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                            $ext = explode(".", $soal['file1']);
                                                            $ext = end($ext);
                                                            if (in_array($ext, $image)) {
                                                                echo "<p style='margin-top: 5px'><img src='$homeurl/files/$soal[file1]' style='max-width:200px;' /></p>";
                                                            } elseif (in_array($ext, $audio)) {
                                                                echo "<p style='margin-top: 5px'><audio controls><source src='$homeurl/files/$soal[file1]' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
                                                            } else {
                                                                echo "File tidak didukung!";
                                                            }
                                                        endif;
                                                        ?>
                                                        <table width=100%>
                                                            <tr>
                                                                <td style="padding: 3px;width: 2%; vertical-align: text-top;">A.</td>
                                                                <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                                    <?php
                                                                    if ($soal['pilA'] <> '') {
                                                                        echo "$soal[pilA] ";
                                                                    }

                                                                    if ($soal['fileA'] <> '') {
                                                                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                        $ext = explode(".", $soal['fileA']);
                                                                        $ext = end($ext);
                                                                        if (in_array($ext, $image)) {
                                                                            echo "<img src='$homeurl/files/$soal[fileA]' style='max-width:100px;'/>";
                                                                        } elseif (in_array($ext, $audio)) {
                                                                            echo "<audio controls><source src='$homeurl/files/$soal[fileA]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                                                                        } else {
                                                                            echo "File tidak didukung!";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td style="padding: 3px;width: 2%; vertical-align: text-top;">C.</td>
                                                                <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                                    <?php
                                                                    if (!$soal['pilC'] == "") {
                                                                        echo "$soal[pilC] ";
                                                                    }

                                                                    if ($soal['fileC'] <> '') {
                                                                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                        $ext = explode(".", $soal['fileC']);
                                                                        $ext = end($ext);
                                                                        if (in_array($ext, $image)) {
                                                                            echo "<img src='$homeurl/files/$soal[fileC]' style='max-width:100px;' />";
                                                                        } elseif (in_array($ext, $audio)) {
                                                                            echo "<audio controls><source src='$homeurl/files/$soal[fileC]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                                                                        } else {
                                                                            echo "File tidak didukung!";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <?php if ($namamapel['opsi'] == 5) : ?>
                                                                    <td style="padding: 3px;width: 2%; vertical-align: text-top;">E.</td>
                                                                    <td style="padding: 3px; vertical-align: text-top;">
                                                                        <?php
                                                                        if (!$soal['pilE'] == "") {
                                                                            echo "$soal[pilE] ";
                                                                        }

                                                                        if ($soal['fileE'] <> '') {
                                                                            $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                            $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                            $ext = explode(".", $soal['fileE']);
                                                                            $ext = end($ext);
                                                                            if (in_array($ext, $image)) {
                                                                                echo "<img src='$homeurl/files/$soal[fileE]' style='max-width:100px;' />";
                                                                            } elseif (in_array($ext, $audio)) {
                                                                                echo "<audio controls><source src='$homeurl/files/$soal[fileE]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                                                                            } else {
                                                                                echo "File tidak didukung!";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php endif; ?>

                                                            </tr>

                                                            <tr>
                                                                <td style="padding: 3px;width: 2%; vertical-align: text-top;">B.</td>
                                                                <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                                    <?php
                                                                    if (!$soal['pilB'] == "") {
                                                                        echo "$soal[pilB] ";
                                                                    }

                                                                    if ($soal['fileB'] <> '') {
                                                                        $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                        $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                        $ext = explode(".", $soal['fileB']);
                                                                        $ext = end($ext);
                                                                        if (in_array($ext, $image)) {
                                                                            echo "<img src='$homeurl/files/$soal[fileB]' style='max-width:100px;' />";
                                                                        } elseif (in_array($ext, $audio)) {
                                                                            echo "<audio controls><source src='$homeurl/files/$soal[fileB]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                                                                        } else {
                                                                            echo "File tidak didukung!";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <?php if ($namamapel['opsi'] <> 3) : ?>
                                                                    <td style="padding: 3px;width: 2%; vertical-align: text-top;">D.</td>
                                                                    <td style="padding: 3px;width: 31%; vertical-align: text-top;">
                                                                        <?php
                                                                        if (!$soal['pilD'] == "") {
                                                                            echo "$soal[pilD] ";
                                                                        }

                                                                        if ($soal['fileD'] <> '') {
                                                                            $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                                            $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                                            $ext = explode(".", $soal['fileD']);
                                                                            $ext = end($ext);
                                                                            if (in_array($ext, $image)) {
                                                                                echo "<img src='$homeurl/files/$soal[fileD]' style='max-width:100px;' />";
                                                                            } elseif (in_array($ext, $audio)) {
                                                                                echo "<audio controls><source src='$homeurl/files/$soal[fileD]' type='audio/$ext'>Your browser does not support the audio tag.</audio>";
                                                                            } else {
                                                                                echo "File tidak didukung!";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </td>

                                                                <?php endif; ?>

                                                            </tr>

                                                        </table>
                                                        <b> Kunci : <?= $soal['jawaban'] ?> </b>
                                                    </td>
                                                    <td style='width:30px'>
                                                        <a><button class='btn bg-maroon btn-sm' data-toggle='modal' data-target="#hapus<?= $soal['id_soal'] ?>"><i class='fa fa-trash'></i></button></a>
                                                    </td>

                                                </tr>
                                                <?php
                                                $info = info("Anda yakin akan menghapus soal ini ?");
                                                if (isset($_POST['hapus'])) {
                                                    $exec = mysqli_query($koneksi, "DELETE FROM soal WHERE id_soal = '$_REQUEST[idu]'");
                                                    (!$exec) ? info("Gagal menyimpan", "NO") : jump("?pg=$pg&ac=$ac&id=$id_mapel");
                                                }
                                                ?>
                                                <div class='modal fade' id="hapus<?= $soal['id_soal'] ?>" style='display: none;'>
                                                    <div class='modal-dialog'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header bg-maroon'>
                                                                <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                                                                <h3 class='modal-title'>Hapus Soal</h3>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <form action='' method='post'>
                                                                    <input type='hidden' id='idu' name='idu' value="<?= $soal['id_soal'] ?>" />
                                                                    <div class='callout '>
                                                                        <h4><?= $info ?></h4>
                                                                    </div>
                                                                    <div class='modal-footer'>
                                                                        <div class='box-tools pull-right '>
                                                                            <button type='submit' name='hapus' class='btn btn-sm bg-maroon'><i class='fa fa-trash-o'></i> Hapus</button>
                                                                            <button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                    <b>B. Soal Essai</b>
                                    <table class='table table-bordered table-striped'>
                                        <tbody>
                                            <?php $soalq = mysqli_query($koneksi, "SELECT * FROM soal where id_mapel='$id_mapel' and jenis='2' order by nomor "); ?>
                                            <?php while ($soal = mysqli_fetch_array($soalq)) : ?>
                                                <tr>
                                                    <td style='width:30px'>
                                                        <?= $soal['nomor'] ?>
                                                    </td>
                                                    <td style="text-align:justify">
                                                        <?php
                                                        if ($soal['file'] <> '') :
                                                            $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                            $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                            $ext = explode(".", $soal['file']);
                                                            $ext = end($ext);
                                                            if (in_array($ext, $image)) {
                                                                echo "<p style='margin-bottom: 5px'><img src='$homeurl/files/$soal[file]' style='max-width:200px;'/></p>";
                                                            } elseif (in_array($ext, $audio)) {
                                                                echo "<p style='margin-bottom: 5px'><audio controls><source src='$homeurl/files/$soal[file]' type='audio/$ext'>Your browser does not support the audio tag.</audio><br></p>";
                                                            } else {
                                                                echo "File tidak didukung!";
                                                            }
                                                        endif;
                                                        ?>
                                                        <?= $soal['soal']; ?>
                                                        <?php
                                                        if ($soal['file1'] <> '') :
                                                            $audio = array('mp3', 'wav', 'ogg', 'MP3', 'WAV', 'OGG');
                                                            $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'JPG', 'JPEG', 'PNG', 'GIF', 'BMP');
                                                            $ext = explode(".", $soal['file1']);
                                                            $ext = end($ext);
                                                            if (in_array($ext, $image)) {
                                                                echo "<p style='margin-top: 5px'><img src='$homeurl/files/$soal[file1]' style='max-width:200px;' /></p>";
                                                            } elseif (in_array($ext, $audio)) {
                                                                echo "<p style='margin-top: 5px'><audio controls><source src='$homeurl/files/$soal[file1]' type='audio/$ext'>Your browser does not support the audio tag.</audio></p>";
                                                            } else {
                                                                echo "File tidak didukung!";
                                                            }
                                                        endif;
                                                        ?>
                                                    </td>
                                                    <td style='width:30px'>
                                                        <a><button class='btn bg-maroon btn-sm' data-toggle='modal' data-target="#hapus<?= $soal['id_soal'] ?>"><i class='fa fa-trash'></i></button></a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $info = info("Anda yakin akan menghapus soal ini ?");
                                                if (isset($_POST['hapus'])) {
                                                    $exec = mysqli_query($koneksi, "DELETE FROM soal WHERE id_soal = '$_REQUEST[idu]'");
                                                    (!$exec) ? info("Gagal menyimpan", "NO") : jump("?pg=$pg&ac=$ac&id=$id_mapel");
                                                }
                                                ?>
                                                <div class='modal fade' id="hapus<?= $soal['id_soal'] ?>" style='display: none;'>
                                                    <div class='modal-dialog'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header bg-maroon'>
                                                                <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                                                                <h3 class='modal-title'>Hapus Soal</h3>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <form action='' method='post'>
                                                                    <input type='hidden' id='idu' name='idu' value="<?= $soal['id_soal'] ?>" />
                                                                    <div class='callout callout-warning'>
                                                                        <h4><?= $info ?></h4>
                                                                    </div>
                                                                    <div class='modal-footer'>
                                                                        <div class='box-tools pull-right '>
                                                                            <button type='submit' name='hapus' class='btn btn-sm bg-maroon'><i class='fa fa-trash-o'></i> Hapus</button>
                                                                            <button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
<?php elseif ($ac == 'hapusfile') : ?>
    <?php
    $jenis = $_GET['jenis'];
    $id = $_GET['id'];
    $file = $_GET['file'];
    $soal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM soal WHERE id_soal='$id'"));
    (file_exists("../files/" . $soal[$file])) ? unlink("../files/" . $soal[$file]) : null;
    mysqli_query($koneksi, "UPDATE soal SET $file='' WHERE id_soal='$id'");
    jump("?pg=$pg&ac=input&paket=$soal[paket]&id=$soal[id_mapel]&no=$soal[nomor]&jenis=$jenis");
    ?>
<?php elseif ($ac == 'importsoal') : ?>
    <?php include "import_soal.php"; ?>
<?php endif; ?>
<script>
    $(function() {
        $("#btnhapusbank").click(function() {
            i = 0;
            id_array = new Array();
            $("input.cekpilih:checked").each(function() {
                id_array[i] = $(this).val();
                i++;
            });
            swal({
                title: 'Bank Soal Terpilih ' + i,
                text: 'Apakah kamu yakin akan menghapus data bank soal yang sudah dipilih  ini ??',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'mod_banksoal/crud_banksoal.php?pg=hapus',
                        data: "kode=" + id_array,
                        type: "POST",
                        success: function(respon) {
                            console.log(respon);
                            if (respon == 1) {
                                $("input.cekpilih:checked").each(function() {
                                    $(this).parent().parent().remove('.cekpilih').animate({
                                        opacity: "hide"
                                    }, "slow");
                                })
                            }
                        }
                    })
                }
            });
            return false;
        })
    });
    $("#btnkosongsoal").click(function() {
        var id = $(this).data('id');
        swal({
            title: 'Konfirmasi ',
            text: 'Apakah kamu yakin akan menghapus semua soal ??',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'mod_banksoal/crud_banksoal.php?pg=kosongsoal',
                    data: "id=" + id,
                    type: "POST",
                    success: function(respon) {
                        toastr.success('soal berhasil dihapus');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                })
            }
        });
        return false;
    })
    $('#formsoal').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'mod_banksoal/crud_banksoal.php?pg=simpan_soal',
            enctype: 'multipart/form-data',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {},
            success: function(data) {
                toastr.success('soal berhasil disimpan');
            }
        })
        return false;
    });
    $('#formtambahbank').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'mod_banksoal/crud_banksoal.php?pg=tambah',
            data: $(this).serialize(),
            success: function(data) {
                console.log(data);
                if (data == "OK") {
                    toastr.success("bank soal berhasil dibuat");
                } else {
                    toastr.error(data);
                }
                $('#tambahbanksoal').modal('hide');
                setTimeout(function() {
                    location.reload();
                }, 2000);

            }
        });
        return false;
    });
    $("#soallevel").change(function() {
        var level = $(this).val();
        console.log(level);
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "mod_banksoal/crud_banksoal.php?pg=ambil_kelas", // Isi dengan url/path file php yang dituju
            data: "level=" + level, // data yang akan dikirim ke file yang dituju
            success: function(response) { // Ketika proses pengiriman berhasil
                $("#soalkelas").html(response);
            }
        });
    });
</script>
<script>
    tinymce.init({
        selector: '.editor1',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste formula'
        ],

        toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | formula code | imagetools link image paste ',
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        paste_data_images: true,

        images_upload_handler: function(blobInfo, success, failure) {
            success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
        },
        image_class_list: [{
            title: 'Responsive',
            value: 'img-responsive'
        }],
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        }
    });
</script>