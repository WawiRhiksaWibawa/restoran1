<?php
session_start();
include('config/config.php');

//login 
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = sha1(md5($_POST['password'])); //double encrypt to increase security
    $stmt = $mysqli->prepare("SELECT email, password, id_users, user_type FROM users WHERE (email =? AND password =?)"); //sql to log in user
    $stmt->bind_param('ss', $email, $password); //bind fetched parameters
    $stmt->execute(); //execute bind 
    $stmt->bind_result($email, $password, $id_users, $user_type); //bind result
    $rs = $stmt->fetch();
    $_SESSION['id_users'] = $id_users;
    $_SESSION['user_type'] = $user_type;
    if ($rs) {
        //redirect based on user type
        if ($user_type == 'admin') {
            header("location:Resto/admin/dasbor_admin.php");
        } elseif ($user_type == 'pelanggan') {
            header("location:Resto/pelanggan/dasbor_pelanggan.php");
        } elseif ($user_type == 'kasir') {
            header("location:Resto/kasir/dasbor_kasir.php");
        } elseif ($user_type == 'koki') {
            header("location:Resto/koki/dasbor_koki.php");
        } else {
            $err = "Jenis pengguna tidak dikenal";
        }
    } else {
        $err = "Password atau Email Salah";
    }
}
require_once('partials/_head.php');
?>

<style>
    /* CSS for background image */
    body {
        background-image: url('Resto/admin/assets/img/theme/bg.png');
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
                            <?php if (isset($err)) { echo "<div class='alert alert-danger'>$err</div>"; } ?>
                            <form method="post" role="form">
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
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id="customCheckLogin" type="checkbox">
                                    <label class="custom-control-label" for="customCheckLogin">
                                        <span class="text-muted">Ingat Saya</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <div class="text-left">
                                        <button type="submit" name="login" class="btn btn-primary my-4">Log In</button>
                                        <a href="Resto/pelanggan/buat_akun.php" class="btn btn-success pull-right">Buat Akun</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <!-- <a href="../admin/lupa_pwd.php" target="_blank" class="text-light"><small>Forgot password?</small></a> -->
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
