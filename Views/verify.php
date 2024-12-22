<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

include_once "../Controller/db_connect.php";

session_start();

// Check if the user is logged in
if (!isset($_SESSION["unique_id"])) {
  die("You must be logged in to perform this action.");
}

// Get the user's email and other info
$sql = $conn->prepare("SELECT * FROM users WHERE unique_id = ?");
$sql->bind_param("i", $_SESSION["unique_id"]);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();

if (isset($_GET['sendCode'])) {
  $varifiyCode = $_POST['c1'].$_POST['c2'].$_POST['c3'].$_POST['c4'];

  if($row["unique_id"]==$varifiyCode) {
    header("Location:./form.php");
  } 
}

if (!isset($_GET['sendCode'])) {

  require "../Resources/sendEmail/vendor/autoload.php";

  $mail = new PHPMailer(true);

  // Configure SMTP
  $mail->isSMTP();
  $mail->SMTPAuth = true;
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587;

  $mail->Username = "khunsithuaung65@gmail.com";
  $mail->Password = "ofjj efyh xizt bgzf";

  // Sender and recipient details
  $mail->setFrom($row['email'], "Chat App");
  $mail->addAddress($row['email']);

  // Email content
  $verificationCode = $row["unique_id"]; // Generate a random verification code
  $mail->Subject = "Account Verification";
  $mail->Body = "Hello {$row['name']},\n\nYour verification code is: $verificationCode\n\nPlease use this code to complete your account verification.";

  $mail->send();

} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OTP Verification Form</title>
  <!-- Tailwind CSS -->

  <link rel="stylesheet" href="../Resources/CSS/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <script src="../Resources/JS/verify.js" defer></script>

  <style>
    form form button {
      pointer-events: none;
    }

    p {
      opacity: 0.5;
    }

    form button.active {
      background: #4070f4;
      pointer-events: auto;
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center">
  <div class="space-y-8 flex flex-col items-center justify-center">
    <header
      class="  text-7xl rounded-full flex items-center justify-center">
      <i class="fa-solid fa-envelope-open-text fa-bounce"></i>
    </header>
    <h4 class="text-xl font-medium text-gray-800">Verification Code</h4>
    <p class="text-center ">Please enter 4 digit verification code we sent to <br><?= $row['email'] ?></p>
    <form action="./verify.php?sendCode='varify'" method="post">
      <div class="flex space-x-2">
        <input name="c1"
          type="text"
          class="size-14 rounded-lg text-center border border-gray-300 focus:ring-1 focus:ring-blue-500 text-lg" />
        <input name="c2"
          type="text"
          disabled
          class="size-14  rounded-lg text-center border border-gray-300 focus:ring-1 focus:ring-blue-500 text-lg" />
        <input name="c3"
          type="text"
          disabled
          class="size-14  rounded-lg text-center border border-gray-300 focus:ring-1 focus:ring-blue-500 text-lg" />
        <input name="c4"
          type="text"
          disabled
          class="size-14  rounded-lg text-center border border-gray-300 focus:ring-1 focus:ring-blue-500 text-lg" />
      </div>
      <button
        type="submit"
        class="mt-10 w-full bg-blue-400 text-white text-lg py-2 rounded-lg hover:bg-blue-500 transition-all disabled:bg-blue-300">
        Verify OTP
      </button>
    </form>
  </div>
</body>

</html>


