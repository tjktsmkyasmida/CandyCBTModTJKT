<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
require("../../config/dis.php");
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas == 0) ? header('location:login.php') : null;
echo "<style> .str{ mso-number-format:\@; } </style>";
$id_ujian = $_GET['m'];

$pengawas = fetch($koneksi, 'pengawas', array('id_pengawas' => $id_pengawas));
$ujian = fetch($koneksi, 'ujian', array('id_ujian' => $id_ujian));
$id_ujian = $ujian['id_ujian'];
if (date('m') >= 7 and date('m') <= 12) {
	$ajaran = date('Y') . "/" . (date('Y') + 1);
} elseif (date('m') >= 1 and date('m') <= 6) {
	$ajaran = (date('Y') - 1) . "/" . date('Y');
}
$file = "NILAI_" . $ujian['nama'];
$file = str_replace(" ", "-", $file);
$file = str_replace(":", "", $file);
header("Content-type: application/octet-stream");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: attachment; filename=" . $file . ".xls");
?>

Kode ujian: <?= $ujian['nama'] ?><br />
Jumlah Soal: <?= $ujian['jml_soal'] ?> PG / <?= $ujian['jml_esai'] ?> ESAI<br />

<table border='1'>
	<tr>
		<td rowspan='2'>No.</td>
		<td rowspan='2'>No. Peserta</td>
		<td rowspan='2'>Nama</td>
		<td rowspan='2'>Kelas</td>
		<td rowspan='2'>Lama Ujian</td>
		<td rowspan='2'>Benar</td>
		<td rowspan='2'>Salah</td>
		<td rowspan='2'>Nilai PG</td>
		<td rowspan='2'>Nilai Essai</td>
		<td rowspan='2'>Nilai / Skor</td>
		<td colspan='<?= $ujian['jml_soal'] ?>'>Jawaban</td>
		<td colspan='<?= $ujian['jml_esai'] ?>'>Jawaban Esai</td>

	</tr>
	<tr><?php
		for ($num = 1; $num <= $ujian['jml_soal']; $num++) {
			$soal = fetch($koneksi, 'soal', array('id_mapel' => $ujian['id_mapel'], 'nomor' => $num));
		?>
			<td><?= $num . $soal['jawaban'] ?></td>
		<?php } ?>
		<?php
		for ($num = 1; $num <= $ujian['jml_esai']; $num++) {
			$soal = fetch($koneksi, 'soal', array('id_mapel' => $ujian['id_mapel'], 'nomor' => $num));
		?>
			<td><?= $num ?></td>
		<?php } ?>

	</tr>

	<?php

	$kelas = implode("','", unserialize($ujian['kelas']));
	if ($kelas == 'semua') {
		if ($ujian['level'] == 'semua') {
			$siswaQ = mysqli_query($koneksi, "SELECT * FROM siswa  ORDER BY id_kelas ASC");
		} else {
			$siswaQ = mysqli_query($koneksi, "SELECT * FROM siswa where level='$ujian[level]'  ORDER BY id_kelas ASC");
		}
	} else {
		$siswaQ = mysqli_query($koneksi, "SELECT * FROM siswa where id_kelas IN ('" . $kelas . "')  ORDER BY id_kelas ASC");
	}

	$betul = array();
	$salah = array();
	while ($siswa = mysqli_fetch_array($siswaQ)) {
		$no++;
		$benar = $salah = 0;
		$skor = $lama = '-';
		$selisih = 0;

		$nilai = fetch($koneksi, 'nilai', array('id_ujian' => $id_ujian, 'id_siswa' => $siswa['id_siswa']));
		if ($nilai['ujian_mulai'] <> '' and $nilai['ujian_selesai'] <> '') {
			$selisih = strtotime($nilai['ujian_selesai']) - strtotime($nilai['ujian_mulai']);
		}
	?>
		<tr>
			<td><?= $no ?></td>
			<td><?= $siswa['no_peserta'] ?></td>
			<td><?= $siswa['nama'] ?></td>
			<td><?= $siswa['id_kelas'] ?></td>
			<td><?= lamaujian($selisih) ?></td>
			<td><?= $nilai['jml_benar'] ?></td>
			<td><?= $nilai['jml_salah'] ?></td>
			<td><?= round($nilai['skor'], 2) ?></td>
			<td><?= round($nilai['nilai_esai'], 2) ?></td>
			<td><?= round($nilai['total'], 2) ?></td>
			<?php
			if ($nilai) {
				$jawaban = unserialize($nilai['jawaban']);
				foreach ($jawaban as $key => $value) {
					$soal = mysqli_fetch_array(mysqli_query($koneksi, "select * from soal where id_soal='$key' order by nomor ASC"));
					$nomor = $soal['nomor'];
					if ($soal) {
						if ($value == $soal['jawaban']) { ?>
							<td style='background:#00FF00;'><?= $value ?></td>
						<?php } else { ?>
							<?php if ($value == 'X') { ?>
								<td style='background:#bbd1de;'><?= $value ?></td>
							<?php } else { ?>
								<td style='background:#FF0000;'><?= $value ?></td>
							<?php } ?>
						<?php }
					} else { ?>
						<td>-</td>
				<?php }
				}

				?>
				<?php

				$jawaban = unserialize($nilai['jawaban_esai']);
				foreach ($jawaban as $key => $value) {

					$soal = mysqli_fetch_array(mysqli_query($koneksi, "select * from soal where id_soal='$key' order by nomor ASC"));
					$nomor = $soal['nomor'];
					if ($soal) {
						echo "<td>$value</td>";
					} else { ?>
						<td>Tidak diisi</td>
			<?php }
				}
			}
			?>
		</tr>

	<?php } ?>

</table>

<!-- <br>
<table border='1'>
	<tr>
		<th>No.</th>
		<th>Soal</th>
		<th>Menjawab Benar</th>
		<th>Menjawab Salah</th>
		<th>Kategori</th>
	</tr>
	<?php

	$soalq = mysqli_query($koneksi, "SELECT * FROM soal a join ujian b ON a.id_ujian=b.id_ujian  ORDER BY nomor ASC");

	while ($soal = mysqli_fetch_array($soalq)) {
		$no++;
		$nomor = $soal['nomor'];
	?>
		<tr>
			<td><?= $soal['nomor'] ?></td>
			<td><?= $soal['soal'] ?></td>
			
		</tr>

	<?php } ?>

</table> -->