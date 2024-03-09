<?php
include "../../config/config.default.php";
include "../../config/config.function.php";
cek_session_guru();
$pengawas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas  WHERE id_pengawas='$_SESSION[id_pengawas]'"));

?>
<table style="font-size: 11px" id='example1' class='table table-bordered table-striped'>
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
            <?php $nilai = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM nilai where id_siswa='$data[id_siswa]' and id_mapel='$_GET[id]'")) ?>
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