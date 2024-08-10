<?php
include('config/pdoconfig.php');

if (!empty($_POST["custName"])) {
    $id_users = $_POST['custName'];
    $stmt = $DB_con->prepare("SELECT * FROM  users WHERE nama_user = :id_users");
    $stmt->execute(array(':id_users' => $id_users));
?>
<?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<?php echo htmlentities($row['id_users']); ?>
<?php
    }
}
