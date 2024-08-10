<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['make'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["kode_pesanan"]) || empty($_POST["nama_user"]) || empty($_GET['harga_menu'])) {
        $err = "Blank Values Not Accepted";
    } else {
        $id_pesanan = $_POST['id_pesanan'];
        $kode_pesanan  = $_POST['kode_pesanan'];
        $id_users = $_SESSION['id_users'];
        $nama_user = $_POST['nama_user'];
        $id_menu  = $_GET['id_menu'];
        $nama_menu = $_GET['nama_menu'];
        $harga_menu = $_GET['harga_menu'];
        $jumlah_menu = $_POST['jumlah_menu'];

        //Insert Captured information to a database table
        $postQuery = "INSERT INTO pesanan (jumlah_menu, id_pesanan, kode_pesanan, id_users, nama_user, id_menu, nama_menu, harga_menu) VALUES(?,?,?,?,?,?,?,?)";
        $postStmt = $mysqli->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('sssissss', $jumlah_menu, $id_pesanan, $kode_pesanan, $id_users, $nama_user, $id_menu, $nama_menu, $harga_menu);
        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt) {
            $success = "Pesanan Dikirim" && header("refresh:1; url=pembayaran.php");
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
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-row">

                                    <div class="col-md-6">
                                        <label>Nama Pelanggan</label>
                                        <?php
                                        //Load All Customers
                                        $id_users = $_SESSION['id_users'];
                                        $ret = "SELECT * FROM  users WHERE id_users = '$id_users' ";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($cust = $res->fetch_object()) {
                                        ?>
                                            <input class="form-control" readonly name="nama_user" value="<?php echo $cust->nama_user; ?>">
                                        <?php } ?>
                                        <input type="hidden" name="id_pesanan" value="<?php echo $orderid; ?>" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Kode Pesanan</label>
                                        <input type="text" readonly name="kode_pesanan" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
                                    </div>
                                </div>
                                <hr>
                                <?php
                                $id_menu = $_GET['id_menu'];
                                $ret = "SELECT * FROM  menu WHERE id_menu = '$id_menu'";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($prod = $res->fetch_object()) {
                                ?>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Harga Menu (Rupiah)</label>
                                            <input type="text" readonly name="harga_menu" value="Rp. <?php echo $prod->harga_menu; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Jumlah Menu</label>
                                            <input type="text" name="jumlah_menu" class="form-control" value="">
                                        </div>
                                    </div>
                                <?php } ?>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <input type="submit" name="make" value="Buat Pesanan" class="btn btn-success" value="">
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