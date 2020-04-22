<?php
session_start();
if (!isset($_SESSION["id_admin"])) {
    header("location:login_admin.php");
}
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sewa Sawah</title>

    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        Add = () => {
            document.getElementById('action').value = "insert";
            document.getElementById('id_sawah').value = "";
            document.getElementById('tanaman').value = "";
            document.getElementById('lokasi').value = "";
            document.getElementById('harga').value = "";
            document.getElementById('luas').value = "";
            document.getElementById('image').value = "";
        }

        Edit = (item) => {
            document.getElementById('action').value = "update";
            document.getElementById('id_sawah').value = item.id_sawah;
            document.getElementById('tanaman').value = item.tanaman;
            document.getElementById('lokasi').value = item.lokasi;
            document.getElementById('harga').value = item.harga;
            document.getElementById('luas').value = item.luas;
        }
    </script>

</head>

<body>
    <?php
    if (isset($_POST["cari"])) {
        //query jika mencari
        $cari = $_POST["cari"];
        $sql = "select * from sawah where id_sawah like '%$cari%' or tanaman like '%$cari%' or lokasi like '%$cari%' or harga like '%$cari%' or luas like '%$cari%'";
    } else {
        //query jika tidak mencari
        $sql = "select * from sawah";
    }

    //eksekusi perintah SQL-nya
    $query = mysqli_query($connect, $sql);
    ?>
    <div class="container">
        <nav class="navbar navbar-expand-md bg-danger navbar-dark fixed-top">
            <a href="#">
                <img src="logo.png" width="120" height="80" alt="">
            </a>

            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#menu">
                <span class="navbar navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="sawah.php" class="nav-link">Beranda</a></li>
                    <li class="nav-item"><a href="admin.php" class="nav-link">Admin</a></li>
                    <li class="nav-item"><a href="customer.php" class="nav-link">Customer</a></li>
                    <li class="nav-item"><a href="proses_login_admin.php?logout=true" class="nav-link">
                            <?php echo $_SESSION["nama"]; ?> Logout</a></li>
                </ul>
            </div>
        </nav>
        <!-- slide -->
        <div class="carousel slide" data-ride="carousel" id="slide">
            <ul class="carousel-indicators">
                <li data-target="#slide" data-slide-to="0" class="active"></li>
                <li data-target="#slide" data-slide-to="1"></li>
                <li data-target="#slide" data-slide-to="2"></li>
            </ul>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="slide1.jpg" width="100%" height="500" alt="">
                </div>
                <div class="carousel-item">
                    <img src="slide2.jpg" width="100%" height="500" alt="">
                </div>
                <div class="carousel-item">
                    <img src="slide3.jpg" width="100%" height="500" alt="">
                </div>
            </div>

            <a href="#slide" data-slide="prev" class="carousel-control-prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a href="#slide" data-slide="next" class="carousel-control-next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
        <div></div>
        <!-- start card -->
        <div class="card" margin-top>
            <div class="card-header bg-success text-white">
                <h4>Data Buku</h4>
            </div>
            <div class="card-body">
                <form action="buku.php" method="post">
                    <input type="text" name="cari" class="form-control" placeholder="Pencarian...">
                </form>
                <table class="table" border="1">
                    <thead>
                        <tr>
                            <th>ID Sawah</th>
                            <th>Tanaman</th>
                            <th>Lokasi</th>
                            <th>Harga/m²/Tahun</th>
                            <th>Luas/m²</th>
                            <th>Foto</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($query as $sawah) : ?>
                            <tr>
                                <td><?php echo $sawah["id_sawah"] ?></td>
                                <td><?php echo $sawah["tanaman"] ?></td>
                                <td><?php echo $sawah["lokasi"] ?></td>
                                <td><?php echo $sawah["harga"] ?></td>
                                <td><?php echo $sawah["luas"] ?></td>
                                <td>
                                    <img src="<?php echo 'image/' . $sawah['image']; ?>" alt="Foto Sawah" width="200" />
                                </td>
                                <td>
                                    <button data-toggle="modal" data-target="#modal_sawah" type="button" class="btn btn-sm btn-warning" onclick='Edit(<?php echo json_encode($sawah); ?>)'> Edit</button>
                                    <a href="proses_crud_sawah.php?hapus=true&id_sawah=<?php echo $sawah["id_sawah"]; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini')">
                                        <button type="button" class="btn btn-sm btn-danger">Hapus</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button data-toggle="modal" data-target="#modal_sawah" type="button" class="btn btn-sm btn-success" onclick="Add()">Tambah Data</button>
            </div>
        </div>
        <!-- end card -->
        <!-- form modal -->
        <div class="modal fade" id="modal_sawah">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="proses_crud_sawah.php" method="post" enctype="multipart/form-data">
                        <div class="modal-header bg-info text-white">
                            <h4>Form Buku</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="action" id="action">
                            ID Sawah
                            <input type="number" name="id_sawah" id="id_sawah" class="form-control" required />
                            Tanaman
                            <input type="text" name="tanaman" id="tanaman" class="form-control" required />
                            Lokasi
                            <input type="text" name="lokasi" id="lokasi" class="form-control" required />
                            Harga
                            <input type="text" name="harga" id="harga" class="form-control" required />
                            Luas
                            <input type="text" name="luas" id="luas" class="form-control" required />
                            Foto
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="save_sawah" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end modal -->
    </div>
</body>

</html>