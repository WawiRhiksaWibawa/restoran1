<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
//Add Customer
if (isset($_POST['updateCustomer'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["no_telp"]) || empty($_POST["nama_user"]) || empty($_POST['email']) || empty($_POST['password_pelanggan'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $nama_user = $_POST['nama_user'];
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email'];
    $password_pelanggan = sha1(md5($_POST['password_pelanggan'])); //Hash This 
    $update = $_GET['update'];

    //Insert Captured information to a database table
    $postQuery = "UPDATE pelanggan SET nama_user =?, no_telp =?, email =?, password_pelanggan =? WHERE  id_pelanggan =?";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('sssss', $nama_user, $no_telp, $email, $password_pelanggan, $update);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Pelanggan Ditambahkan" && header("refresh:1; url=pelanggan.php");
    } else {
      $err = "Silakan Coba Lagi Atau Coba Nanti";
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
    $update = $_GET['update'];
    $ret = "SELECT * FROM  users WHERE id_users = '$update' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($cust = $res->fetch_object()) {
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
                <form method="POST">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Nama Pelanggan</label>
                      <input type="text" name="nama_user" value="<?php echo $cust->nama_user; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Email Pelanggan</label>
                      <input type="email" name="email" value="<?php echo $cust->email; ?>" class="form-control" value="">
                    </div>
                  <hr>

                    <div class="col-md-6">
                      <label>Password Pelanggan</label>
                      <input type="password" name="password_pelanggan" class="form-control" value="">
                    </div>
                  </div>
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="updateCustomer" value="Perbarui Pelanggan" class="btn btn-success" value="">
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
    }
      ?>
      </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>