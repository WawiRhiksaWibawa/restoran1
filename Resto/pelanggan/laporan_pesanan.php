<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
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
                        Catatan Pesanan
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-success" scope="col">Kode</th>
                                        <th scope="col">Pelanggan</th>
                                        <th class="text-success" scope="col">Menu</th>
                                        <th scope="col">Harga Satuan</th>
                                        <th class="text-success" scope="col">#</th>
                                        <th scope="col">Total Harga</th>
                                        <th scop="col">Status</th>
                                        <th scop="col">Status Menu</th>
                                        <th class="text-success" scope="col">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_users = $_SESSION['id_users'];
                                    $ret = "SELECT * FROM  pesanan WHERE id_users ='$id_users' ORDER BY `created_at` DESC  ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($order = $res->fetch_object()) {
                                        $total = ($order->harga_menu * $order->jumlah_menu);

                                    ?>
                                        <tr>
                                            <th class="text-success" scope="row"><?php echo $order->kode_pesanan; ?></th>
                                            <td><?php echo $order->nama_user; ?></td>
                                            <td class="text-success"><?php echo $order->nama_menu; ?></td>
                                            <td>Rp. <?php echo $order->harga_menu; ?></td>
                                            <td class="text-success"><?php echo $order->jumlah_menu; ?></td>
                                            <td>Rp. <?php echo $total; ?></td>
                                            <td><?php if ($order->status_pesanan == '') {
                                                    echo "<span class='badge badge-danger'>Belum Bayar</span>";
                                                } else {
                                                    echo "<span class='badge badge-success'>$order->status_pesanan</span>";
                                                } ?></td>
                                            <td><?php if ($order->status_menu == '') {
                                                    echo "<span class='badge badge-warning'>Tunggu</span>";
                                                } elseif ($order->status_menu == 'dibuat') {
                                                    echo "<span class='badge badge-primary'>Sedang Dibuat</span>";
                                                } elseif ($order->status_menu == 'selesai') {
                                                    echo "<span class='badge badge-success'>Siap Dihidangkan</span>";
                                                } ?></td>
                                            <td class="text-success"><?php echo date('d/M/Y g:i', strtotime($order->created_at)); ?></td>
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