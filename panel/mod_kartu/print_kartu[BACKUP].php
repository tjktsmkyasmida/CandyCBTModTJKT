<style type="text/css">
    .ttd {
        position: absolute;
        z-index: -1;
    }
</style>
<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:index.php') : null;
$id_kelas = @$_GET['id_kelas'];
if (date('m') >= 7 and date('m') <= 12) {
    $ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 and date('m') <= 6) {
    $ajaran = (date('Y') - 1) . "/" . date('Y');
}
$kelas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$id_kelas'"));
?>
<style>
    * {
        font-size: x-small;
    }

    .box {
        border: 6px solid #000000;
        width: 100%;
        height: 180px;
    }

    .ukuran {
        font-size: 14px;
    }

    .ukuran1 {
        font-size: 22px;
    }

    .ukuran2 {
        font-size: 12px;
    }

    .ukuran3 {
        font-size: 10px;
    }

    .ukuran4 {
        font-size: 8px;
    }

    .user {
        font-size: 15px;
    }
</style>

<table width='100%' align='center' cellpadding="14" ;>
    <tr>
        <?php $siswaQ = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$id_kelas' ORDER BY nama ASC"); ?>
        <?php while ($siswa = mysqli_fetch_array($siswaQ)) : ?>
            <?php
            $nopeserta = $siswa['no_peserta'];
            $no++;
            ?>
            <td width='50%'>
                <div style='width:12cm;border:1px solid #666;'>
                    <table style="text-align:center; width:100%">
                        <tr>
                            <td style="text-align:left; padding-left:6px; padding-top:6px; vertical-align:top">

                                <img src='../../foto/logo_tut.svg' height='60px'>
                            </td>
                            <td style="text-align:center">
                                <!-- <b>
									KARTU PESERTA UJIAN<br>
									<?= strtoupper($setting['nama_ujian']) ?><BR>
									TAHUN PELAJARAN <?= $ajaran ?>
								</b> -->
                                <b class="ukuran">
                                    <b class="ukuran2"><?= strtoupper($setting['header_kartu']) ?></b><BR>
                                    <a class="ukuran2">UJIAN SEKOLAH BERBASIS KOMPUTER</a><BR>
                                    <b class="ukuran1"><?= strtoupper($setting['sekolah']) ?></b><BR>
                                    <a class="ukuran2">TAHUN PELAJARAN <?= $ajaran ?></a>
                                </b>
                            </td>
                            <td style="text-align:right; padding-right:6px; padding-top:6px; vertical-align:top">
                                <img src="../../<?= $setting['logo'] ?>" height='60px' />
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <table style="text-align:left; width:100%">
                        <tr>
                            <td style="text-align:left; padding-left: 6px; padding-right: 0px; vertical-align:top; width:100px" rowspan="8">
                                <?php
                                if ($siswa['foto'] <> '') {
                                    if (!file_exists("../../foto/fotosiswa/$siswa[foto]")) {
                                        echo "<img src='$homeurl/dist/img/avatar_default.png' class='img'  style='max-width:100px' alt='+'>";
                                    } else {
                                        echo "<img src='$homeurl/foto/fotosiswa/$siswa[foto]' class='img'  style='max-width:100px' >";
                                    }
                                } else {
                                    echo "<img src='$homeurl/dist/img/foto.svg' class='img'  style='max-width:100px' alt='+'>";
                                }

                                ?>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <i>*Berdoa & Berusaha !</i><br>
                                <i class="ukuran4">Baca Panduan CBT :</i><br>
                                <b><i class="ukuran2">https://s.id/TimITSMK</i></b>
                            </td>
                        </tr>
                        <tr>
                            <td class="ukuran" valign='top'>No Peserta</td>
                            <td class="ukuran" valign='top'>: <?= $siswa['no_peserta'] ?></td>
                        </tr>
                        <tr>
                            <td class="ukuran" valign='top'>Nama</td>
                            <td class="ukuran" valign='top'>: <b class="user"><?= $siswa['nama'] ?></b></td>
                        </tr>
                        <tr>
                            <td class="ukuran" valign='top'>Kelas</td>
                            <td class="ukuran" valign='top'>: <?= $kelas['nama'] ?></td>
                        </tr>
                        <tr>
                            <td class="ukuran" valign='top'>Username</td>
                            <td class="ukuran" valign='top'>: <b class="user"><?= $siswa['username'] ?></b></td>
                        </tr>
                        <tr>
                            <td class="ukuran" valign='top'>Password</td>
                            <td class="ukuran" valign='top'>: <b class="user"><?= $siswa['password'] ?></b></td>
                        </tr>
                        <tr>
                            <td class="ukuran" valign='top'>Website</td>
                            <td class="ukuran" valign='top'>: https://us.smkyasmida.sch.id
                                <hr>
                                <div style="padding-top: 2px; padding-left: 2px;" class="ttd">
                                    <img src='<?php echo '../../dist/img/ttd.png' . '?date=' . time(); ?> ?>' height='80px'>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td valign='top'></td>
                            <td class="ukuran2" valign='top' align='center'>
                                Kepala Sekolah<br><br>
                                <br>
                                <br>
                                <u><b class="ukuran2">HERI SUSANTO, M.Pd.</b></u><br>
                                <b>NIK. 19860714 2009 0094.</b>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php if (($no % 8) == 0) : ?>
                    <div style='page-break-before:always;'></div>
                <?php endif; ?>
            </td>
            <?php if (($no % 2) == 0) : ?>
    </tr>
    <tr>
    <?php endif; ?>
<?php endwhile; ?>
    </tr>
</table>