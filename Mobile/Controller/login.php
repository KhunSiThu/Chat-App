<?php

include_once "db_connect.php";

session_start();

$name_email = $_POST['name_email'];
$password = $_POST['password'];

if (filter_var($name_email, FILTER_VALIDATE_EMAIL)) {
    $sql = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $sql->bind_param("s", $name_email);
} else {
    $sql = $conn->prepare("SELECT * FROM users WHERE name = ?");
    $sql->bind_param("s", $name_email);
}

$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $uniqueId = $row['unique_id'];


    if (password_verify($password, $row['password'])) {

        $_SESSION['unique_id'] = $uniqueId;

        $stmt = $conn->prepare("UPDATE users SET status = 'Active now' WHERE unique_id = ?");
        $stmt->bind_param("i", $uniqueId);
        $stmt->execute();

        if($row['profile_image'] == null) {
            header("Location:../Views/upProfile.php");
        } else {
            header("Location:../Views/friendList.php");
        }

    } else {
        header("Location:../Views/form.php?pass=Password is incorrect!");
    }
} else {
    header("Location:../Views/form.php?user=$name_email - Not found user!");
}

$conn->close();
