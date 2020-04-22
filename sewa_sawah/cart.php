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
    <title>SawahKU</title>

    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        Detail = (item) => {
            document.getElementById('id_sawah').value = item.id_sawah;
            document.getElementById('tanaman').innerHTML = item.tanaman;
            document.getElementById('lokasi').innerHTML = "lokasi: " + item.lokasi;
            document.getElementById('harga').innerHTML = "harga: " + item.harga;
            document.getElementById('luas').innerHTML = "luas: " + item.luas;
            document.getElementById('lama_sewa').value = "1";
            document.getElementById('luas_sewa').value = "1";
            document.getElementById('luas_sewa').max = item.stok;
            document.getElementById('image').src = "image/" + item.image;
        }
    </script>

</head>
<body>
    <nav class="navbar navbar-expand-md bg-danger navbar-dark fixed-top">
            <a href="#">
                <img src="logo.png" width="120" height="80" alt="">
            </a>

            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#menu">
                <span class="navbar navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="tampilan_customer.php" class="nav-link">Beranda</a></li>
                    <li class="nav-item"><a href="transaksi.php" class="nav-link">Order</a></li>
                    <li class="nav-item"><a href="cart.php" class="nav-link">Cart</a></li>
                    <li class="nav-item"><a href="proses_login_admin.php?logout=true" class="nav-link">
                            <?php echo $_SESSION["nama"]; ?> Logout</a></li>
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
                            <th>Tanaman</th>
                            <th>Harga</th>
                            <th>Luas Sewa</th>
                            <th>Lama Sewa</th>
                            <th>Total</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;?>
                        <?php foreach ($_SESSION["cart"] as $cart): ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $cart["tanaman"]; ?></td>
                                <td>Rp <?php echo $cart["harga"]; ?></td>
                                <td><?php echo $cart["luas_sewa"]; ?> m²</td>
                                <td><?php echo $cart["lama_sewa"]; ?> Tahun</td>
                                <td>Rp <?php echo $cart["luas_sewa"]*$cart["luas_sewa"]*$cart["harga"]; ?></td>
                                <td>
                                    <a href="proses_cart.php?hapus=true&id_sawah=<?php echo $cart["id_sawah"]?>">
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