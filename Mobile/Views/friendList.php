<?php
session_start();

if (isset($_GET["chooseFri"])) {
    $_SESSION["chooseFri"] = $_GET["chooseFri"];
}

include_once "../Controller/db_connect.php";  

$uniqueId = $_SESSION['unique_id'];
?>

<?php require_once "../Components/header.php"; ?>

<?php require_once "../Components/sidebar2.php"; ?>

<?php require_once "../Components/footer.php"; ?>