<?php if ($ac == "") { ?>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-solid'>
                <div class='box-header with-border '>
                    <h3 class='box-title'><i class="fas fa-edit fa-fw   "></i> Progress Ujian</h3>
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
                        <table style="font-size: 11px" id='example1' class='table table-bordered table-striped'>
                            <thead>
                                <tr>
                                    <th width='3px'>No</th>
                                    <th>Nama Ujian</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php $mapel = mysqli_query($koneksi, "select * from nilai a join siswa b on a.id_siswa=b.id_siswa where b.id_kelas ='$pengawas[jabatan]' group by a.id_mapel") ?>
                                <?php while ($data = mysqli_fetch_array($mapel)) { ?>
                                    <?php $napel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel where id_mapel='$data[id_mapel]'")) ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $napel['kode'] ?></td>
                                        <td>
                                            <a href="?pg=progress&ac=lihat&id=<?= $data['id_mapel'] ?>" type="button" class="btn btn-xs btn-success"><i class="fas fa-eye    "></i> Lihat</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } elseif ($ac == "lihat") { ?>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-solid'>
                <div class='box-header with-border '>
                    <h3 class='box-title'><i class="fas fa-user-friends fa-fw   "></i> Progress Peserta <?= $pengawas['jabatan'] ?></h3>
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
                        <div id="divstatus">
                            <table style="font-size: 11px" class='table table-bordered table-striped'>
                                <thead>
                                    <tr>
                                        <th width='3px'>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Online</th>
                                        <th>No Hp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php $mapel = mysqli_query($koneksi, "select * from  siswa where id_kelas ='$pengawas[jabatan]'") ?>
                                    <?php while ($data = mysqli_fetch_array($mapel)) { ?>
                                        <?php $nilai = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM nilai where id_siswa='$data[id_siswa]' and id_mapel='$_GET[id]'")); ?>
                                        <?php $ujian = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel where id_mapel='$_GET[id]'")); ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['nis'] ?></td>
                                            <td><?= $data['nama'] ?></td>
                                            <td>
                                                <?php if ($nilai) { ?>
                                                    <?php if ($nilai['skor'] <> '') { ?>
                                                        <span class="badge bg-green">Sudah Ujian</span>
                                                    <?php } else { ?>
                                                        <span class="badge bg-yellow"><i class="fas fa-spinner fa-spin   "></i> Sedang Ujian</span>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <span class="badge bg-red"> Belum Ujian</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($data['online'] == 1) { ?>
                                                    <span class="badge bg-green">Online</span>
                                                <?php  } else { ?>
                                                    <span class="badge bg-red">Offline</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if (!$nilai) { ?>
                                                    <a target="_blank" href="https://api.whatsapp.com/send?phone=<?= $data['hp'] ?>&text=<?= $data['nama'] ?>%20kamu%20belum%20ujian%20<?= $ujian['kode'] ?>.%20Ayo Segera Kerjakan." role="button"><i class="fab fa-2x fa-whatsapp text-green   "></i> <?= $data['hp'] ?></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var autoRefresh = setInterval(
            function() {
                $('#divstatus').load("mod_walas/progress_real.php?id=<?= $_GET['id'] ?>");
            }, 5000
        );
    </script>
<?php } ?>