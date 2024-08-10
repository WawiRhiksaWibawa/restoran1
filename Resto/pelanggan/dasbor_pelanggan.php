<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

require_once('partials/_head.php');
require_once('partials/_analytics.php');
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
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-4 col-lg-6">
              <a href="pesanan.php">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Menu Yang Tersedia</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $menu; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-purple text-white rounded-circle shadow">
                          <i class="fas fa-utensils"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-xl-4 col-lg-6">
              <a href="laporan_pesanan.php">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total Pesanan</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $orders; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                          <i class="fas fa-shopping-cart"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-xl-4 col-lg-6">
              <a href="laporan_pembayaran.php">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total Uang yang dikeluarkan</h5>
                        <span class="h2 font-weight-bold mb-0">Rp.<?php echo $sales; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                          <i class="fas fa-wallet"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row mt-5">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Pesanan Terbaru</h3>
                </div>
                <div class="col text-right">
                  <a href="laporan_pesanan.php" class="btn btn-sm btn-primary">Liat Semua</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
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
                    <th class="text-success" scope="col">Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $id_users = $_SESSION['id_users'];
                  $ret = "SELECT * FROM  pesanan WHERE id_users = '$id_users' ORDER BY `pesanan`.`created_at` DESC LIMIT 10 ";
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
                      <td>Rp.<?php echo $order->harga_menu; ?></td>
                      <td class="text-success"><?php echo $order->jumlah_menu; ?></td>
                      <td>Rp.<?php echo $total; ?></td>
                      <td><?php if ($order->status_pesanan == '') {
                            echo "<span class='badge badge-danger'>Belum Bayar</span>";
                          } else {
                            echo "<span class='badge badge-success'>$order->status_pesanan</span>";
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
		
      <div class="row mt-5">
        <div class="col-xl-12">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Pembayaran Terbaru Saya</h3>
                </div>
                <div class="col text-right">
                  <a href="laporan_pembayaran.php" class="btn btn-sm btn-primary">Liat Semua</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="text-success" scope="col">Kode</th>
                    <th scope="col">Jumlah</th>
                    <th class='text-success' scope="col">Kode Pesanan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM   pembayaran WHERE id_users ='$id_users'   ORDER BY `pembayaran`.`created_at` DESC LIMIT 10 ";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($payment = $res->fetch_object()) {
                  ?>
                    <tr>
                      <th class="text-success" scope="row">
                        <?php echo $payment->kode_pembayaran; ?>
                      </th>
                      <td>
                        $<?php echo $payment->harga_pembayaran; ?>
                      </td>
                      <td class='text-success'>
                        <?php echo $payment->kode_pesanan; ?>
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
      <?php require_once('partials/_footer.php'); ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>