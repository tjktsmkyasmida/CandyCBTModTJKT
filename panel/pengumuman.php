<?php
cek_session_admin();
if (isset($_POST['simpanpengumuman'])) {
    $exec = mysqli_query($koneksi, "INSERT INTO pengumuman (judul,text,user,type) VALUES ('$_POST[judul]','$_POST[pengumuman]','$pengawas[id_pengawas]','$_POST[tipe]')");
    if (!$exec) {
        $info = info("Gagal menyimpan!", "NO");
    } else {
        jump("?pg=$pg");
    }
}
?>
<div class='row'>
    <form action='' method='post'>
        <div class='col-md-6'>
            <div class='box box-solid'>
                <div class='box-header with-border'>
                    <h3 class='box-title'> Tulis Pengumuman</h3>
                    <div class='box-tools pull-right'>
                        <button type='submit' name='simpanpengumuman' class='btn btn-sm btn-flat btn-success'><i class='fa fa-edit'></i> Simpan</button>
                        <a href='?pg=<?= $pg ?>' class='btn btn-sm bg-maroon'><i class='fa fa-times'></i></a>
                    </div>
                </div><!-- /.box-header -->
                <div class='box-body'>
                    <div class='col-sm-12'>
                        <div class='form-group'>
                            <label>Judul </label>
                            <input type='text' class='form-control' name='judul' placeholder='Judul' required>
                        </div>
                    </div>
                    <div class='col-sm-12'>
                        <div class='form-group'>
                            <label>Jenis Pengumuman </label><br>
                            <input type='radio' name='tipe' value='internal' checked> <span class='text-green'><b>guru</b></span> &nbsp; &nbsp;&nbsp;<input type='radio' name='tipe' value='eksternal'> <span class='text-blue'><b>siswa</b></span>
                        </div>
                    </div>
                    <div class='col-sm-12'>
                        <div class='form-group'>
                            <label>Informasi Pengumuman </label>
                            <textarea id='txtpengumuman' name='pengumuman' class='form-control'></textarea>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </form>
    <div class='col-md-6'>
        <div class='box box-solid'>
            <div class='box-header with-border'>
                <h3 class='box-title'> Pengumuman</h3>
            </div><!-- /.box-header -->
            <div class='box-body'>
                <div class='table-responsive'>
                    <table id='example1' class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th width='5px'></th>
                                <th>Pengumuman</th>
                                <th>Untuk</th>
                                <th width='60px'></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $pengumumanq = mysqli_query($koneksi, "SELECT * FROM pengumuman ORDER BY date DESC"); ?>
                            <?php while ($pengumuman = mysqli_fetch_array($pengumumanq)) : ?>
                                <?php $no++; ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $pengumuman['judul'] ?></td>
                                    <td>
                                        <?php if ($pengumuman['type'] == 'eksternal') : ?>
                                            <small class='label bg-blue'>siswa</label>
                                            <?php else : ?>
                                                <small class='label bg-green'>guru</label>
                                                <?php endif ?>
                                    </td>
                                    <td align='center'>
                                        <div class=''>
                                            <a><button class='btn bg-maroon btn-flat btn-xs' data-toggle='modal' data-target="#hapus<?= $pengumuman['id_pengumuman'] ?>"><i class='fa fa-trash'></i></button></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $info = info("Anda yakin akan menghapus pengumuman ini ?"); ?>
                                <?php
                                if (isset($_POST['hapus'])) {
                                    $exec = mysqli_query($koneksi, "DELETE FROM pengumuman WHERE id_pengumuman = '$_REQUEST[idu]'");
                                    (!$exec) ? info("Gagal menyimpan", "NO") : jump("?pg=$pg");
                                }
                                ?>
                                <div class='modal fade' id="hapus<?= $pengumuman['id_pengumuman'] ?>" style='display: none;'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>
                                            <div class='modal-header bg-maroon'>
                                                <button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
                                                <h3 class='modal-title'>Hapus Pengumuman</h3>
                                            </div>
                                            <div class='modal-body'>
                                                <form action='' method='post'>
                                                    <input type='hidden' id='idu' name='idu' value="<?= $pengumuman['id_pengumuman'] ?>" />
                                                    <div class='callout '>
                                                        <h4><?= $info ?></h4>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <div class='box-tools pull-right '>
                                                            <button type='submit' name='hapus' class='btn btn-sm bg-maroon'><i class='fa fa-trash'></i> Hapus</button>
                                                            <button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
<script>
    tinymce.init({
        selector: '#txtpengumuman',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste'
        ],

        toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | emoticons code | imagetools link image paste ',
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        paste_data_images: true,
        paste_as_text: true,
        images_upload_handler: function(blobInfo, success, failure) {
            success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
        },
        image_class_list: [{
            title: 'Responsive',
            value: 'img-responsive'
        }],
    });
</script>