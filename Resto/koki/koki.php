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
        <div style="background-image: url(assets/img/theme/bg.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
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
                                        <th scop="col">Status</th>
                                        <th scope="col">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM pesanan ORDER BY `created_at` DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($order = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <th class="text-success" scope="row"><?php echo $order->kode_pesanan; ?></th>
                                            <td><?php echo $order->nama_user; ?></td>
                                            <td class="text-success"><?php echo $order->nama_menu; ?></td>
                                            <td><?php if ($order->status_pesanan == '') {
                                                    echo "<span class='badge badge-danger'>Belum Bayar</span>";
                                                } else {
                                                    echo "<span class='badge badge-success'>$order->status_pesanan</span>";
                                                } ?></td>
                                            <td>
                                                <?php if ($order->status_pesanan != '') { ?>
                                                    <?php if ($order->status_menu == '') { ?>
                                                        <form method="POST" action="update_status.php" style="display:inline-block;">
                                                            <input type="hidden" name="id_pesanan" value="<?php echo $order->id_pesanan; ?>">
                                                            <input type="hidden" name="status_menu" value="dibuat">
                                                            <button type="submit" class="btn btn-primary btn-sm">Dibuat</button>
                                                        </form>
                                                    <?php } elseif ($order->status_menu == 'dibuat') { ?>
                                                        <form method="POST" action="update_status.php" style="display:inline-block;">
                                                            <input type="hidden" name="id_pesanan" value="<?php echo $order->id_pesanan; ?>">
                                                            <input type="hidden" name="status_menu" value="selesai">
                                                            <button type="submit" class="btn btn-success btn-sm">Selesai</button>
                                                        </form>
                                                    <?php } elseif ($order->status_menu == 'selesai') { ?>
                                                        <span class='badge badge-success'>Selesai</span>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <span class='badge badge-warning'>Tidak Dapat diproses</span>
                                                <?php } ?>
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
