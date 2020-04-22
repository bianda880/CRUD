<?php
    session_start();
    include("config.php");

    if (isset($_POST["add_to_cart"])){
        $id_sawah = $_POST["id_sawah"];
        $luas_sewa = $_POST["luas_sewa"];
        $lama_sewa = $_POST["lama_sewa"];

        // ambil data buku dari database sesuai dg kode_buku yang dipilih
        $sql = "select * from sawah where id_sawah='$id_sawah'";
        $query = mysqli_query($connect, $sql); // eksekusi sintak sql nya
        $sawah = mysqli_fetch_array($query); // menampung data dari database ke array

        $item = [
            "id_sawah" => $sawah["id_sawah"],
            "tanaman" => $sawah["tanaman"],
            "lokasi" => $sawah["lokasi"],
            "harga" => $sawah["harga"],
            "luas" => $sawah["luas"],
            "luas_sewa" => $luas_sewa,
            "lama_sewa" => $lama_sewa
        ];

        //masukan item ke keranjang(cart)
        array_push($_SESSION["cart"], $item);
        print_r($_POST);

        header("location:tampilan_customer.php");
    }

    //menghapus item dalam cart
    if (isset($_GET["hapus"])) {
        //tampung data
        $id_sawah = $_GET["id_sawah"];

        // cari index cart sesuai dengan kode_buku yg dihapus
        $index = array_search(
            $id_sawah, array_column(
                $_SESSION["cart"], "id_sawah"
            )
        );

        // hapus item pada cart
        array_splice($_SESSION["cart"], $index, 1);
        header("location:cart.php");
    }

    //checkout
    if (isset($_GET["checkout"])) {
        // masukan data pada cart ke database (tabel transaksi)
        $id_transaksi = "ID".rand(1,10000);
        $tgl = date("Y-m-d H:i:s");
        $id_customer = $_SESSION["id_customer"];

        // buat query
        $sql = "insert into transaksi values('$id_transaksi','$tgl','$id_customer')";
        mysqli_query($connect, $sql);

        foreach($_SESSION["cart"] as $cart){
            $id_sawah = $cart["id_sawah"];
            $luas_sewa = $cart["luas_sewa"];
            $lama_sewa = $cart["lama_sewa"];
            $harga = $cart["harga"];

            //buat query
            $sql = "insert into detail_transaksi values ('$id_transaksi','$id_sawah','$luas_sewa','$lama_sewa','$harga')";
            mysqli_query($connect, $sql);

            $sql2 = "update sawah set luas = luas - $luas_sewa where id_sawah ='$id_sawah'";
            mysqli_query($connect, $sql2);
        }
        // kosongkan cart nya
        $_SESSION["cart"] = array();

        header("location:transaksi.php");
    }
?>