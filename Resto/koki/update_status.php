<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pesanan = $_POST['id_pesanan'];
    $status_menu = $_POST['status_menu'];

    $query = "UPDATE pesanan SET status_menu=? WHERE id_pesanan=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('si', $status_menu, $id_pesanan);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Status pesanan berhasil diperbarui";
    } else {
        $_SESSION['error'] = "Terjadi kesalahan, silakan coba lagi";
    }

    $stmt->close();
    header('Location: koki.php');
    exit();
}
?>
