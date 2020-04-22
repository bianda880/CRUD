<?php
include("config.php");
if (isset($_POST["save_sawah"])) {
    //isset digunakan untuk mengecek apakah ketika
    //mengakses file ini, dikirimkan data dengan nama"save_siswa" dg method POST

    //menamoung data yang dikirimkan
    $action = $_POST["action"];
    $id_sawah = $_POST["id_sawah"];
    $tanaman = $_POST["tanaman"];
    $lokasi = $_POST["lokasi"];
    $harga = $_POST["harga"];
    $luas = $_POST["luas"];

    //menampung file image
    if (!empty($_FILES["image"]["name"])) {
        //mendapatkan deskripsi info gambar
        $path = pathinfo($_FILES["image"]["name"]);
        //mengambil ekstensi gambar
        $extension = $path["extension"];

        //rangkai filename-nya
        $filename = $id_sawah . "-" . rand(1, 1000) . "." . $extension;
    }

    if ($action == "insert") {
        $sql = "insert into sawah values ('$id_sawah', '$tanaman', '$lokasi', '$harga', '$luas', '$filename')";

        move_uploaded_file($_FILES["image"]["tmp_name"], "image/$filename");

        mysqli_query($connect, $sql);
    } else if ($action == "update") {
        if (!empty($_FILES["image"]["name"])) {
            //mendapatkan deskripsi info gambar
            $path = pathinfo($_FILES["image"]["name"]);
            //mengambil ekstensi gambar
            $extension = $path["extension"];

            //rangkai filename-nya
            $filename = $id_sawah . "-" . rand(1, 1000) . "." . $extension;

            //ambil data yang akan di edit
            $sql = "select * from sawah where id_sawah='$id_sawah'";
            $query = mysqli_query($connect, $sql);
            $hasil = mysqli_fetch_array($query);

            if (file_exists("image/" . $hasil["image"])) {
                unlink("image/" . $hasil["image"]);
                //menghapus gambar yanhg terdahulu
                move_uploaded_file($_FILES["image"]["tmp_name"], "image/$filename");
                $sql = "update sawah set tanaman='$tanaman',lokasi='$lokasi',harga='$harga',luas='$luas',image='$filename' where id_sawah='$id_sawah'";
            }
        } else {
            $sql = "update sawah set tanaman='$tanaman',lokasi='$lokasi',harga='$harga',luas='$luas' where id_sawah='$id_sawah'";
        }
        mysqli_query($connect, $sql);
    }

    header("location:sawah.php");
}

if (isset($_GET["hapus"])) {
    include("config.php");

    $id_sawah = $_GET["id_sawah"];
    $sql = "delete from sawah where id_sawah='$id_sawah'";
    $query = mysqli_query($connect, $sql);
    $hasil = mysqli_fetch_array($query);
    if (file_exists("image/" . $hasil["image"])) {
        unlink("image/" . $hasil["image"]);
    }
    $sql = "delete from sawah where id_sawah='$id_sawah'";

    mysqli_query($connect, $sql);

    header("location:sawah.php");
}
