<?php 

$search = $_POST['search'];

echo $search;

if($search) {
    header("Location:../Views/mainPage.php?search=$search");
} else {
    header("Location:../Views/mainPage.php?");
}