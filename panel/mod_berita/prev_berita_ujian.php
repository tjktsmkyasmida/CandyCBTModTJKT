<?php if ($pengawas['level'] == 'admin') : ?>
    <?php
    $idujian = dekripsi($_GET['id']);
    $sqlx = mysqli_query($koneksi, "SELECT a.*,b.* FROM ujian a,mapel b  where a.kode_nama=b.kode and  id_ujian='$idujian'");
    $ujian = mysqli_fetch_array($sqlx);
    $kodeujian = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jenis WHERE id_jenis='$ujian[kode_ujian]'"));
    $guru = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE id_pengawas='$ujian[idguru]'"));
    $hari = buat_tanggal('D', $ujian['tgl_ujian']);
    $tanggal = buat_tanggal('d', $ujian['tgl_ujian']);
    // $bulan = buat_tanggal('F', $ujian['tgl_ujian']);
    $bulan = bulan_indo($ujian['tgl_ujian']);
    $tahun = buat_tanggal('Y', $ujian['tgl_ujian']);
    if (date('m') >= 7 and date('m') <= 12) {
        $ajaran = date('Y') . "/" . (date('Y') + 1);
    } elseif (date('m') >= 1 and date('m') <= 6) {
        $ajaran = (date('Y') - 1) . "/" . date('Y');
    }
    ?>
    <div class='row'>
        <div class='col-md-12'>
            <div class='box box-solid'>
                <div class='box-header'>
                    <h3 class='box-title'>Preview Berita Acara</h3>
                    <div class='box-tools pull-right '>
                        <button onclick="frames['printberita'].print()" class='btn btn-sm btn-flat btn-success'><i class='fa fa-print'></i> Print</button>
                        <iframe name='printberita' src='mod_berita/print_berita_ujian.php?id=<?= enkripsi($idujian) ?>' style='display:none'></iframe>
                    </div>
                </div>
                <div class='box-body' style='background:#c3c3c3;  height:1275px;'>
                    <div class='table-responsive'>
                        <div style='background:#fff; width:80%; margin:0 auto; padding:35px; height:90%;'>
                            <!-- <table border='0' width='100%'> -->
                            <table style="width:100%">
                                <tr>
                                    <td rowspan='4' width='120' align='center'>
                                        <img src='../foto/tut.jpg' width='80'>
                                    </td>
                                    <td colspan='2' align='center'>
                                        <font size='+1'>
                                            <b>BERITA ACARA PELAKSANAAN</b>
                                        </font>
                                    </td>
                                    <td rowspan='7' width='120' align='center'><img src='../<?= $setting['logo'] ?>' width='65'></td>
                                </tr>
                                <tr>
                                    <td colspan='2' align='center'>
                                        <font size='+1'><b> <?= strtoupper($kodeujian['nama']) ?></b></font>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='2' align='center'>
                                        <font size='+1'><b>TAHUN PELAJARAN <?= $ajaran ?></b></font>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <table border='0' width='95%' align='center'>
                                <tr height='30'>
                                    <td height='30' colspan='4' style='text-align: justify;'>Pada hari ini <b> <?= $hari ?> </b> tanggal <b><?= $tanggal ?></b> bulan <b><?= $bulan ?></b> tahun <b><?= $tahun ?></b>, di <?= $setting['sekolah'] ?> telah diselenggarakan "<?= ucwords(strtolower($kodeujian['nama'])) ?>" untuk Mata Pelajaran <b><?= $ujian['nama'] ?></b> dari tanggal <b><?= $ujian['tgl_ujian'] ?></b> sampai dengan <b><?= $ujian['tgl_selesai'] ?></b></td>
                                </tr>
                            </table>
                            <table border='0' width='95%' align='center'>
                                <tr height='30'>
                                    <td height='30' width='5%'>1.</td>
                                    <td height='30' width='30%'>Kode Sekolah</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $setting['kode_sekolah'] ?></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='10px'></td>
                                    <td height='30'>Sekolah/Madrasah</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $setting['sekolah'] ?></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='30%'>Sesi</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $ujian['sesi'] ?></td>
                                </tr>
                                <!-- <tr height='30'>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='30%'>Ruang</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $ujian['ruang'] ?></td>
                                </tr> -->
                                <?php $ikut = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM nilai where id_ujian='$idujian'")) ?>
                                <?php
                                $kelas = implode("','", unserialize($ujian['kelas']));
                                if ($kelas == "semua") {
                                    if ($ujian['level'] == 'semua') {
                                        $peserta = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa "));
                                    } else {
                                        $peserta = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa where level='$qujian[level]'"));
                                    }
                                } else {
                                    $peserta = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa where id_kelas IN ('" . $kelas . "')"));
                                }
								
                                ?>
                                <tr height='30'>
                                    <td height='30' width='10px'></td>
                                    <td height='30'>Jumlah Peserta Seharusnya</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $peserta ?></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='30%'>Jumlah Hadir (Ikut Ujian)</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $ikut ?></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='10px'></td>
                                    <td height='30'>Jumlah Tidak Hadir</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'><?= $peserta - $ikut ?></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='10px'></td>
                                    <td height='30'>Kelas</td>
                                    <td height='30' width='60%' style='border-bottom:thin solid #000000'>
                                        <?php
                                        $dataArray = unserialize($ujian['kelas']);
                                        if ($dataArray) {
                                            foreach ($dataArray as $key => $value) {
                                                echo "<small class='label label-success'>$value </small>&nbsp;";
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='10px'></td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' width='5%'>2.</td>
                                    <td colspan='2' height='30' width='30%'>
                                        Catatan selama pelaksanaan ujian "<?= ucwords(strtolower($kodeujian['nama'])) ?>"
                                    </td>
                                </tr>
                                <tr height='120px'>
                                    <td height='30' width='5%'></td>
                                    <td colspan='2' style='border:solid 1px black'> &nbsp; TERTIB DAN LANCAR 😁</td>
                                </tr>
                                <tr height='30'>
                                    <td height='30' colspan='2' width='5%'>Yang membuat berita acara: </td>
                                </tr>
                            </table>
                            <table border='0' width='80%' style='margin-left:50px'>
                                <tr>
                                    <td colspan='4'></td>
                                    <td height='30' width='30%'>TTD</td>
                                    <!-- <tr>
                                    <td width='10%'>1. </td>
                                    <td width='20%'>Proktor</td>
                                    <td width='30%' style='border-bottom:thin solid #000000'><?= $ujian['nama_proktor'] ?></td>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='35%'></td>
                                </tr> -->
                                    <!-- <tr>
                                    <td width='10%'> </td>
                                    <td width='20%'>NIP. </td>
                                    <td width='30%' style='border-bottom:thin solid #000000'><?= $ujian['nip_proktor'] ?></td>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='35%' style='border-bottom:thin solid #000000'> 1. </td>
                                </tr>
                                <tr>
                                    <td colspan='4'></td>
                                </tr> -->
                                <tr>
                                    <td width='10%'>1. </td>
                                    <td width='20%'>Guru Pengampu</td>
                                    <td width='30%' style='border-bottom:thin solid #000000'><?= $guru['nama'] ?></td>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='35%'></td>
                                </tr>
                                <tr>
                                    <td width='10%'> </td>
                                    <td width='20%'>NIP. </td>
                                    <td width='30%' style='border-bottom:thin solid #000000'><?= $guru['nip'] ?></td>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='35%' style='border-bottom:thin solid #000000'> 1. </td>
                                </tr>
                                <tr>
                                    <td colspan='4'></td>
                                </tr>
                                <tr>
                                    <td width='10%'>2. </td>
                                    <td width='20%'>Kepala Sekolah</td>
                                    <td width='30%' style='border-bottom:thin solid #000000'><?= $setting['kepsek'] ?></td>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='35%'></td>
                                </tr>
                                <tr>
                                    <td width='10%'> </td>
                                    <td width='20%'>NIP. </td>
                                    <td width='30%' style='border-bottom:thin solid #000000'><?= $setting['nip'] ?></td>
                                    <td height='30' width='5%'></td>
                                    <td height='30' width='35%' style='border-bottom:thin solid #000000'> 2. </td>
                                </tr>
                            </table>
                            <br><br><br><br><br>
                            <table width='100%' height='30'>
                                <tbody>
                                    <tr>
                                        <td width='25px' style='border:1px solid black'></td>
                                        <td width='5px'>&nbsp;</td>
                                        <td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'><?= $setting['sekolah'] ?></td>
                                        <td width='5px'>&nbsp;</td>
                                        <td width='25px' style='border:1px solid black'></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>