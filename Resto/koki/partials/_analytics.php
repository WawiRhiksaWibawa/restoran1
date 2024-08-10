<?php
//1. Customers
$query = "SELECT COUNT(*) FROM `users` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($customers);
$stmt->fetch();
$stmt->close();

//2. Orders
$query = "SELECT COUNT(*) FROM `pesanan` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($orders);
$stmt->fetch();
$stmt->close();

//3. Orders
$query = "SELECT COUNT(*) FROM `menu` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($menu);
$stmt->fetch();
$stmt->close();

//4.Sales
$query = "SELECT SUM(harga_pembayaran) FROM `pembayaran` ";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($sales);
$stmt->fetch();
$stmt->close();
