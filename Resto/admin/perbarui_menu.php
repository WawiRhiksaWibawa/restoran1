<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['UpdateProduct'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["kode_menu"]) || empty($_POST["nama_menu"]) || empty($_POST['deskripsi_menu']) || empty($_POST['harga_menu'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $update = $_GET['update'];
    $kode_menu  = $_POST['kode_menu'];
    $nama_menu = $_POST['nama_menu'];
    $gambar_menu = $_FILES['gambar_menu']['name'];
    move_uploaded_file($_FILES["gambar_menu"]["tmp_name"], "assets/img/menu/" . $_FILES["gambar_menu"]["name"]);
    $deskripsi_menu = $_POST['deskripsi_menu'];
    $harga_menu = $_POST['harga_menu'];

    //Insert Captured information to a database table
    $postQuery = "UPDATE menu SET kode_menu =?, nama_menu =?, gambar_menu =?, deskripsi_menu =?, harga_menu =? WHERE id_menu = ?";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ssssss', $kode_menu, $nama_menu, $gambar_menu, $deskripsi_menu, $harga_menu, $update);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Menu Diperbarui" && header("refresh:1; url=menu.php");
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
    $ret = "SELECT * FROM  menu WHERE id_menu = '$update' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($prod = $res->fetch_object()) {
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
                      <label>Nama Menu</label>
                      <input type="text" value="<?php echo $prod->nama_menu; ?>" name="nama_menu" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Kode Menu</label>
                      <input type="text" name="kode_menu" value="<?php echo $prod->kode_menu; ?>" class="form-control" value="">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Gambar Menu</label>
                      <input type="file" name="gambar_menu" class="btn btn-outline-success form-control" value="<?php echo $gambar_menu; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Harga Menu</label>
                      <input type="text" name="harga_menu" class="form-control" value="<?php echo $prod->harga_menu; ?>">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-12">
                      <label>Deskripsi Menu</label>
                      <textarea rows="5" name="deskripsi_menu" class="form-control" value=""><?php echo $prod->deskripsi_menu; ?></textarea>
                    </div>
                  </div>
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="UpdateProduct" value="Perbarui Menu" class="btn btn-success" value="">
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