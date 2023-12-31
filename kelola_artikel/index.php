<?php
session_start();
if( !isset($_SESSION["login"])){
  header("location:../login/index.php");
  exit;
}

include "../koneksi.php";

$query = query("SELECT * FROM artikel");

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

        <a href="tambah.php" class="flex w-fit py-2 px-4 mt-4 ml-2 bg-orange-500 hover:bg-orange-600 text-white rounded-md text-sm items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>    
        Tambah Artikel
        </a>
        <div class="mt-4">
            <div class="bg-white rounded-md p-4 m-2">
                <table class="text-center w-full">
                    <tr class="p-3">
                        <th class="p-3 text-sm border-2 border-slate-200">No</th>
                        <th class="p-3 text-sm border-2 border-slate-200">Gambar</th>
                        <th class="p-3 text-sm border-2 border-slate-200">Judul</th>
                        <th class="p-3 text-sm border-2 border-slate-200">Isi Artikel</th>
                        <th class="w-32 p-3 text-sm border-2 border-slate-200">Aksi</th>
                    </tr>
                    <?php $no = 0; foreach($query as $data) : $no++;?>
                    <tr>
                        <td class="p-3 text-sm border-2 border-slate-200"><?= $no ?></td>
                        <td class="p-3 text-sm border-2 border-slate-200"><img class="w-32 inline-block justify-items-center" src="../public/img/<?= $data['gambar_artikel']; ?>"></td>
                        <td class="p-3 text-sm border-2 border-slate-200"><?= $data['judul_artikel']; ?></td>
                        <td class="p-3 text-sm border-2 border-slate-200"><?= $data['isi_artikel']; ?></td>
                        <td class="p-3 border-2 border-slate-200">
                            <div class="flex gap-x-2">
                                <a href="edit.php?id=<?= $data['id'];?>" class="inline-block py-2 px-4 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <a href="hapus.php?id=<?= $data['id'];?>" class="inline-block py-2 px-4 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        
    </div>
   </section>

</body>
</html>