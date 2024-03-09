<?php

$nilai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM nilai"));
$soal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mapel"));
$siswa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa"));
$ruang = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM ruang"));
$kelas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kelas"));
$mapel = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mata_pelajaran"));
$online = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM jawaban"));
$ujian = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM ujian where status='1'"));
$tugas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas"));
$jawaban = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM jawaban"));
$gurune = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengawas"));
$file = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM file_pendukung"));
?>
<?php if ($pengawas['level'] == 'admin') : ?>

    <div style="display:scroll; position:fixed; top:150px; center:20px;">
        <img border="0" src="../dist/img/semutfuny.gif" />
    </div>

    <div class='row'>
        <div class='col-md-12'  style="padding-bottom: 10px;">
            <div class="row">
                <div class="col-md-12">
                    <span class='hidden-xs'>
                        <a href="../berkas/index.html" target="_blank" class="btn bg-black">
                            <i class="fas fa-file-pdf"></i> Docs</a>
                        <a href="https://cbtcandy.com" target="_blank" class="btn btn-success">
                            <i class="fab fa-wordpress"></i> Website</a>
                        <a href="https://t.me/+H3JNAkTkvx4wNTc1" target="_blank" class="btn btn-primary">
                            <i class="fab fa-telegram-plane"></i> Telegram</a>
                        <a href="https://www.youtube.com/@tjkt.smkyasmida" target="_blank" class="btn btn-danger">
                            <i class="fab fa-youtube"></i> Youtube</a>
                        <a href="https://www.instagram.com/tjkt.smkyasmida" target="_blank" class="btn btn-warning">
                            <i class="fab fa-instagram"></i> Instagram</a>
                        <a href="https://www.youtube.com/@tjkt.smkyasmida" target="_blank" class="btn btn-info">
                            <i class="fab fa-facebook"></i> Facebook</a>
                        <a href="#" target="_blank" class="btn btn-danger">
                            <i class="fab fa-pinterest"></i> Pinterest</a>
                        <a href="https://github.com/tjktsmkyasmida?tab=repositories" target="_blank" class="btn bg-maroon">
                            <i class="fab fa-github"></i> Github</a>
                        <a href="#" target="_blank" class="btn bg-blue">
                            <i class="fab fa-google-play"></i> Play Store</a>
                        <a href="#" target="_blank" class="btn btn-warning">
                            <i class="fab fa-blogger-b"></i> Blog</a>

                    </span> 
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class='row'>
                <?php if ($setting['server'] == 'pusat') : ?>
                    <div class="col-lg-6">
                        <div class="small-box">
                            <div class="tjkt">
                            <img src="../dist/img/tjktxyz.png" style="width:370px;height:111px; padding: 10px;">
                            </div>
                        <a href="tjktsmksyasmida.txt" target="_blank" class="small-box-footer">More Info 
                            <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    
                <?php endif; ?>

                <?php if ($setting['server'] == 'lokal') : ?>
                    <div class="col-lg-6">
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <img id='loading-image' src='../dist/img/ajax-loader.gif' style='display:none; width:50px;' />
                                Status Server Ke Server <b><?= $setting[id_server] ?></b>
                                <p id='statusserver'></p>
                                <b>Link Server Pusat :</b> <?= $setting['url_host'] ?><br/>
                                <b>Token Api :</b> <?= $setting['token_api'] ?>
                            </div>
                            <div class="icon">
                                <i class="fa fa-desktop"></i>
                            </div>
                            <a href="?pg=sinkronset" class="small-box-footer">Setting Sinkron <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <script>
                        $.ajax({
                            type: 'POST',
                            url: 'mod_sinkron/statusserver.php',
                            beforeSend: function() {
                                $('#loading-image').show();
                            },
                            success: function(response) {
                                $('#statusserver').html(response);
                                $('#loading-image').hide();
                            }
                        });
                    </script>
                <?php endif; ?>
                
                    <div class="col-lg-6">
                    <div class="small-box">
                        <div class="timit">
                            <h3>TIM IT UYE</h3>
                            <h4>SMK YASMIDA AMBARAWA</h4>
                            <h5>Terdepan dalam Teknologi</h5>
                        </div>
                        <div class="icon">
                            <img src="../dist/img/logotimit.png" style="width:160px;height:160px;">
                        </div>
                        <a href="http://timit.smkyasmida.sch.id" target="_blank" class="small-box-footer">More Info 
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-3 hidden-xs">
            <div class='small-box'>
                <div class='timit'>
                    <strong><i class='fa fa-building-o'></i> <?= $setting['sekolah'] ?></strong><br />
                    <?= $setting['alamat'] ?><br /><br />
                    <p></p>
                    <strong><i class='fas fa-paperclip'></i> NPSN : <?= $setting['kode_sekolah'] ?></strong><br />
                    <strong><i class='fa fa-phone'></i> TELP. : <?= $setting['telp'] ?></strong><br />
                    <strong><i class='fa fa-globe'></i> WEB : <?= $setting['web'] ?></strong><br />
                    <strong><i class='fa fa-at'></i> EMAIL : <?= $setting['email'] ?></strong><br />

                </div><!-- /.box-body -->
                <div class="icon" style="padding-top:10px;">
                    <img src="../dist/img/logo87.png" style="width:80px;height:80px;">
                </div>
            </div><!-- /.box -->
        </div>


        <div class="col-lg-9">
            <div class='row'>

                  <div class="col-lg-4">
                    <div class="small-box bg-purple ">
                        <div class="inner">
                            <h7><?= $siswa ?> </h7>
                            Siswa/i
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="?pg=siswa" class="small-box-footer">Data Peserta 
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="small-box bg-yellow ">
                        <div class="inner">
                            <h7><?= $gurune ?> </h7>
                            Guru/Fasilitator
                        </div>
                        <div class="icon">
                            <i class="fas fa-address-book"></i>
                        </div>
                        <a href="?pg=guru" class="small-box-footer">Data Guru 
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="small-box bg-fuchsia ">
                        <div class="inner">
                            <h7><?= $kelas ?> </h7>
                            Kelas
                        </div>
                        <div class="icon">
                            <i class="fas fa-school"></i>
                        </div>
                        <a href="?pg=kelas" class="small-box-footer">Data Kelas 
                            <i class="fa fa-arrow-circle-right"></i></a>
                        <!-- Button trigger modal -->
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="small-box bg-blue ">
                        <div class="inner">
                            <h7><?= $mapel ?> </h7>
                            Mata Pelajaran
                        </div>
                        <div class="icon">
                            <i class="fa fa-envelope-open-text"></i>
                        </div>
                        <a href="?pg=matapelajaran" class="small-box-footer">Mata Pelajaran 
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="small-box bg-red ">
                        <div class="inner">
                            <h7><?= $soal ?> </h7>
                            Bank Soal
                        </div>
                        <div class="icon">
                            <i class="far fa-file-archive"></i>
                        </div>
                        <a href="?pg=banksoal" class="small-box-footer">Data Bank Soal 
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="small-box bg-maroon ">
                        <div class="inner">
                            <h7><?= $file ?> </h7>
                            File Pendukung
                        </div>
                        <div class="icon">
                            <i class="far fa-file-image"></i>
                        </div>
                        <a href="?pg=filependukung" class="small-box-footer">File Pendukung 
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                

                <div class="col-lg-4">
                    <div class="small-box bg-green ">
                        <div class="inner">
                            <h7><?= $ujian ?> </h7>
                            Jadwal Ujian
                        </div>
                        <div class="icon">
                            <i class="fa fa-edit"></i>
                        </div>
                        <a href="?pg=jadwal" class="small-box-footer">Data Jadwal 
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="small-box bg-light-blue ">
                        <div class="inner">
                            <h7><?= $nilai ?> </h7>
                            Nilai
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-signature"></i>
                        </div>
                        <a href="?pg=nilaiujian" class="small-box-footer">Data Nilai 
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="small-box bg-aqua ">
                        <div class="inner">
                            <h7><?= $jawaban ?> </h7>
                            Jawaban
                        </div>
                        <div class="icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <a href="#" id="btnhapusjawaban" class="small-box-footer">Hapus Jawaban 
                            <i class="fa fa-arrow-circle-right"></i></a>
                        <!-- Button trigger modal -->
                    </div>
                </div>
                


                
                
            </div>
        </div>
        



<?php 
$memo = memory_get_usage(true) . "\n"; 
$use = memory_get_usage(false) . "\n";
$df = disk_total_space("/");
$df_c = disk_free_space("/") 
?>
<?php
$ua = getBrowser();
$yourbrowser = $ua['name'] . " " . $ua['version'];
?>
        <div class="col-lg-3 hidden-xs">
            <div class='small-box '>
                <div class='timit'>
                    <strong><i class='fab fa-linux'></i> SERVER INFO</strong><br />
                    <strong><i class='fas fa-server'></i> URL SINKRON : </strong><br />
                    <?= $setting['ip_server'] ?><br />
                    <strong><i class='fas fa-server'></i> TOKEN : </strong>
                    <?= $setting['token_api'] ?><br /><br />

                    <strong><i class='fab fa-chrome'></i> Browser : </strong>
                    <?= $yourbrowser ?><br />
                    <strong><i class='fas fa-ethernet'></i> IP Server : </strong>
                    <?= $_SERVER['SERVER_ADDR'] ?> <strong>
                    Port : </strong> <?= $_SERVER['SERVER_PORT'] ?><br />

                    <strong><i class='fas fa-satellite'></i> IP Remote : </strong>
                    <?= $_SERVER['REMOTE_ADDR'] ?> <strong><br />

                    <strong><i class='fas fa-server'></i> Server Admin : </strong>
                    <?= $_SERVER['SERVER_ADMIN'] ?><br />


                    <br />
                    <strong><i class='fab fa-ubuntu'></i> Webserver : </strong>
                    <?= $_SERVER['SERVER_SOFTWARE']; ?><br />
                    <strong><i class='fas fa-memory'></i> RAM Free : </strong>
                    <?= number_format($memo-$use)  ?> Mb<br />
                    <strong><i class='fas fa-memory'></i> RAM Usage : </strong>
                    <?= number_format($use) ?> Mb<br />
                    <strong><i class='fas fa-hdd'></i> DISK : </strong>
                    <?= number_format($use) ?> Mb<br />
                    <strong><i class='fab fa-php'></i> PHP Version : </strong>
                    <?= phpversion(); ?><br />
                    <strong><i class='fa fa-database'></i> Database : </strong>
                    <?= mysqli_get_server_info($koneksi)?><br />
                    
<!--
                    <br/>
                    <strong><i class='fa fa-building-o'></i> <?= $setting['sekolah'] ?></strong><br />
                    <?= $setting['alamat'] ?><br /><br />
                    <strong><i class='fa fa-phone'></i> <?= $setting['telp'] ?></strong><br />
                    <strong><i class='fa fa-globe'></i> <?= $setting['web'] ?></strong><br />
                    <strong><i class='fa fa-at'></i> <?= $setting['email'] ?></strong><br />
                    <br />
                    <img src="../dist/img/tjktxyz.png" content="width=device-width, initial-scale=1.0"; style="width:100%;height:100%; padding: 5px;">
-->
                </div><!-- /.box-body -->
                <div class="icon">
                    <i class="fa fa-server"></i>
                </div>
            </div><!-- /.box -->
        </div>

        

        <!--<div class="col-md-3 hidden-xs">
            <div class="box box-solid">
          
                <div class="box-body">
                    <div id='infoweb'></div>
                    <ul class="list-group">
                        <li class="list-group-item"><img src="../dist/img/support.png" width="45" alt="">
                            <a href="https://cbtcandy.com" target="_blank" class="btn btn-success">
                                <i class="fab fa-wordpress"></i> Website
                            </a></li>
                        <li class="list-group-item"><img src="../dist/img/support.png" width="45" alt="">
                            <a href="https://t.me/+H3JNAkTkvx4wNTc1" target="_blank" class="btn btn-primary">
                                <i class="fab fa-telegram-plane"></i> Telegram
                            </a></li>
                        <li class="list-group-item"><img src="../dist/img/support.png" width="45" alt="">
                            <a href="https://www.youtube.com/@tjkt.smkyasmida" target="_blank" class="btn btn-danger">
                                <i class="fab fa-youtube"></i> Youtube
                            </a>
                        </li>

                        <li class="list-group-item"><img src="../dist/img/support.png" width="45" alt="">
                            <a href="https://www.youtube.com/@tjkt.smkyasmida" target="_blank" class="btn btn-warning">
                                <i class="fab fa-instagram"></i> Instagram
                            </a>
                        </li>
                        <li class="list-group-item"><img src="../dist/img/support.png" width="45" alt="">
                            <a href="https://www.youtube.com/@tjkt.smkyasmida" target="_blank" class="btn btn-info">
                                <i class="fab fa-facebook"></i> Facebook
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>-->



        



        <div class='animated flipInX col-md-8'>
            <div class="row">
                
                <div class="col-md-12">
                    <div class='box box-solid direct-chat direct-chat-warning'>
                        <div class='box-header with-border'>
                            <h3 class='box-title'><i class='fas fa-bullhorn fa-fw'></i>
                                Pengumuman
                            </h3>
                            <div class='box-tools pull-right'>

                                <a href='?pg=<?= $pg ?>&ac=clearpengumuman' class='btn btn-default' title='Bersihkan Pengumuman'><i class='fa fa-trash'></i></a>
                            </div>
                        </div>
                        <div class='box-body'>
                            <div id='pengumuman'>
                                <p class='text-center'>
                                    <br /><i class='fa fa-spin fa-circle-o-notch'></i> Loading....
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class='animated flipInX col-md-4'>
            <div class='box box-solid direct-chat direct-chat-warning'>
                <div class='box-header with-border'>
                    <h3 class='box-title'><i class='fa fa-history'></i> Log Aktifitas</h3>
                    <div class='box-tools pull-right'>
                        <a href='?pg=<?= $pg ?>&ac=clearlog' class='btn btn-default' title='Bersihkan Log'><i class='fa fa-trash'></i></a>
                    </div>
                </div>
                <div class='box-body'>
                    <div id='log-list'>
                        <p class='text-center'>
                            <br /><i class='fa fa-spin fa-circle-o-notch'></i> Loading....
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php endif ?>
<?php
if ($ac == 'clearlog') {
    mysqli_query($koneksi, "TRUNCATE log");
    jump('?');
}
if ($ac == 'clearpengumuman') {
    mysqli_query($koneksi, "TRUNCATE pengumuman");
    jump('?');
}
?>
<?php if ($pengawas['level'] == 'guru' or $pengawas['level'] == 'pengawas') : ?>
    <div class='row'>
        <div class='col-md-8'>
            <div class='box box-solid direct-chat direct-chat-warning'>
                <div class='box-header with-border'>
                    <h3 class='box-title'><i class='fa fa-bullhorn'></i> Pengumuman
                    </h3>
                    <div class='box-tools pull-right'></div>
                </div><!-- /.box-header -->
                <div class='box-body'>
                    <div id='pengumuman'>
                        <p class='text-center'>
                            <br /><i class='fa fa-spin fa-circle-o-notch'></i> Loading....
                        </p>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class='col-md-4'>
            <div class='box box-solid '>
                <div class='box-body'>
                    <strong><i class='fa fa-building-o'></i> <?= $setting['sekolah'] ?></strong><br />
                    <?= $setting['alamat'] ?><br /><br />
                    <strong><i class='fa fa-phone'></i> Telepon</strong><br />
                    <?= $setting['telp'] ?><br /><br />
                    <strong><i class='fa fa-fax'></i> Fax</strong><br />
                    <?= $setting['fax'] ?><br /><br />
                    <strong><i class='fa fa-globe'></i> Website</strong><br />
                    <?= $setting['web'] ?><br /><br />
                    <strong><i class='fa fa-at'></i> E-mail</strong><br />
                    <?= $setting['email'] ?><br />
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
<?php endif ?>