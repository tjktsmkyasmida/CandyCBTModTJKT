<div class='row'>
    <div class='col-md-12'>
        <div class='box box-solid'>
            <div class='box-header with-border '>
                <h3 class='box-title'><i class="fas fa-user-friends fa-fw   "></i> Peserta Ujian</h3>
                <div class='box-tools pull-right'>
                    <button id='btnstatus' class='btn btn-sm btn-primary'><i class="fas fa-edit    "></i> Aktifkan</button>
                    <button id='btnstatus2' class='btn btn-sm btn-danger'><i class="fas fa-edit    "></i> Non Aktifkan</button>
                </div>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <div class='table-responsive'>
                    <table style="font-size: 11px" id='tablesiswa' class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th width='5px'><input type='checkbox' id='cekall'></th>
                                <th width='3px'></th>
                                <th>No_Peserta</th>
                                <th>Nama</th>
                                <th>sesi</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>No_Hp</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php $siswa = mysqli_query($koneksi, "select * from siswa where id_kelas='$pengawas[jabatan]'") ?>
                            <?php while ($data = mysqli_fetch_array($siswa)) { ?>
                                <tr>
                                    <td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-<?= $no ?>' value="<?= $data['id_siswa'] ?>"></td>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['no_peserta'] ?></td>
                                    <td><?= $data['nama'] ?></td>
                                    <td><?= $data['sesi'] ?></td>
                                    <td><?= $data['username'] ?></td>
                                    <td><?= $data['password'] ?></td>
                                    <td>
                                        <?php if ($data['hp'] <> "") { ?>
                                            <a target="_blank" href="https://api.whatsapp.com/send?phone=<?= $data['hp'] ?>&text=<?= $data['nama'] ?>" role="button"><i class="fab fa-2x fa-whatsapp text-green   "></i> <?= $data['hp'] ?></a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($data['status'] == 'aktif') { ?>
                                            <span class="badge bg-green">Aktif</span>
                                        <?php  } else { ?>
                                            <span class="badge bg-red">Tidak Aktif</span>
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