<?php
session_start();
unset($_SESSION['id_Koki']);
session_destroy();
header("Location: ../../index.php");
exit;
