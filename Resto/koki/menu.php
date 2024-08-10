<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $adn = "DELETE FROM  menu  WHERE  id_menu = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Terhapus" && header("refresh:1; url=menu.php");
    } else {
        $err = "Coba Lagi Nanti";
    }
}
require_once('partials/_head.php');
?>

<body>
    <!-- Sidenav -->
    <?php
    require_once('partials/_sidebar.php');
    ?>
    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <?php
        require_once('partials/_topnav.php');
        ?>
        <!-- Header -->
        <div style="background-image: url(../admin/assets/img/theme/bg.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
        <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body">
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--8">
            <!-- Table -->
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                        Produk Makanan
                            <!-- <a href="tambah_menu.php" class="btn btn-outline-success">
                                <i class="fas fa-utensils"></i>
                                Add New Product
                            </a> -->
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Kode Menu</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">harga</th>
                                        <th scope="col">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM  menu  ORDER BY `menu`.`created_at` DESC ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($prod = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td>
                                                <?php
                                                if ($prod->gambar_menu) {
                                                    echo "<img src='../admin/assets/img/menu/$prod->gambar_menu' height='60' width='60 class='img-thumbnail'>";
                                                } else {
                                                    echo "<img src='../admin/assets/img/menu/default.jpg' height='60' width='60 class='img-thumbnail'>";
                                                }

                                                ?>
                                            </td>
                                            <td><?php echo $prod->kode_menu; ?></td>
                                            <td><?php echo $prod->nama_menu; ?></td>
                                            <td>Rp. <?php echo $prod->harga_menu; ?></td>
                                            <td>
                                                <a href="perbarui_menu.php?update=<?php echo $prod->id_menu; ?>">
                                                    <button class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                        Perbarui
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php
            require_once('partials/_footer.php');
            ?>
        </div>
    </div>
    <!-- Argon Scripts -->
    <?php
    require_once('partials/_scripts.php');
    ?>
</body>
</html>