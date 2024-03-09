<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:index.php') : null;
//$idserver = $setting['kode_sekolah'];
echo "<link rel='stylesheet' href='$homeurl/dist/css/cetak.min.css'>";
$idujian = dekripsi($_GET['id']);
$qujian = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM ujian where id_ujian='$idujian'"));
$ikut = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM nilai where id_ujian='$idujian'"));
$kelas = implode("','", unserialize($qujian['kelas']));
if ($kelas == "semua") {
    if ($qujian['level'] == 'semua') {
        $peserta = mysqli_query($koneksi, "SELECT * FROM siswa ");
    } else {
        $peserta = mysqli_query($koneksi, "SELECT * FROM siswa where level='$qujian[level]'");
    }
} else {
    $peserta = mysqli_query($koneksi, "SELECT * FROM siswa where id_kelas IN ('" . $kelas . "')");
}

$lebarusername = '10%';
$lebarnopes = '17%';
$mapelx = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$qujian[id_mapel]'"));
$namamapel =    mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mata_pelajaran WHERE kode_mapel='$mapelx[nama]'"));
if (date('m') >= 7 and date('m') <= 12) {
    $ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 and date('m') <= 6) {
    $ajaran = (date('Y') - 1) . "/" . date('Y');
}


$jumlahData = mysqli_num_rows($peserta);
if ($jumlahData == 0) {
    echo "<span style='font-size:30; color:red'>Tidak ada Peserta Ujian dengan mapel" . $mapelx["nama"] . ", pada: <br>= sesi: " . $sesi . ", <br>= ruang: " . $ruang . ", <br>= kelas: " . $kelas . "</span>";
    echo mysqli_error($koneksi);
    die;
}
$jumlahn = '25';
$n = ceil($jumlahData / $jumlahn);

$nomer = 1;

$date = date_create($qujian['tgl_ujian']);
?>

<?php for ($i = 1; $i <= $n; $i++) : ?>
    <?php
    $mulai = $i - 1;
    $batas = ($mulai * $jumlahn);
    $startawal = $batas;
    $batasakhir = $batas + $jumlahn;
    ?>

    <?php if ($i == $n) : ?>
        <div class='page'>
            <table width='100%'>
                <tr>
                    <td width='100'><img src='../../foto/logo_tut.svg' width='80'></td>
                    <td style="text-align:center">
                        <strong class='f12'>
                            ABSENSI PESERTA <BR>
                            <?= strtoupper($setting['nama_ujian']) ?><BR>
                            TAHUN PELAJARAN <?= $ajaran ?>
                        </strong>
                    </td>
                    <td width='100'><img src="<?= $homeurl . '/' . $setting['logo'] ?>" height='75'></td>
                </tr>
            </table>
            <table class='detail'>
                <tr>
                    <td>SEKOLAH/MADRASAH</td>
                    <td>:</td>
                    <td><span style='width:350px;'>&nbsp;<?= $setting['sekolah'] ?></span></td>
                    <td>ID SERVER</td>
                    <td>:</td>
                    <td><span style='width:150px;'>&nbsp;<?= $setting['kode_sekolah'] ?></span></td>
                </tr>
                <tr>
                    <td>HARI</td>
                    <td>:</td>
                    <td>
                        <span style='width:90px;'>&nbsp;<?= strtoupper(buat_tanggal('D', $qujian['tgl_ujian'])) ?></span>
                        TANGGAL : <span style='width:190px;'>&nbsp;<?= strtoupper(buat_tanggal('d M Y', $qujian['tgl_ujian'])) ?></span>
                    </td>
                    <td>SESI</td>
                    <td>:</td>
                    <td><span style='width:150px;'>&nbsp;<?= $qujian['sesi'] ?></span></td>
                </tr>
                <tr>
                    <td>MATA PELAJARAN</td>
                    <td>:</td>
                    <td><span style='width:350px;'>&nbsp;<?= $namamapel['nama_mapel'] ?></span></td>
                    <td>PUKUL</td>
                    <td>:</td>
                    <td><span style='width:150px;'>&nbsp;<?= buat_tanggal('H:i', $qujian['tgl_ujian']) . " - " . buat_tanggal('H:i', $qujian['tgl_selesai']) ?></span></td>
                </tr>

            </table>
            <table class='it-grid it-cetak' width='100%'>
                <tr height=40px>
                    <th>No.</th>
                    <th>Username</th>
                    <th>No Peserta</th>
                    <th>Nama Peserta<BR> </th>
                    <!-- <th>Tanda Tangan</th> -->
                    <th>Ket</th>
                </tr>

                <?php
                if ($kelas == "semua") {
                    if ($qujian['level'] == 'semua') {
                        $peserta = mysqli_query($koneksi, "SELECT * FROM siswa limit $batas,$jumlahn ");
                    } else {
                        $peserta = mysqli_query($koneksi, "SELECT * FROM siswa where level='$qujian[level]' limit $batas,$jumlahn");
                    }
                } else {
                    $peserta = mysqli_query($koneksi, "SELECT * FROM siswa where id_kelas IN ('" . $kelas . "') limit $batas,$jumlahn");
                }
                while ($f = mysqli_fetch_array($peserta)) : ?>
                    <?php $cekikut = mysqli_num_rows(mysqli_query($koneksi, "Select * from nilai where id_ujian='$idujian' and id_siswa='$f[id_siswa]'"));
                    if ($cekikut <> 0) {
                        $keterangan = "Hadir Ujian";
                    } else {
                        $keterangan = "Belum Ujian";
                    }
                    ?>
                    <?php if ($nomer % 2 == 0) : ?>
                        <tr>
                            <td style="text-align:center;width:15">&nbsp;<?= $nomer ?>.</td>
                            <td width='<?= $lebarusername ?>' style="text-align:center">&nbsp;<?= $f['username'] ?></td>
                            <td width='<?= $lebarnopes ?>' style="text-align:center">&nbsp;<?= $f['no_peserta'] ?></td>
                            <td width='*'>&nbsp;<?= $f['nama'] ?></td>
                            <!-- <td width='150'><span style='float:right;width:80px;'>&nbsp;<?= $nomer ?>.</span></td> -->
                            <td width='15%'><?= $keterangan ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td style="text-align:center;width:15">&nbsp;<?= $nomer ?>.</td>
                            <td width='<?= $lebarusername ?>' style="text-align:center">&nbsp;<?= $f['username'] ?></td>
                            <td width='<?= $lebarnopes ?>' style="text-align:center">&nbsp;<?= $f['no_peserta'] ?></td>
                            <td width='*'>&nbsp;<?= $f['nama'] ?></td>
                            <!-- <td width='150'><span style='float:left;width:80px;'>&nbsp;<?= $nomer ?>.</span></td> -->
                            <td width='15%'><?= $keterangan ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php
                    $nomer++;
                    $jlhhdr = ($nomer - 1);
                    ?>
                <?php endwhile; ?>
            </table>
            <table>
                <tr>
                    <td colspan='2'><strong><i>Keterangan : </i></strong></td>
                </tr>
                <tr>
                    <td>1. Dibuat rangkap 3 (tiga), masing-masing untuk sekolah, Cabang Dinas dan Provinsi.</td>
                </tr>
                <tr>
                    <td>2. Pengawas ruang menyilang Nama Peserta yang tidak hadir.</td>
                </tr>
            </table>
            <table width='100%'>
                <tr>
                    <td>
                        <table style='border:1px solid black'>
                            <tr>
                                <td>Jumlah Peserta yang Seharusnya Hadir</td>
                                <td>:</td>
                                <td> <?= $jlhhdr ?> orang</td>
                            </tr>
                            <tr>
                                <td>Jumlah Peserta yang Tidak Hadir</td>
                                <td>:</td>
                                <td><?= $jlhhdr - $ikut ?> orang</td>
                            </tr>
                            <tr style='border-top:1px solid black'>
                                <td>Jumlah Peserta Hadir</td>
                                <td>:</td>
                                <td><?= $ikut ?> orang</td>
                            </tr>
                        </table>
                    </td>
                    <td style="text-align:center; width:200">
                        Proktor<BR><BR><BR><BR><BR>(<nip></nip>)<BR><BR>&nbsp;&nbsp;&nbsp;&nbsp;NIP. <nip></nip>
                    </td>
                    <td style="text-align:center; width:175">
                        Pengawas<BR><BR><BR><BR><BR>(<nip></nip>)<BR><BR>&nbsp;&nbsp;&nbsp;&nbsp;NIP. <nip></nip>
                    </td>
                </tr>
            </table>
            <div class='footer'>
                <table width='100%' height='30'>
                    <tr>
                        <td width='25px' style='border:1px solid black'></td>
                        <td width='5px'>&nbsp;</td>
                        <td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'><?= strtoupper($setting['nama_ujian']) . " " . $setting['sekolah'] ?></td>
                        <td width='5px'>&nbsp;</td>
                        <td width='25px' style='border:1px solid black'></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php break; ?>
    <?php endif; ?>
    <div class='page'>
        <table width='100%'>
            <tr>
                <td width='100'><img src='../../foto/tut.jpg' width='80'></td>
                <td style="text-align:center">
                    <strong class='f12'>
                        ABSENSI PESERTA <BR>
                        <?= strtoupper($setting['nama_ujian']) ?><BR>
                        TAHUN PELAJARAN <?= $ajaran ?>
                    </strong>
                </td>
                <td width='100'><img src="<?= $homeurl . '/' . $setting['logo'] ?>" height='75'></td>
            </tr>
        </table>
        <table class='detail'>
            <tr>
                <td>SEKOLAH/MADRASAH</td>
                <td>:</td>
                <td><span style='width:350px;'>&nbsp;<?= $setting['sekolah'] ?></span></td>
                <td>ID SERVER</td>
                <td>:</td>
                <td><span style='width:150px;'>&nbsp;<?= $setting['kode_sekolah'] ?></span></td>
            </tr>
            <tr>
                <td>HARI</td>
                <td>:</td>
                <td>
                    <span style='width:90px;'>&nbsp;<?= strtoupper(buat_tanggal('D', $qujian['tgl_ujian'])) ?></span>
                    TANGGAL : <span style='width:190px;'>&nbsp;<?= strtoupper(buat_tanggal('d M Y', $qujian['tgl_ujian'])) ?></span>
                </td>
                <td>SESI</td>
                <td>:</td>
                <td><span style='width:150px;'>&nbsp;<?= $qujian['sesi'] ?></span></td>
            </tr>
            <tr>
                <td>MATA PELAJARAN</td>
                <td>:</td>
                <td><span style='width:350px;'>&nbsp;<?= $namamapel['nama_mapel'] ?></span></td>
                <td>PUKUL</td>
                <td>:</td>
                <td><span style='width:150px;'>&nbsp;<?= buat_tanggal('H:i', $qujian['tgl_ujian']) . " - " . buat_tanggal('H:i', $qujian['tgl_selesai']) ?></span></td>
            </tr>

        </table>

        <table class='it-grid it-cetak' width='100%'>
            <tr height=40px>
                <th>No.</th>
                <th>Username</th>
                <th>No Peserta</th>
                <th>Nama Peserta<BR> </th>
                <!-- <th>Tanda Tangan</th> -->
                <th>Ket</th>
            </tr>
            <?php
            $s = $i - 1;
            if ($kelas == "semua") {
                if ($qujian['level'] == 'semua') {
                    $peserta = mysqli_query($koneksi, "SELECT * FROM siswa limit $batas,$jumlahn ");
                } else {
                    $peserta = mysqli_query($koneksi, "SELECT * FROM siswa where level='$qujian[level]' limit $batas,$jumlahn");
                }
            } else {
                $peserta = mysqli_query($koneksi, "SELECT * FROM siswa where id_kelas IN ('" . $kelas . "') limit $batas,$jumlahn");
            }
            ?>
            <?php while ($f = mysqli_fetch_array($peserta)) : ?>
                <?php $cekikut = mysqli_num_rows(mysqli_query($koneksi, "Select * from nilai where id_ujian='$idujian' and id_siswa='$f[id_siswa]'"));
                if ($cekikut <> 0) {
                    $keterangan = "Hadir Ujian";
                } else {
                    $keterangan = "Belum Ujian";
                }
                ?>
                <?php if ($nomer % 2 == 0) : ?>
                    <tr>
                        <td style="text-align:center;width:15">&nbsp;<?= $nomer ?>.</td>
                        <td width='<?= $lebarusername ?>' style="text-align:center">&nbsp;<?= $f['username'] ?></td>
                        <td width='<?= $lebarnopes ?>' style="text-align:center">&nbsp;<?= $f['no_peserta'] ?></td>
                        <td width='*'>&nbsp;<?= $f['nama'] ?></td>
                        <!-- <td width='150'><span style='float:right;width:80px;'>&nbsp;<?= $nomer ?>.</span></td> -->
                        <td width='15%'><?= $keterangan ?></td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td style="text-align:center;width:15">&nbsp;<?= $nomer ?>.</td>
                        <td width='<?= $lebarusername ?>' style="text-align:center">&nbsp;<?= $f['username'] ?></td>
                        <td width='<?= $lebarnopes ?>' style="text-align:center">&nbsp;<?= $f['no_peserta'] ?></td>
                        <td width='*'>&nbsp;<?= $f['nama'] ?></td>
                        <!-- <td width='150'><span style='float:left;width:80px;'>&nbsp;<?= $nomer ?>.</span></td> -->
                        <td width='15%'><?= $keterangan ?></td>
                    </tr>
                <?php endif; ?>
                <?php
                $nomer++;
                $jlhhdr = ($nomer - 1);
                ?>
            <?php endwhile; ?>
        </table>

        <div class='footer'>
            <table width='100%' height='30'>
                <tr>
                    <td width='25px' style='border:1px solid black'></td>
                    <td width='5px'>&nbsp;</td>
                    <td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'><?= strtoupper($setting['nama_ujian']) . " " . $setting['sekolah'] ?></td>
                    <td width='5px'>&nbsp;</td>
                    <td width='25px' style='border:1px solid black'></td>
                </tr>
            </table>
        </div>
    </div>
<?php endfor; ?>