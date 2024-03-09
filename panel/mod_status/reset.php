<?php $info = ''; ?>
<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'>Reset Ujian Peserta</h3>
                <div class='box-tools pull-right '>
                    <button id='btnresetlogin2' class='btn  btn-flat btn-success'><i class='fa fa-check'></i> Reset Ujian</button>
                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <?= $info ?>
                <div id='tablereset' class='table-responsive'>
                    <table id='example1' class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th width='5px'><input type='checkbox' id='ceksemua'></th>
                                <th width='5px'>#</th>
                                <th>No Peserta</th>
                                <th>Nama Peserta</th>
                                <th>Mulai Ujian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $loginQ = mysqli_query($koneksi, "SELECT * FROM nilai where online='1' and ujian_selesai is null ORDER BY ujian_mulai DESC"); ?>
                            <?php while ($login = mysqli_fetch_array($loginQ)) : ?>
                                <?php
                                $siswa = mysqli_fetch_array(mysqli_query($koneksi, "select * from siswa where id_siswa='$login[id_siswa]'"));
                                $no++;
                                ?>
                                <tr>
                                    <td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-<?= $no ?>' value="<?= $login['id_nilai'] ?>"></td>
                                    <td><?= $no ?></td>
                                    <td><?= $siswa['no_peserta'] ?></td>
                                    <td><?= $siswa['nama'] ?></td>
                                    <td><?= $login['ujian_mulai'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
<script>
    $(function() {
        $("#btnresetlogin2").click(function() {
            id_array = new Array();
            i = 0;
            $("input.cekpilih:checked").each(function() {
                id_array[i] = $(this).val();
                i++;
            });
            $.ajax({
                url: "mod_status/ajax_status.php?pg=resetlogin",
                data: "kode=" + id_array,
                type: "POST",
                success: function(respon) {
                    if (respon == 1) {
                        $("input.cekpilih:checked").each(function() {
                            $(this).parent().parent().remove('.cekpilih').animate({
                                opacity: "hide"
                            }, "slow");
                        })
                    }
                }
            });
            return false;
        })
    });
</script>