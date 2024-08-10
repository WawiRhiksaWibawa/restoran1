<?php
//Global variables
$id_users = $_SESSION['id_users'];

//1. My Orders
$query = "SELECT COUNT(*) FROM `pesanan` WHERE id_users =  '$id_users' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($orders);
$stmt->fetch();
$stmt->close();

//3. Available Products
$query = "SELECT COUNT(*) FROM `menu` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($menu);
$stmt->fetch();
$stmt->close();

//4.My Payments
$query = "SELECT SUM(harga_pembayaran) FROM `pembayaran` WHERE id_users = '$id_users' ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($sales);
$stmt->fetch();
$stmt->close();
