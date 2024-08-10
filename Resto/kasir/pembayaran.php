<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
//Cancel Order
if (isset($_GET['cancel'])) {
    $id_users = $_GET['cancel'];
    $adn = "DELETE FROM  pesanan  WHERE  id_pesanan = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $id_users);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Terhapus" && header("refresh:1; url=pembayaran.php");
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
                            <a href="pesanan.php" class="btn btn-outline-success">
                                <i class="fas fa-plus"></i> <i class="fas fa-utensils"></i>
                                Buat Pesanan Baru
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Kode</th>
                                        <th scope="col">Pelanggan</th>
                                        <th scope="col">Menu</th>
                                        <th scope="col">Total Harga</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM  pesanan WHERE status_pesanan =''  ORDER BY `pesanan`.`created_at` DESC  ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($order = $res->fetch_object()) {
                                        $total = ($order->harga_menu * $order->jumlah_menu);

                                    ?>
                                        <tr>
                                            <th class="text-success" scope="row"><?php echo $order->kode_pesanan; ?></th>
                                            <td><?php echo $order->nama_user; ?></td>
                                            <td><?php echo $order->nama_menu; ?></td>
                                            <td>Rp. <?php echo $total; ?></td>
                                            <td><?php echo date('d/M/Y g:i', strtotime($order->created_at)); ?></td>
                                            <td>
                                                <a href="bayar_pesanan.php?kode_pesanan=<?php echo $order->kode_pesanan;?>&id_users=<?php echo $order->id_users;?>&status_pesanan=Sudah Bayar">
                                                    <button class="btn btn-sm btn-success">
                                                        <i class="fas fa-handshake"></i>
                                                        Bayar Pesanan
                                                    </button>
                                                </a>

                                                <a href="pembayaran.php?cancel=<?php echo $order->id_pesanan; ?>">
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="fas fa-window-close"></i>
                                                        Batalkan Pesanan
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