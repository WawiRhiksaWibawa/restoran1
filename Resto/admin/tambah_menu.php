<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['addProduct'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["kode_menu"]) || empty($_POST["nama_menu"]) || empty($_POST['deskripsi_menu']) || empty($_POST['harga_menu'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $id_menu = $_POST['id_menu'];
    $kode_menu  = $_POST['kode_menu'];
    $nama_menu = $_POST['nama_menu'];
    $gambar_menu = $_FILES['gambar_menu']['name'];
    move_uploaded_file($_FILES["gambar_menu"]["tmp_name"], "assets/img/menu/" . $_FILES["gambar_menu"]["name"]);
    $deskripsi_menu = $_POST['deskripsi_menu'];
    $harga_menu = $_POST['harga_menu'];
	
    //Insert Captured information to a database table
    $postQuery = "INSERT INTO menu (id_menu, kode_menu, nama_menu, gambar_menu, deskripsi_menu, harga_menu ) VALUES(?,?,?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ssssss', $id_menu, $kode_menu, $nama_menu, $gambar_menu, $deskripsi_menu, $harga_menu);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Menu Ditambahkan" && header("refresh:1; url=tambah_menu.php");
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
              <h3>Harap Isi Semua Kolom</h3>
            </div>
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Nama menu</label>
                    <input type="text" name="nama_menu" class="form-control">
                    <input type="hidden" name="id_menu" value="<?php echo $id_menu; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Kode menu</label>
                    <input type="text" name="kode_menu" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Gambar menu</label>
                    <input type="file" name="gambar_menu" class="btn btn-outline-success form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label>Harga menu</label>
                    <input type="text" name="harga_menu" class="form-control" value="">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-12">
                    <label>Deskripsi menu</label>
                    <textarea rows="5" name="deskripsi_menu" class="form-control" value=""></textarea>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="addProduct" value="Tambah menu" class="btn btn-success" value="">
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
  require_once('partials/_scripts.php');
  ?>
</body>

</html>