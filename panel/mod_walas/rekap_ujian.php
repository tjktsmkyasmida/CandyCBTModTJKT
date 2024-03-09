<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border '>
                <h3 class='box-title'><i class="fas fa-user-friends fa-fw   "></i> Rekap Ujian</h3>
                <div class='box-tools pull-right'>

                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <div class='table-responsive'>
                    <table style="font-size: 11px" id='tablesiswa' class='table  '>
                        <thead>
                            <tr>
                                <th width='3px'>No</th>
                                <th>No_Peserta</th>
                                <th>Nama</th>
                                <?php $mapel = mysqli_query($koneksi, "select * from nilai a join siswa b on a.id_siswa=b.id_siswa where b.id_kelas ='$pengawas[jabatan]' group by a.id_mapel") ?>
                                <?php while ($data = mysqli_fetch_array($mapel)) { ?>
                                    <?php $napel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM mapel where id_mapel='$data[id_mapel]'")) ?>

                                    <th><?= $napel['kode'] ?></th>

                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php $siswa = mysqli_query($koneksi, "select * from siswa where id_kelas='$pengawas[jabatan]'") ?>
                            <?php while ($data = mysqli_fetch_array($siswa)) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['no_peserta'] ?></td>
                                    <td><?= $data['nama'] ?></td>
                                    <?php $mapelx = mysqli_query($koneksi, "select * from nilai where id_siswa='$data[id_siswa]'  group by id_mapel") ?>
                                    <?php while ($datax = mysqli_fetch_array($mapelx)) { ?>
                                        <td><span class="badge bg-green"> <?= $datax['skor'] ?></span></td>
                                    <?php } ?>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#cekall').change(function() {
        $(this).parents('#tablesiswa:eq(0)').
        find(':checkbox').attr('checked', this.checked);
    });
    $(function() {
        $("#btnstatus").click(function() {
            id_array = new Array();
            i = 0;
            $("input.cekpilih:checked").each(function() {
                id_array[i] = $(this).val();
                i++;
            });
            $.ajax({
                url: "mod_walas/ajax_walas.php?pg=statusaktif",
                data: "kode=" + id_array,
                type: "POST",
                success: function(respon) {
                    if (respon == 1) {
                        // $("input.cekpilih:checked").each(function() {
                        //     $(this).parent().parent().remove('.cekpilih').animate({
                        //         opacity: "hide"
                        //     }, "slow");
                        // })
                        location.reload();
                    }
                }
            });
            return false;
        })
    });
    $(function() {
        $("#btnstatus2").click(function() {
            id_array = new Array();
            i = 0;
            $("input.cekpilih:checked").each(function() {
                id_array[i] = $(this).val();
                i++;
            });
            $.ajax({
                url: "mod_walas/ajax_walas.php?pg=statusnonaktif",
                data: "kode=" + id_array,
                type: "POST",
                success: function(respon) {
                    if (respon == 1) {
                        // $("input.cekpilih:checked").each(function() {
                        //     $(this).parent().parent().remove('.cekpilih').animate({
                        //         opacity: "hide"
                        //     }, "slow");
                        // })
                        location.reload();
                    }
                }
            });
            return false;
        })
    });
</script>