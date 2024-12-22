<?php
include_once "../Controller/db_connect.php";  

session_start();

$uniqueId = isset($_SESSION['unique_id']) ? $_SESSION['unique_id'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {

    $image = $_FILES['image'];

    if ($image['error'] === 0) {

        $fileTmpPath = $image['tmp_name'];
        $fileName = $image['name'];
        $fileSize = $image['size'];
        $fileType = $image['type'];

        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        
        $allowedMimeTypes = [
            'image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff', 'image/webp',
            'image/jpg', 'image/x-icon'
        ];

        if (in_array(strtolower($fileType), $allowedMimeTypes)) {

            $newFileName = uniqid() . '.' . $fileExtension;

            $uploadDir = '../../Uploads/';
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destination)) {

                $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE unique_id = ?");
                $stmt->bind_param("ss",$newFileName, $uniqueId);

                if ($stmt->execute()) {
                    header("Location:../Views/friendList.php");
                } else {
                    echo "Error updating profile image.";
                }

                $stmt->close();
            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            echo "Invalid file type. Only image files are allowed.";
        }
    } else {
        echo "Error uploading the file.";
    }
}
?>
