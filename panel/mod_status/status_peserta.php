<?php if ($ac == '') : ?>
    <div class='row'>
        <?php if (isset($_GET['id'])) { ?>
            <?php $qujian = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian where id_ujian='$_GET[id]'")) ?>
            <?php $ikut = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM nilai where id_ujian='$_GET[id]'")) ?>
            <?php
            $kelas = implode("','", unserialize($qujian['kelas']));
            if ($kelas == "semua") {
                if ($qujian['level'] == 'semua') {
                    $peserta = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa "));
                } else {
                    $peserta = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa where level='$qujian[level]'"));
                }
            } else {
                $peserta = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa where id_kelas IN ('" . $kelas . "')"));
            }
            ?>
            <div class="col-lg-8">
                <div class="small-box bg-primary ">
                    <div class="inner">
                        Nama Ujian<h3><?= $qujian['nama'] ?></h3>
                        <?= $qujian['tgl_ujian'] ?> S/d <?= $qujian['tgl_selesai'] ?>
                    </div>
                    <div class="icon">
                        <!-- <i class="fa fa-file"></i> -->
                    </div>
                    <!-- <a href="?pg=banksoal" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                </div>
            </div>
            <?php if ($qujian['tgl_ujian'] > date('Y-m-d H:i:s') and $qujian['tgl_selesai'] > date('Y-m-d H:i:s')) {
                $color = "bg-gray";
                $status = "BELUM MULAI";
            } elseif ($qujian['tgl_ujian'] < date('Y-m-d H:i:s') and $qujian['tgl_selesai'] > date('Y-m-d H:i:s')) {
                $color = "bg-blue";
                $status = "<i class='fa fa-spinner fa-spin'></i> MULAI UJIAN";
            } else {
                $color = "bg-red";
                $status = "WAKTU HABIS";
            } ?>
            <div class="col-lg-4">
                <div class="small-box bg-yellow ">
                    <div class="inner">
                        Status Ujian<h3><?= $status ?></h3>
                        <?= $qujian['tampil_pg'] ?> Soal / <?= $qujian['lama_ujian'] ?> menit / <?= $qujian['opsi'] ?> opsi</small>
                    </div>
                    <div class="icon">
                        <!-- <i class="fa fa-file"></i> -->
                    </div>
                    <!-- <a href="?pg=banksoal" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                </div>
            </div>


            <div class="col-lg-2">
                <div class="small-box bg-green ">
                    <div class="inner">
                        Sedang Ujian<h3><i class="fas fa-user    "></i> <?= $ikut ?></h3>
                    </div>
                    <div class="icon">
                        <!-- <i class="fa fa-file"></i> -->
                    </div>
                    <!-- <a href="?pg=banksoal" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                </div>
            </div>
            <div class="col-lg-2">
                <div class="small-box bg-red ">
                    <div class="inner">
                        Belum Ujian<h3><i class="fas fa-user    "></i> <?= $peserta - $ikut ?></h3>
                    </div>
                    <div class="icon">
                        <!-- <i class="fa fa-file"></i> -->
                    </div>
                    <!-- <a href="?pg=banksoal" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                </div>
            </div>
            <div class="col-lg-2">

                <iframe name='printabsen' src='mod_status/print_absen.php?id=<?= enkripsi($_GET['id']) ?>' style='display:none'></iframe>
                <a role="button" onclick="frames['printabsen'].print()">
                    <div class="small-box bg-primary ">
                        <div class="inner">
                            Cetak Absensi
                            <center>
                                <h3><i class="fas fa-print"></i> </h3>
                            </center>
                        </div>
                        <div class="icon">
                            <!-- <i class="fa fa-file"></i> -->
                        </div>
                        <!-- <a href="?pg=banksoal" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                    </div>
                </a>
            </div>
            <div class="col-lg-2">
                <a href="?pg=beritaujian&id=<?= enkripsi($_GET['id']) ?>">
                    <div class="small-box bg-purple ">
                        <div class="inner">
                            Cetak Berita Acara
                            <center>
                                <h3><i class="fas fa-file"></i> </h3>
                            </center>
                        </div>
                        <div class="icon">
                            <!-- <i class="fa fa-file"></i> -->
                        </div>
                        <!-- <a href="?pg=banksoal" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                    </div>
                </a>
            </div>
            <div class="col-lg-2">
                <a href="mod_status/report_excel.php?m=<?= $_GET['id'] ?>">
                    <div class="small-box bg-green ">
                        <div class="inner">
                            Cetak Excel Nilai
                            <center>
                                <h3><i class="fas fa-file"></i> </h3>
                            </center>
                        </div>
                        <div class="icon">
                            <!-- <i class="fa fa-file"></i> -->
                        </div>
                        <!-- <a href="?pg=banksoal" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                    </div>
                </a>
            </div>
        <?php } ?>
        <div class='col-md-12'>

            <div class='box box-solid' id="statusfull">
                <div class='box-header with-border'>
                    <h3 class='box-title'><i class="fas fa-user-friends    "></i> Status Peserta </h3>
                    <div class='box-tools pull-right '>
                        <button type="button" class="btn btn-warning" id="btnselesai"><i class="fas fa-upload    "></i> Selesai Semua</button>
                        <button type="button" class="btn btn-primary" id="btnfull"><i class="fa fa-arrows-alt"></i> FullScreen</button>
                        <button type="button" class="btn btn-primary" id="closefull"><i class="fa fa-times"></i> Close</button>
                    </div>
                </div><!-- /.box-header -->
                <div class='box-body'>
                    <div class='alert alert-info'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <i class='icon fa fa-info'></i>
                        Status peserta akan muncul saat ujian berlangsung dan refresh setiap 10 detik..
                    </div>

                    <div id='divstatus'>
                        <?php
                        if (empty($_GET['id'])) {
                            $queryidu = "";
                        } else {
                            $queryidu = "and s.id_ujian='" . $_GET['id'] . "'";
                        }
                        $pengawas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE id_pengawas='$_SESSION[id_pengawas]'"));
                        $tglsekarang = date('Y-m-d');
                        $nilai_temp = mysqli_fetch_array(mysqli_query($koneksi, "SELECT *  FROM nilai_temp  s LEFT JOIN ujian c ON s.id_ujian=c.id_ujian  where c.status='1' and s.id_siswa<>'' " . $queryidu . " GROUP by s.id_nilai DESC"));
                        if($nilai_temp['ujian_selesai'<>""]){
                            if ($pengawas['level'] == 'admin') {
                                $nilaiq = mysqli_query($koneksi, "SELECT *  FROM nilai_temp  s LEFT JOIN ujian c ON s.id_ujian=c.id_ujian  where c.status='1' and s.id_siswa<>'' " . $queryidu . " GROUP by s.id_nilai DESC");
                            } elseif ($pengawas['level'] == 'pengawas') {
                                $nilaiq = mysqli_query($koneksi, "SELECT *  FROM nilai_temp  s LEFT JOIN ujian c ON s.id_ujian=c.id_ujian  JOIN siswa b ON b.id_siswa=s.id_siswa where c.status='1' and s.id_siswa<>'' and b.ruang='$pengawas[ruang]' " . $queryidu . " GROUP by s.id_nilai DESC");
                            } else {
                                $nilaiq = mysqli_query($koneksi, "SELECT *  FROM nilai_temp  s LEFT JOIN ujian c ON s.id_ujian=c.id_ujian  where c.status='1' and s.id_siswa<>'' and c.id_guru='$_SESSION[id_pengawas]' " . $queryidu . " GROUP by s.id_nilai DESC");
                            }
                        }else{
                            if ($pengawas['level'] == 'admin') {
                                $nilaiq = mysqli_query($koneksi, "SELECT *  FROM nilai  s LEFT JOIN ujian c ON s.id_ujian=c.id_ujian  where c.status='1' and s.id_siswa<>'' " . $queryidu . " GROUP by s.id_nilai DESC");
                            } elseif ($pengawas['level'] == 'pengawas') {
                                $nilaiq = mysqli_query($koneksi, "SELECT *  FROM nilai  s LEFT JOIN ujian c ON s.id_ujian=c.id_ujian  JOIN siswa b ON b.id_siswa=s.id_siswa where c.status='1' and s.id_siswa<>'' and b.ruang='$pengawas[ruang]' " . $queryidu . " GROUP by s.id_nilai DESC");
                            } else {
                                $nilaiq = mysqli_query($koneksi, "SELECT *  FROM nilai  s LEFT JOIN ujian c ON s.id_ujian=c.id_ujian  where c.status='1' and s.id_siswa<>'' and c.id_guru='$_SESSION[id_pengawas]' " . $queryidu . " GROUP by s.id_nilai DESC");
                            }
                        } ?>
                        <div class='table-responsive'>
                            <table id='example1' class='table table-bordered table-striped'>
                                <thead>
                                    <tr>
                                        <th width='5px'>#</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Mapel</th>
                                        <th>Lama Ujian</th>
                                        <th>Jawaban</th>
                                        <th>Nilai</th>
                                        <th>Ip Address</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id='divstatus'>
                                    <?php while ($nilai = mysqli_fetch_array($nilaiq)) {
                                        $tglx = strtotime($nilai['ujian_mulai']);
                                        $tgl = date('Y-m-d', $tglx);
                                        if ($tgl == $tglsekarang) {
                                            $no++;
                                            $ket = '';
                                            $lama = $jawaban = $skor = '--';
                                            $siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$nilai[id_siswa]' "));
                                            $kelas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$siswa[id_kelas]'"));
                                            $mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$nilai[id_mapel]'"));
                                            $nilaiQ = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_siswa='$siswa[id_siswa]'");
                                            $nilaiC = mysqli_num_rows($nilaiQ);

                                            if ($nilaiC <> 0) {
                                                $lama = '';
                                                if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] <> '') {
                                                    $selisih = strtotime($nilai['ujian_selesai']) - strtotime($nilai['ujian_mulai']);

                                                    $jawaban = "<small class='label bg-green'>$nilai[jml_benar] <i class='fa fa-check'></i></small>  <small class='label bg-red'>$nilai[jml_salah] <i class='fa fa-times'></i></small>";
                                                    $skor = "<small class='label bg-green'>" . number_format($nilai['skor'], 2, '.', '') . "</small>";
                                                    $ket = "<label class='label label-success'>Tes Selesai</label>";
                                                    $btn = "<button data-id='$nilai[id_nilai]' class='ulang btn btn-xs btn-warning'><i class='fa fa-history'></i></button>";
                                                } elseif ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] == '') {
                                                    $selisih = strtotime($nilai['ujian_berlangsung']) - strtotime($nilai['ujian_mulai']);

                                                    $ket = "<label class='label label-danger'><i class='fa fa-spin fa-spinner' title='Sedang ujian'></i>&nbsp;Dikerjakan</label>";

                                                    $btn = "<button data-id='$nilai[id_nilai]' class='hapus btn btn-xs btn-danger'>selesai</button>";
                                                }
                                            }
                                    ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $siswa['nis'] ?></td>
                                                <td><?= $siswa['nama'] ?></td>
                                                <td><?= $kelas['nama'] ?></td>
                                                <td><small class='label bg-red'><?= $nilai['kode_ujian'] ?></small> <small class='label bg-purple'><?= $mapel['nama'] ?></small> <small class='label bg-blue'><?= $mapel['level'] ?></small></td>
                                                <td><?= lamaujian($selisih) ?></td>
                                                <td><?= $jawaban ?></td>
                                                <td><?= $skor ?></td>
                                                <td><?= $nilai['ipaddress'] ?></td>
                                                <td><?= $ket ?></td>
                                                <td><?= $btn ?></td>

                                            </tr>

                                    <?php }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
<?php endif ?>
<script>
    var autoRefresh = setInterval(
        function() {
            <?php if (isset($_GET['id'])) { ?>
                $('#divstatus').load("mod_status/statusall_ujian.php?idu=<?= $_GET['id'] ?>");
            <?php } else { ?>
                $('#divstatus').load("mod_status/statusall.php");
            <?php } ?>
        }, 10000
    );

    function fullScreen(element) {
        if (element.requestFullScreen) {
            element.requestFullScreen();
        } else if (element.webkitRequestFullScreen) {
            element.webkitRequestFullScreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        }
    }
    var elem = document.documentElement;
    /* Close fullscreen */
    function closeFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            /* Safari */
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            /* IE11 */
            document.msExitFullscreen();
        }
    }

    $("#closefull").hide();
    $("#btnfull").click(function() {
        var element = document.getElementById('statusfull');
        fullScreen(element)
        $("#closefull").show();
        $(this).hide();
    });
    $("#closefull").click(function() {
        closeFullscreen();
        $("#btnfull").show();
        $(this).hide();
    });
    $("#btnselesai").click(function() {
        swal({
            title: 'Apa anda yakin?',
            text: "aksi ini akan menyelesaikan secara paksa semua ujian yang sedang berlangsung!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            target: document.getElementById("statusfull"),
        }).then((result) => {
            if (result.value) {
                <?php if (isset($_GET['id'])) { ?>
                    var urlx = 'mod_status/ajax_status.php?pg=selesaisemua&id=<?= $_GET['id'] ?>';
                <?php } else { ?>
                    var urlx = 'mod_status/ajax_status.php?pg=selesaisemua';
                <?php } ?>
                $.ajax({
                    url: urlx,
                    method: "POST",
                    success: function(data) {
                        //$('#htmlujianselesai').html('1');
                        toastr.options.target = '#statusfull';
                        toastr.success(data);
                    }
                });
            }
        })
    });
    $(document).on('click', '.hapus', function() {
        var id = $(this).data('id');
        console.log(id);
        swal({
            title: 'Apa anda yakin?',
            text: "aksi ini akan menyelesaikan secara paksa ujian yang sedang berlangsung!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            target: document.getElementById("statusfull"),
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'mod_status/ajax_status.php?pg=selesaikan',
                    method: "POST",
                    data: 'id=' + id,
                    success: function(data) {
                        //$('#htmlujianselesai').html('1');
                        toastr.options.target = '#statusfull';
                        toastr.success(data);
                    }
                });
            }
        })
    });

    $(document).on('click', '.ulang', function() {
        var id = $(this).data('id');
        console.log(id);
        swal({
            title: 'Apa anda yakin?',
            text: "Akan Mengulang Ujian Ini ??",

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            target: document.getElementById("statusfull"),
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'mod_status/ajax_status.php?pg=ulangujian',
                    method: "POST",
                    data: 'id=' + id,
                    success: function(data) {
                        toastr.options.target = '#statusfull';
                        toastr.success("berhasil diulang");
                    }
                });
            }
        })
    });
</script>