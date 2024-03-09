<?php
if (isset($_POST["uplod"])) {
    $output = '';
    if ($_FILES['zip_file']['name'] != '') {
        $file_name = $_FILES['zip_file']['name'];
        $array = explode(".", $file_name);
        $name = $array[0];
        $ext = $array[1];
        if ($ext == 'zip') {
            $path = '../foto/fotosiswa/';
            $location = $path . $file_name;
            if (move_uploaded_file($_FILES['zip_file']['tmp_name'], $location)) {
                $zip = new ZipArchive;
                if ($zip->open($location)) {
                    $zip->extractTo($path);
                    $zip->close();
                }
                $files = scandir($path);
                foreach ($files as $file) {
                    $file_ext = pathinfo($file, PATHINFO_EXTENSION);
                    $allowed_ext = array('jpg', 'JPG');
                    if (in_array($file_ext, $allowed_ext)) {
                        $output .= '<div class="col-md-3"><div style="padding:16px; border:1px solid #CCC;"><img class="img img-responsive" style="height:150px;" src="../foto/fotosiswa/' . $file . '" /></div></div>';
                    }
                }
                unlink($location);
                $pesan = "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-check'></i> Info</h4>Upload File zip berhasil</div>";
            }
        } else {
            $pesan = "<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-info'></i> Gagal Upload</h4>Mohon Upload file zip</div>";
        }
    }
}
?>
<?php
if (isset($_POST['hapussemuafoto'])) {
    $files = glob('../foto/fotosiswa/*'); // Ambil semua file yang ada dalam folder
    foreach ($files as $file) {
        // Lakukan perulangan dari file yang kita ambil
        if (is_file($file)) { // Cek apakah file tersebut benar-benar ada
            unlink($file); // Jika ada, hapus file tersebut
        }
    }
}
?>
<div class='box box-danger'>
    <div class='box-header with-border'>
        <h3 class='box-title'>Upload Foto Peserta Ujian</h3>
        <div class='box-tools pull-right '>
            <a href='?pg=siswa' class='btn btn-sm bg-maroon' title='Batal'><i class='fa fa-times'></i></a>
        </div>
    </div><!-- /.box-header -->
    <div class='box-body'>
        <div class='alert alert-danger alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
            <h4><i class='icon fa fa-info'></i> Info</h4>
            Upload gambar dalam berkas zip. Penamaan gambar sesuai dengan no peserta siswa ujian
        </div>
        <form action='' method='post' enctype='multipart/form-data'>
            <div class='col-md-6'>
                <input class='form-control' type='file' name='zip_file' accept='.zip' />
            </div>
            <div class='col-md-6'>
                <button class='btn bg-maroon' name='uplod' type='submit'>Upload Foto</button>
            </div>
        </form>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<div class='box box-solid'>
    <div class='box-header with-border'>
        <h3 class='box-title'>Daftar Foto Peserta</h3>
        <div class='box-tools pull-right '>
            <form action='' method='post'>
                <button class='btn btn-sm bg-maroon' name='hapussemuafoto'>hapus semua foto</button>
            </form>
        </div>
    </div><!-- /.box-header -->
    <div class='box-body'>
        <?php
        $ektensi = ['jpg', 'png', 'JPG', 'PNG'];
        $folder = "../foto/fotosiswa/"; //Sesuaikan Folder nya
        if (!($buka_folder = opendir($folder))) die("eRorr... Tidak bisa membuka Folder");
        $file_array = array();
        while ($baca_folder = readdir($buka_folder)) :
            $file_array[] = $baca_folder;
        endwhile;
        $jumlah_array = count($file_array);
        for ($i = 2; $i < $jumlah_array; $i++) :
            $nama_file = $file_array;
            $nomor = $i - 1;
            $ext = explode('.', $nama_file[$i]);
            $ext = end($ext);
            if (in_array($ext, $ektensi)) {
                echo "<div class='col-md-1'><img class='img-logo' src='$folder$nama_file[$i]' style='width:65px'/><br><br></div>";
            }
        endfor;
        closedir($buka_folder);
        ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->