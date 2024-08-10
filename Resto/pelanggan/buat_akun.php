<?php
session_start();
include('config/config.php');
include('config/code-generator.php'); // Pastikan code-generator.php ada

// Add Customer
if (isset($_POST['addCustomer'])) {
    // Prevent Posting Blank Values
    if (empty($_POST["nama_user"]) || empty($_POST['email']) || empty($_POST['password'])) {
        $err = "Blank Values Not Accepted";
    } else {
        $nama_user = $_POST['nama_user'];
        $email = $_POST['email'];
        $password = sha1(md5($_POST['password'])); // Hash This 
        $id_users = $_POST['id_users'];
        $user_type = 'pelanggan'; // Default user type for this form

        // Insert Captured information to the users table
        $postQuery = "INSERT INTO users (nama_user, email, password, user_type) VALUES (?, ?, ?, ?)";
        $postStmt = $mysqli->prepare($postQuery);
        // Bind parameters
        $rc = $postStmt->bind_param('ssss', $nama_user, $email, $password, $user_type);
        $postStmt->execute();
        // Declare a variable which will be passed to alert function
        if ($postStmt) {
            $success = "Akun Pelanggan Dibuat" && header("refresh:1; url=../../index.php");
        } else {
            $err = "Silakan Coba Lagi Atau Coba Nanti";
        }
    }
}
require_once('partials/_head.php');
?>

<style>
    /* CSS for background image */
    body {
        background-image: url('../admin/assets/img/theme/bg.png');
        background-size: cover;
        background-position: center;
    }
</style>

<body class="bg-dark">
    <div class="main-content">
        <div class="header bg-gradient-primar py-7">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">Tanoshii Sushi</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form method="post" role="form">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input class="form-control" required name="nama_user" placeholder="Nama Lengkap" type="text">
                                        <input class="form-control" value="<?php echo $cus_id;?>" required name="id_users" type="hidden">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" required name="email" placeholder="Email" type="email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" required name="password" placeholder="Password" type="password">
                                    </div>
                                </div>

                                <div class="text-center">
                                </div>
                                <div class="form-group">
                                    <div class="text-left">
                                        <button type="submit" name="addCustomer" class="btn btn-primary my-4">Buat Akun</button>
                                        <a href="../../index.php" class="btn btn-success pull-right">Log In</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <!--<a href="../admin/lupa_pwd.php" target="_blank" class="text-light"><small>Lupa password?</small></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php
    require_once('partials/_footer.php');
    ?>
    <!-- Argon Scripts -->
    <?php
    require_once('partials/_scripts.php');
    ?>
</body>

</html>
