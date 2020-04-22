<?php
session_start();
if(!isset($_SESSION["id_customer"])){
    header("location:login_customer.php");
}
include("config.php");
?>

<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Toko Buku</title>

    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        Detail = (item) => {
            document.getElementById('kode_buku').value = item.kode_buku;
            document.getElementById('judul').innerHTML = item.judul;
            document.getElementById('penulis').innerHTML = "penulis: " + item.penulis;
            document.getElementById('harga').innerHTML = "harga: " + item.harga;
            document.getElementById('stok').innerHTML = "stok: " + item.stok;
            document.getElementById('jumlah_beli').value = "1";

            document.getElementById('image').src = "image/" + item.image;
        }

        Edit = (item) =>{
            document.getElementById('action').value = "update";
            document.getElementById('id_admin').value = item.id_admin;
            document.getElementById('nama').value = item.nama;
            document.getElementById('kontak').value = item.kontak;
            document.getElementById('username').value = item.username;
            document.getElementById('password').value = item.password;
        }
    </script>

</head>
<body>
    <nav class="navbar navbar-expand-md bg-info navbar-dark fixed-top">
        <a href="#">
            <img src="buku.png" width="150" alt="">
        </a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#menu">
            <span class="navbar navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="tampilan_customer.php" class="nav-link">Beranda</a></li>
                <li class="nav-item"><a href="transaksi.php" class="nav-link">Order</a></li>
                <li class="nav-item"><a href="cart.php" class="nav-link">Cart (<?php echo count($_SESSION["cart"])?>)</a></li>        
                <li class="nav-item"><a href="proses_login_customer.php?logout=true" class="nav-link"> 
                    <?php echo $_SESSION["nama"];?> Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="card-header bg-primary">
                <h4>Keranjang Belanja</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;?>
                        <?php foreach ($_SESSION["cart"] as $cart): ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $cart["judul"]; ?></td>
                                <td>Rp <?php echo $cart["harga"]; ?></td>
                                <td><?php echo $cart["jumlah_beli"]; ?></td>
                                <td>Rp <?php echo $cart["jumlah_beli"]*$cart["harga"]; ?></td>
                                <td>
                                    <a href="proses_cart.php?hapus=true&kode_buku=<?php echo $cart["kode_buku"]?>">
                                        <button type="button" class="btn btn-sm btn-danger">Hapus</button>
                                    </a>
                                </td>
                            </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                    <tfoot>
                        <a href="proses_cart.php?checkout=true">
                            <button type="button" class="btn btn-success">Checkout</button>
                        </a>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</body>
</html>