<?php
include("config.php");
if (isset($_POST["save_buku"])){
    //isset digunakan untuk mengecek apakah ketika
    //mengakses file ini, dikirimkan data dengan nama"save_siswa" dg method POST

    //menamoung data yang dikirimkan
    $action =$_POST["action"];
    $kode_buku =$_POST["kode_buku"];
    $judul =$_POST["judul"];
    $penulis =$_POST["penulis"];
    $tahun =$_POST["tahun"];
    $harga =$_POST["harga"];
    $stok =$_POST["stok"];
    
    //menampung file image
    if(!empty($_FILES["image"]["name"])){
        //mendapatkan deskripsi info gambar
        $path = pathinfo($_FILES["image"]["name"]);
        //mengambil ekstensi gambar
        $extension = $path["extension"];

        //rangkai filename-nya
        $filename = $kode_buku."-".rand(1,1000).".".$extension;
    }

    if($action == "insert"){
        $sql = "insert into buku values ('$kode_buku', '$judul', '$penulis', '$tahun', '$harga', '$stok', '$filename')";

        move_uploaded_file($_FILES["image"]["tmp_name"],"image/$filename");

        mysqli_query($connect, $sql);
    }else if($action == "update"){
        if(!empty($_FILES["image"]["name"])){
            //mendapatkan deskripsi info gambar
            $path = pathinfo($_FILES["image"]["name"]);
            //mengambil ekstensi gambar
            $extension = $path["extension"];

            //rangkai filename-nya
            $filename = $kode_buku."-".rand(1,1000).".".$extension;

            //ambil data yang akan di edit
            $sql = "select * from buku where kode_buku='$kode_buku'";
            $query = mysqli_query($connect, $sql);
            $hasil = mysqli_fetch_array($query);

            if(file_exists("image/".$hasil["image"])){
                unlink("image/".$hasil["image"]);
                //menghapus gambar yanhg terdahulu
                move_uploaded_file($_FILES["image"]["tmp_name"],"image/$filename");
                $sql = "update buku set judul='$judul',penulis='$penulis',tahun='$tahun',harga='$harga',stok='$stok',image='$filename' where kode_buku='$kode_buku'";
            }
        }else{
            $sql = "update buku set judul='$judul',penulis='$penulis',tahun='$tahun',harga='$harga',stok='$stok' where kode_buku='$kode_buku'";
        }
        mysqli_query($connect, $sql);
    }

    header("location:buku.php");
}

if(isset($_GET["hapus"])){
    include("config.php");

    $nisn = $_GET["kode_buku"];
    $sql = "delete from buku where kode_buku='$kode_buku'";
    $query= mysqli_query();
    $hasil = mysqli_fetch_array($query);
    if(file_exists("image/".$hasil["image"])){
        unlink("image/".$hasil["image"]);
    }
    $sql = "delete from buku where kode_buku='$kode_buku'";

    mysqli_query($connect, $sql);

    //direct ke halaman siswa 
    header("location:buku.php");
}
?>