<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

//Delete User
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  
  // Cek apakah user_type adalah admin, kasir, atau koki sebelum dihapus
  $query = "SELECT user_type FROM users WHERE id_users = ?";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->bind_result($user_type);
  $stmt->fetch();
  $stmt->close();
  
  if ($user_type == 'admin' || $user_type == 'kasir' || $user_type == 'koki') {
    $adn = "DELETE FROM users WHERE id_users = ?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
      $success = "Terhapus" && header("refresh:1; url=user.php");
    } else {
      $err = "Coba Lagi Nanti";
    }
  } else {
    $err = "User tidak dapat dihapus.";
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
              <a href="tambah_user.php" class="btn btn-outline-success"><i class="fas fa-user-plus"></i>Tambah User</a>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th> <!-- Menambahkan kolom Role -->
                    <th scope="col">Tindakan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM users";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($users = $res->fetch_object()) {
                  ?>
                    <tr>
                      <td><?php echo $users->nama_user; ?></td> 
                      <td><?php echo $users->email; ?></td> 
                      <td><?php echo $users->user_type; ?></td> 
                      <td>
                        <a href="user.php?delete=<?php echo $users->id_users; ?>"> 
                          <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                            Hapus
                          </button>
                        </a>

                        <a href="perbarui_user.php?update=<?php echo $users->id_users; ?>"> 
                          <button class="btn btn-sm btn-primary">
                            <i class="fas fa-user-edit"></i>
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
