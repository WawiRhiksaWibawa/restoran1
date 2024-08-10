<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

// Udpate User
if (isset($_POST['UpdateUser'])) {
  // Prevent Posting Blank Values
  if (empty($_POST["nama_user"]) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['id_users'])) {
    $err = "Nilai Kosong Tidak Diterima";
  } else {
    $nama_user = $_POST['nama_user'];
    $email = $_POST['email'];
    $password = sha1(md5($_POST['password'])); // Password hashing
    $id_users = $_POST['id_users'];
    $update = $_GET['update'];

    // Update Captured information in the database table
    $postQuery = "UPDATE users SET nama_user =?, email =?, password =?, id_users =? WHERE id_users =?";
    $postStmt = $mysqli->prepare($postQuery);
    // Bind parameters
    $rc = $postStmt->bind_param('ssssi', $nama_user, $email, $password, $id_users, $update);
    $postStmt->execute();
    // Declare a variable which will be passed to alert function
    if ($postStmt) {
      $success = "Staff Diperbarui" && header("refresh:1; url=user.php");
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
    $ret = "SELECT * FROM users WHERE id_users = '$update' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($users = $res->fetch_object()) {
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
                <form method="POST">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Nama User</label>
                      <input type="text" name="nama_user" class="form-control" value="<?php echo $users->nama_user; ?>"> <!-- Ubah dari nama_kasir ke nama_user -->
                    </div>
                    <div class="col-md-6">
                      <label>Email User</label>
                      <input type="email" name="email" class="form-control" value="<?php echo $users->email; ?>"> 
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Password User</label>
                      <input type="password" name="password" class="form-control" value="">
                    </div>
                    <div class="col-md-6">
                      <label>Role User</label>
                      <select name="user_type" class="form-control">
                        <option value="<?php echo $users->user_type; ?>"><?php echo ucfirst($users->user_type); ?></option> 
                        <option value="kasir">Kasir</option>
                        <option value="koki">Koki</option>
                      </select>
                    </div>
                  </div>
                  </div>

                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="UpdateUser" value="Perbarui User" class="btn btn-success">
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
