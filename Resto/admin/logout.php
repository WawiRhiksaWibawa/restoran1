<?php
session_start();
unset($_SESSION['id_admin']);
session_destroy();
header("Location: ../../index.php");
exit;
