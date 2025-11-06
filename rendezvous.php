<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>
<?php
include "db.php";
$idd = $_GET['doctor_id'];
$idu = $_SESSION['user_id'];
$stmt = $pdo->query("SELECT id FROM `patientes` WHERE user_id = $idu")->fetch();
echo "doctor $idd , patient ".$stmt['id'];
?>


