<?php if ($pg == '') : ?>
    <?php include 'home.php'; ?>
<?php elseif ($pg == 'dataserver') : ?>
    <?php include 'mod_master/server.php'; ?>
<?php elseif ($pg == 'sinkron') : ?>
    <?php cek_session_admin(); ?>
    <?php include 'mod_sinkron/sinkronisasi.php'; ?>
<?php elseif ($pg == 'sinkronset') : ?>
    <?php cek_session_admin(); ?>
    <?php include 'mod_sinkron/sinkronsetting.php'; ?>
<?php elseif ($pg == 'informasi') : ?>
    <?php include 'informasi.php'; ?>
<?php elseif ($pg == 'dataujian') : ?>
    <?php include 'mod_sinkron/dataujian.php'; ?>
<?php elseif ($pg == 'pengumuman') : ?>
    <?php include 'pengumuman.php'; ?>
<?php elseif ($pg == 'guru') : ?>
    <?php cek_session_admin(); ?>
    <?php include 'mod_guru/guru.php'; ?>
<?php elseif ($pg == 'beritaacara') : ?>
    <?php include 'mod_berita/prev_berita.php'; ?>
<?php elseif ($pg == 'berita') : ?>
    <?php include 'mod_berita/berita.php'; ?>
<?php elseif ($pg == 'jadwal') : ?>
    <?php cek_session_guru(); ?>
    <?php include "mod_jadwal/jadwal.php"; ?>
<?php elseif ($pg == 'ujianguru') : ?>
    <?php cek_session_guru();
    include "ujian_guru.php"; ?>
<?php elseif ($pg == 'tugas') : ?>
    <?php include 'mod_tugas/tugas.php'; ?>
<?php elseif ($pg == 'materi') : ?>
    <?php include 'materi/materi.php'; ?>
<?php elseif ($pg == 'nilaiujian') : ?>
    <?php include 'mod_nilai/nilaiujian2.php'; ?>
<?php elseif ($pg == 'nilai') : ?>
    <?php include 'mod_nilai/nilai.php'; ?>
<?php elseif ($pg == 'semuanilai') : ?>
    <?php include 'mod_nilai/semuanilai.php'; ?>
<?php elseif ($pg == 'reset') : ?>
    <?php include 'mod_status/reset.php'; ?>
<?php elseif ($pg == 'status') : ?>
    <?php cek_session_guru(); ?>
    <?php include "mod_status/status_peserta.php"; ?>
<?php elseif ($pg == 'kartu') : ?>
    <?php include 'mod_kartu/kartu.php'; ?>
<?php elseif ($pg == 'absen') : ?>
    <?php include 'mod_absen/absen.php'; ?>
<?php elseif ($pg == 'rekapabsen') : ?>
    <?php include 'mod_absen/rekap_absen.php'; ?>
<?php elseif ($pg == 'absenperhari') : ?>
    <?php include 'mod_absen/rekapabsenharian.php'; ?>	
<?php elseif ($pg == 'siswa') : ?>
    <?php include 'mod_siswa/siswa.php'; ?>
<?php elseif ($pg == 'uplfotosiswa') : ?>
    <?php cek_session_admin(); ?>
    <?php include 'mod_siswa/uploadfoto.php'; ?>
<?php elseif ($pg == 'importmaster') : ?>
    <?php cek_session_admin(); ?>
    <?php include 'mod_master/import.php'; ?>
<?php elseif ($pg == 'siswabinaan') : ?>
    <?php cek_session_guru(); ?>
    <?php include 'mod_walas/siswa_binaan.php'; ?>
<?php elseif ($pg == 'progress') : ?>
    <?php cek_session_guru(); ?>
    <?php include 'mod_walas/progress.php'; ?>
<?php elseif ($pg == 'rekap') : ?>
<!--    <?php cek_session_guru(); ?> -->
    <?php include 'mod_walas/rekap_ujian.php'; ?>
<?php elseif ($pg == 'importguru') : ?>
    <?php
    cek_session_admin(); ?>
    <?php include 'mod_guru/import.php'; ?>
<?php elseif ($pg == 'filependukung') : ?>
    <div class='box box-solid'>
        <div class='box-header with-border'>
            <h3 class='box-title'>Data File Pendukung</h3>
            <div class='box-tools pull-right '>
                <button id="btnhapusfile" class='btn btn-sm btn-flat btn-success'><i class='fas fa-trash'></i> Hapus</button>

            </div>
        </div><!-- /.box-header -->
        <div class='box-body'>
            <div id='tablereset'>
                <table id='example1' class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th width='5px'><input type='checkbox' id='ceksemua'></th>
                            <th width='10'>No</th>
                            <th>Nama File</th>
                            <th>Kode Bank Soal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM file_pendukung");
                        $no = 1;
                        while ($file = mysqli_fetch_array($query)) {
                            $mapel = fetch($koneksi, 'mapel', ['id_mapel' => $file['id_mapel']]);
                            if ($mapel['kode'] == '') {
                                $status = "<span style='color:red'>Soal Sudah Dihapus</span>";
                            } else {
                                $status = $mapel['kode'];
                            }
                        ?>
                            <tr>
                                <td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-<?= $no ?>' value="<?= $file['id_file'] ?>"></td>
                                <td scope="row"><?= $no++ ?></td>
                                <td><?= "<img src='../files/" . $file['nama_file'] . "' width='50'>" ?></td>
                                <td><?= $status ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div><!-- /.box-body -->

    </div><!-- /.box -->
    <script>
        $(function() {
            $("#btnhapusfile").click(function() {
                id_array = new Array();
                i = 0;
                $("input.cekpilih:checked").each(function() {
                    id_array[i] = $(this).val();
                    i++;
                });
                $.ajax({
                    url: "hapusfile.php",
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
<?php elseif ($pg == 'user') : ?>
    <?php cek_session_admin(); ?>
    <div class='row'>
        <div class='col-md-8'>
            <div class='box box-solid'>
                <div class='box-header with-border'>
                    <h3 class='box-title'><i class="fas fa-users-cog    "></i> Manajemen Pengawas</h3>
                </div><!-- /.box-header -->
                <div class='box-body'>
                    <div class='table-responsive'>
                        <table id='example1' class='table table-bordered table-striped'>
                            <thead>
                                <tr>
                                    <th width='5px'>#</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Level</th>
                                    <th>Ruang</th>
                                    <th width=60px></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $pengawasQ = mysqli_query($koneksi, "SELECT * FROM pengawas where level='pengawas' ORDER BY nama ASC"); ?>
                                <?php while ($pengawas = mysqli_fetch_array($pengawasQ)) : ?>
                                    <?php $no++; ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $pengawas['nip'] ?></td>
                                        <td><?= $pengawas['nama'] ?></td>
                                        <td><?= $pengawas['username'] ?></td>
                                        <td><?= $pengawas['level'] ?></td>
                                        <td><?= $pengawas['ruang'] ?></td>
                                        <td style="text-align:center">
                                            <div class=''>
                                                <a href="?pg=<?= $pg ?>&ac=edit&id=<?= $pengawas['id_pengawas'] ?>"> <button class='btn btn-flat btn-xs btn-warning'><i class='fa fa-edit'></i></button></a>
                                                <a href="?pg=<?= $pg ?>&ac=hapus&id=<?= $pengawas['id_pengawas'] ?>"> <button class='btn btn-flat btn-xs bg-maroon'><i class='fa fa-trash'></i></button></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class='col-md-4'>
            <?php if ($ac == '') : ?>
                <?php
                if (isset($_POST['submit'])) :
                    $nip = $_POST['nip'];
                    $nama = $_POST['nama'];
                    $nama = str_replace("'", "&#39;", $nama);
                    $username = $_POST['username'];
                    $pass1 = $_POST['pass1'];
                    $pass2 = $_POST['pass2'];
                    $ruang = $_POST['ruang'];

                    $cekuser = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE username='$username'"));
                    if ($cekuser > 0) {
                        $info = info("Username $username sudah ada!", "NO");
                    } else {
                        if ($pass1 <> $pass2) :
                            $info = info("Password tidak cocok!", "NO");
                        else :
                            $password = password_hash($pass1, PASSWORD_BCRYPT);
                            $exec = mysqli_query($koneksi, "INSERT INTO pengawas (nip,nama,username,password,level,ruang) VALUES ('$nip','$nama','$username','$password','pengawas','$ruang')");
                            (!$exec) ? $info = info("Gagal menyimpan!", "NO") : jump("?pg=$pg");
                        endif;
                    }
                endif;
                ?>
                <form action='' method='post'>
                    <div class='box box-solid'>
                        <div class='box-header with-border'>
                            <h3 class='box-title'>Tambah</h3>
                            <div class='box-tools pull-right '>
                                <button type='submit' name='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
                            </div>
                        </div><!-- /.box-header -->
                        <div class='box-body'>
                            <?= $info ?>
                            <div class='form-group'>
                                <label>NIP</label>
                                <input type='text' name='nip' class='form-control' required='true' />
                            </div>
                            <div class='form-group'>
                                <label>Nama</label>
                                <input type='text' name='nama' class='form-control' required='true' />
                            </div>
                            <div class='form-group'>
                                <label>Username</label>
                                <input type='text' name='username' class='form-control' required='true' />
                            </div>
                            <div class='form-group'>
                                <label>Ruang</label>
                                <input type='text' name='ruang' class='form-control' required='true' />
                            </div>
                            <div class='form-group'>
                                <div class='row'>
                                    <div class='col-md-6'>
                                        <label>Password</label>
                                        <input type='password' name='pass1' class='form-control' required='true' />
                                    </div>
                                    <div class='col-md-6'>
                                        <label>Ulang Password</label>
                                        <input type='password' name='pass2' class='form-control' required='true' />
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </form>
            <?php elseif ($ac == 'edit') : ?>
                <?php
                $id = $_GET['id'];
                $value = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE id_pengawas='$id'"));
                if (isset($_POST['submit'])) :
                    $nip = $_POST['nip'];
                    $nama = $_POST['nama'];
                    $nama = str_replace("'", "&#39;", $nama);
                    $username = $_POST['username'];
                    $pass1 = $_POST['pass1'];
                    $pass2 = $_POST['pass2'];
                    $ruang = $_POST['ruang'];
                    if ($pass1 <> '' and $pass2 <> '') {
                        if ($pass1 <> $pass2) :
                            $info = info("Password tidak cocok!", "NO");
                        else :
                            $password = password_hash($pass1, PASSWORD_BCRYPT);
                            $exec = mysqli_query($koneksi, "UPDATE pengawas SET nip='$nip',nama='$nama',username='$username',password='$password',ruang='$ruang' WHERE id_pengawas='$id'");
                        endif;
                    } else {
                        $exec = mysqli_query($koneksi, "UPDATE pengawas SET nip='$nip',nama='$nama',username='$username',ruang='$ruang' WHERE id_pengawas='$id'");
                    }
                    (!$exec) ? $info = info("Gagal menyimpan!", "NO") : jump("?pg=$pg");
                endif;
                ?>
                <form action='' method='post'>
                    <div class='box box-solid'>
                        <div class='box-header with-border'>
                            <h3 class='box-title'>Edit</h3>
                            <div class='box-tools pull-right '>
                                <button type='submit' name='submit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check'></i> Simpan</button>
                                <a href='?pg=<?= $pg ?>' class='btn btn-sm bg-maroon' title='Batal'><i class='fa fa-times'></i></a>
                            </div>
                        </div><!-- /.box-header -->
                        <div class='box-body'>
                            <?= $info ?>
                            <div class='form-group'>
                                <label>NIP</label>
                                <input type='text' name='nip' value="<?= $value['nip'] ?>" class='form-control' required='true' />
                            </div>
                            <div class='form-group'>
                                <label>Nama</label>
                                <input type='text' name='nama' value="<?= $value['nama'] ?>" class='form-control' required='true' />
                            </div>
                            <div class='form-group'>
                                <label>Username</label>
                                <input type='text' name='username' value="<?= $value['username'] ?>" class='form-control' required='true' />
                            </div>
                            <div class='form-group'>
                                <label>Ruang</label>
                                <input type='text' name='ruang' value="<?= $value['ruang'] ?>" class='form-control' required='true' />
                            </div>
                            <div class='form-group'>
                                <div class='row'>
                                    <div class='col-md-6'>
                                        <label>Password</label>
                                        <input type='password' name='pass1' class='form-control' />
                                    </div>
                                    <div class='col-md-6'>
                                        <label>Ulang Password</label>
                                        <input type='password' name='pass2' class='form-control' />
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </form>
            <?php elseif ($ac == 'hapus') : ?>
                <?php
                $id = $_GET['id'];
                $info = info("Anda yakin akan menghapus pengawas ini?");
                if (isset($_POST['submit'])) {
                    $exec = mysqli_query($koneksi, "DELETE FROM pengawas WHERE id_pengawas='$id'");
                    (!$exec) ? $info = info("Gagal menghapus!", "NO") : jump("?pg=$pg");
                }
                ?>
                <form action='' method='post'>
                    <div class='box box-danger'>
                        <div class='box-header with-border'>
                            <h3 class='box-title'>Hapus</h3>
                            <div class='box-tools pull-right '>
                                <button type='submit' name='submit' class='btn btn-sm bg-maroon'><i class='fa fa-trash'></i> Hapus</button>
                                <a href='?pg=<?= $pg ?>' class='btn btn-sm btn-default' title='Batal'><i class='fa fa-times'></i></a>
                            </div>
                        </div><!-- /.box-header -->
                        <div class='box-body'>
                            <?= $info ?>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php elseif ($pg == 'pengawas') : ?>
    <?php cek_session_admin(); ?>
    <?php include 'mod_user/user.php'; ?>
    <!-- DATA MASTER -->
<?php elseif ($pg == 'matapelajaran') : ?>
    <?php cek_session_admin(); ?>
    <?php include 'mod_master/mapel.php'; ?>
<?php elseif ($pg == 'pk') : ?>
    <?php cek_session_admin(); ?>
    <?php include 'mod_master/jurusan.php'; ?>
<?php elseif ($pg == 'jenisujian') : ?>
    <?php cek_session_admin(); ?>
    <?php include 'mod_master/jenis.php'; ?>
<?php elseif ($pg == 'ruang') : ?>
    <?php cek_session_admin(); ?>
    <?php include 'mod_master/ruang.php'; ?>
<?php elseif ($pg == 'level') : ?>
    <?php cek_session_admin(); ?>
    <?php include 'mod_master/level.php'; ?>
<?php elseif ($pg == 'sesi') : ?>
    <?php cek_session_admin(); ?>
    <?php include 'mod_master/sesi.php'; ?>
<?php elseif ($pg == 'kelas') : ?>
    <?php cek_session_admin(); ?>
    <?php include 'mod_master/kelas.php'; ?>
<?php elseif ($pg == 'banksoal') : ?>
    <?php include "mod_banksoal/banksoal.php"; ?>
<?php elseif ($pg == 'editguru') : ?>
    <?php
    if (isset($_POST['submit'])) :
        $username = $_POST['username'];
        $nip = $_POST['nip'];
        $nama = $_POST['nama'];
        $nama = str_replace("'", "&#39;", $nama);
        if ($_POST['password'] <> "") {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $exec = mysqli_query($koneksi, "UPDATE pengawas SET username='$username', nama='$nama',nip='$nip',password='$password' WHERE id_pengawas='$id_pengawas'");
        } else {
            $exec = mysqli_query($koneksi, "UPDATE pengawas SET username='$username', nama='$nama',nip='$nip' WHERE id_pengawas='$id_pengawas'");
        }
    endif;
    ?>
    <?php if ($ac == '') : ?>
        <?php
        $guru = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE id_pengawas='$pengawas[id_pengawas]'"));
        ?>
        <div class='row'>
            <div class='col-md-3'>
                <div class='box box-solid'>
                    <div class='box-body box-profile'>
                        <img class='profile-user-img img-responsive img-circle' alt='User profile picture' src='<?= $homeurl ?>/dist/img/avatar-6.png'>
                        <h3 class='profile-username text-center'><?= $guru['nama'] ?></h3>
                    </div>
                </div>
            </div>
            <div class='col-md-9'>
                <div class='nav-tabs-custom'>
                    <ul class='nav nav-tabs'>
                        <li class='active'><a aria-expanded='true' href='#detail' data-toggle='tab'><i class='fa fa-user'></i> Detail Profile</a></li>
                    </ul>
                    <div class='tab-content'>
                        <div class='tab-pane active' id='detail'>
                            <div class='row margin-bottom'>
                                <form action='' method='post'>
                                    <div class='col-sm-12'>
                                        <table class='table table-striped table-bordered'>
                                            <tbody>
                                                <tr>
                                                    <th scope='row'>Nama Lengkap</th>
                                                    <td><input class='form-control' name='nama' value="<?= $guru['nama'] ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <th scope='row'>Nip</th>
                                                    <td><input class='form-control' name='nip' value="<?= $guru['nip'] ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <th scope='row'>Username</th>
                                                    <td><input class='form-control' name='username' value="<?= $guru['username'] ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <th scope='row'>Ganti Password</th>
                                                    <td><input class='form-control' name='password' /></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button name='submit' class='btn btn-sm btn-flat btn-success pull-right'>Perbarui Data </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class='tab-pane' id='alamat'>
                            <div class='row margin-bottom'>
                                <div class='col-sm-12'>
                                    <table class='table  table-striped no-margin'>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class='tab-pane' id='kesehatan'>
                            <div class='row margin-bottom'>
                                <div class='col-sm-12'>
                                    <table class='table  table-striped no-margin'>
                                        <tbody>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php elseif ($pg == 'pengaturan') : ?>
    <?php include "mod_setting/setting.php"; ?>
<?php elseif ($pg == 'statusall') : ?>
 
    <?php include "mod_status/status_peserta.php"; ?>
	
<?php elseif ($pg == 'statussiswa') : ?>
 
    <?php include "mod_status/status_peserta.php"; ?>
	
	
<?php else : ?>
    <div class='error-page'>
        <h2 class='headline text-yellow'> 404</h2>
        <div class='error-content'>
            <br />
            <h3><i class='fa fa-warning text-yellow'></i> Upss! Halaman tidak ditemukan.</h3>
            <p>
                Halaman yang anda inginkan saat ini tidak tersedia.<br />
                Silahkan kembali ke <a href='?'><strong>dashboard</strong></a> dan coba lagi.<br />
                Hubungi petugas <strong><i>Developer</i></strong> jika ini adalah sebuah masalah.
            </p>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->
<?php endif ?>