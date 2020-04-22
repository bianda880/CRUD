<?php
include("config.php");
if (isset($_POST["save_admin"])){

    $action =$_POST["action"];
    $id_admin =$_POST["id_admin"];
    $nama =$_POST["nama"];
    $kontak =$_POST["kontak"];
    $username =$_POST["username"];
    $password =$_POST["password"];

    if($action == "insert"){
        $sql = "insert into admin values ('$id_admin', '$nama', '$kontak', '$username', '$password')";

        mysqli_query($connect, $sql);
    }else if($action == "update"){
        $sql = "update admin set nama='$nama',kontak='$kontak',username='$username',password='$password' where id_admin='$id_admin'";
        // belum dieksekusi nak
        mysqli_query($connect, $sql);
    }
    
    header("location:admin.php");
}

if(isset($_GET["hapus"])){
    include("config.php");

    $id_admin = $_GET["id_admin"];
    $sql = "delete from admin where id_admin='$id_admin'";
    $query= mysqli_query();
    $hasil = mysqli_fetch_array($query);
    
    mysqli_query($connect, $sql);
 
    header("location:admin.php");
}
?>