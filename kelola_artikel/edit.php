<?php
session_start();

if( !isset($_SESSION["login"])){
  header("location:../login/index.php");
  exit;
}

include "../koneksi.php";
$id = $_GET['id'];

$query = query ("SELECT * FROM artikel WHERE id = '$id'")[0]; 
if(isset($_POST['simpan'])){
    $id = $query['id'];
    $judul = htmlspecialchars($_POST['judul']);
    $isi = htmlspecialchars($_POST['isi']);
    $gambarLama = htmlspecialchars($_POST['gambarLama']);

    if($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    }else {
        $gambar = upload();
    }

    $update = mysqli_query($koneksi,"UPDATE artikel SET 
                            judul_artikel = '$judul',
                            isi_artikel = '$isi',
                            gambar_artikel = '$gambar' WHERE id = '$id'");

    if($update){
        echo"<script> alert('Perubahan berhasil di simpan');
        document.location.href = 'index.php'</script>";
    }else {
        echo"<script>
                alert('Perubahan gagal di simpan');
                document.location.href = 'index.php'
            </script>";
    }
}

function upload() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if($error === 4) {
        echo "<script>
                alert('Silahkan masukkan gambar terlebih dahulu!')
            </script>";

        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if(!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('Yang anda masukkan bukan gambar!')
            </script>";

        return false;
    }

    if($ukuranFile > 5000000) {
        echo "<script>
                alert('Ukuran gambar terlalu besar!')
            </script>";

        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, '../public/img/' . $namaFileBaru);
    return $namaFileBaru;

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="shortcut icon" href="../public/img/logo.png" type="image/x-icon" />
    <title>Kelola Artikel</title>
</head>
<body class="bg-slate-200">
    <header class="fixed h-full w-64 bg-orange-500 text-white">
        <div class="flex py-9 items-center justify-center">
            <h1 class="font-semibold text-2xl">Education Gerabah</h1>
        </div>
            <nav class="">
                <ul class="">
                    <li class="py-4 text-orange-300"><a href="../dashboard/index.php" class="pl-4">Dashboard</a></li>
                    <li class="py-4 text-orange-300"><a href="../kelola_pelatihan/index.php" class="pl-4">Kelola Pelatihan</a></li>
                    <li class="py-4"><a href="index.php" class="pl-4">Kelola Artikel</a></li>
                    <li class="py-4 text-orange-300"><a href="../admin/index.php" class="pl-4">Admin</a></li>
                    <li class="py-4 text-orange-300"><a href="../kelola_admin/index.php" class="pl-4">Kelola Admin</a></li>
                </ul>
                <button type="button" class="absolute bottom-5">
                    <a href="../logout.php" class="flex inset-x-0 bg-gray-200 hover:bg-gray-300 text-orange-500 font-medium rounded-lg text-sm px-20 py-2 mx-4 items-center">Logout
                        <svg class="w-3 h-3 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                             <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h11m0 0-4-4m4 4-4 4m-5 3H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h3"/>
                        </svg>
                    </a>
                </button>
            </nav>
       </header>
   <section class="ml-64">
    <div class="container px-5 pb-5">
        <h1 class="py-10 border-b-[1px] ml-2  border-slate-400 ">Dashboard/Kelola Artikel</h1>

        <div class="mt-4">
            <h1 class="text-xl font-semibold text-center">Edit Data Artikel</h1>
            <form action="" class="mt-4 " method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $query['id']; ?>">
                <input type="hidden" name="gambarLama" value="<?= $query['gambar_artikel']; ?>">
                <div class="w-[80%] mx-auto">
                    <label for="judul" class="text-lg ">Judul</label>
                    <input type="text" name="judul" class="w-full mt-2 h-9 rounded-md p-2" required value="<?= $query['judul_artikel']; ?>">
                </div>
                <div class="w-[80%] mx-auto mt-4">
                    <label for="isi" class="text-lg ">Isi Artikel</label>
                    <input type="text" name="isi" class="w-full mt-2 h-9 rounded-md p-2" required value="<?= $query['isi_artikel']; ?>">
                </div>
                <!-- <div class="w-[80%] mx-auto mt-4">
                    <label for="gambar" class="text-lg ">Gambar</label>
                    <input type="text" name="gambar" class="w-full mt-2 h-9 rounded-md p-2" required value="<?= $query['gambar_artikel']; ?>">
                </div> -->
                <div class="w-[80%] mx-auto mt-4">
                    <label for="gambar" class="text-lg ">Gambar</label>
                    <img class="w-32 mt-2 mb-2 items-center" src="../public/img/<?= $query['gambar_artikel']; ?>">
                    <input class="block w-full text-sm text-gray-900 border-lg file:bg-orange-500 border-gray-900 rounded-md cursor-pointer bg-gray-50 focus:outline-none" id="gambar" name="gambar" type="file">
                </div>
                <div class="w-[80%] mx-auto mt-4">
                    <button name="simpan" class="py-2 px-4 bg-orange-500 hover:bg-orange-600 text-white rounded-md mb-11">Simpan</button>
                    <a href="index.php" class="py-2 px-4 bg-red-600 hover:bg-red-700 text-white rounded-md mb-11 ml-2">Batal</a>
                </div>
            </form>

        </div>
        
    </div>
   </section>

</body>
</html>