<?php 

$conn = mysqli_connect("localhost","khun","khun","chat_db");

if(!$conn) {
    echo mysqli_connect_error();
}