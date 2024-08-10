<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (isset($_POST['pay'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["kode_pembayaran"]) || empty($_POST["harga_pembayaran"]) || empty($_POST['metode_pembayaran'])) {
    $err = "Harus Di isi";
    //Perform Regex On Payments
    
  } else {

    $kode_pembayaran = $_POST['kode_pembayaran'];

      if(strlen($kode_pembayaran) < 10 )
      {
        $err = "Verifikasi Kode Pembayaran Gagal, Silakan Coba Lagi";
      }
      elseif(strlen($kode_pembayaran) > 10)
      {
        $err = "Verifikasi Kode Pembayaran Gagal, Silakan Coba Lagi";
      }
      
      else
      {
          $kode_pembayaran = $_POST['kode_pembayaran'];
          $kode_pesanan = $_GET['kode_pesanan'];
          $id_users = $_GET['id_users'];
          $harga_pembayaran  = $_POST['harga_pembayaran'];
          $metode_pembayaran = $_POST['metode_pembayaran'];
          $id_pembayaran = $_POST['id_pembayaran'];

          $status_pesanan = $_GET['status_pesanan'];

          //Insert Captured information to a database table
          $postQuery = "INSERT INTO pembayaran (id_pembayaran, kode_pembayaran, kode_pesanan, id_users, harga_pembayaran, metode_pembayaran) VALUES(?,?,?,?,?,?)";
          $upQry = "UPDATE pesanan SET status_pesanan =? WHERE kode_pesanan =?";

          $postStmt = $mysqli->prepare($postQuery);
          $upStmt = $mysqli->prepare($upQry);
          //bind paramaters

          $rc = $postStmt->bind_param('ssssss', $id_pembayaran, $kode_pembayaran, $kode_pesanan, $id_users, $harga_pembayaran, $metode_pembayaran);
          $rc = $upStmt->bind_param('ss', $status_pesanan, $kode_pesanan);

          $postStmt->execute();
          $upStmt->execute();
          //declare a varible which will be passed to alert function
          if ($upStmt && $postStmt) {
              $success = "Sudah Bayar" && header("refresh:1; url=laporan_pembayaran.php");
          } else {
              $err = "Silakan Coba Lagi Atau Coba Nanti";
          }
      }
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
    $kode_pesanan = $_GET['kode_pesanan'];
    $ret = "SELECT * FROM  pesanan WHERE kode_pesanan ='$kode_pesanan' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($order = $res->fetch_object()) {
        $total = ($order->harga_menu * $order->jumlah_menu);
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
              <h3>Harap Isi Semua Kolom</h3>
            </div>
            <div class="card-body">
              <form method="POST"  enctype="multipart/form-data">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>ID Pembayaran</label>
                    <input type="text" name="id_pembayaran" readonly value="<?php echo $payid;?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Kode Pembayaran</label>
                    <input type="text" name="kode_pembayaran" readonly value="<?php echo $mpesaCode; ?>" class="form-control" value="">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Jumlah (Rp.)</label>
                    <input type="text" name="harga_pembayaran" readonly value="<?php echo $total;?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Metode Pembayaran</label>
                    <select class="form-control" name="metode_pembayaran">
                        <option selected>Tunai</option>
                        <option>Dana</option>
                    </select>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="pay" value="Bayar Pesanan" class="btn btn-success" value="">
                  </div>
                </div>
              </form>
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
  require_once('partials/_scripts.php'); }
  ?>
</body>

</html>