<?php
session_start();

if (!isset($_SESSION['unique_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['chooseFri']) && is_numeric($_GET['chooseFri'])) {
    include_once "./db_connect.php";

    $chooseFri = intval($_GET['chooseFri']); // Ensure it's an integer

    $_SESSION['chooseFri'] = $_GET['chooseFri'];

    $sql2 = "SELECT * FROM users WHERE unique_id = ?";
    $stmt = $conn->prepare($sql2);

    if ($stmt) {
        $stmt->bind_param("i", $chooseFri);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            // Prepare user data securely
            $profileImage = htmlspecialchars($row['profile_image']);
            $name = htmlspecialchars($row['name']);
            $status = htmlspecialchars($row['status']);
            $statusClass = $status === "Active now" ? "active" : "text-muted";
            $statusText = $status === "Active now" ? "Active now" : "Off Line";


            $response = '
            <section class="chat-room">
                <div class="flex justify-between chat-nav items-center">
                    <a id="mobile" href=""><i class="fa-solid fa-chevron-left text-2xl"></i></a>
                    <div class="flex items-center chatPro-con">
                        <img class="pro border-color" src="../Uploads/' . $profileImage . '" class="w-16 h-16 rounded-full border-color border-2 shrink-0" />
                        <div class="ml-4">
                            <h1 class="text-2xl whitespace-nowrap">' . $name . '</h1>
                            <p class="text-xs whitespace-nowrap ' . $statusClass . '">' . $statusText . '</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-ellipsis-vertical text-2xl"></i>
                </div>

                <div class="chat-container p-10"></div>

                <form id="send-message-form" action="#" class="flex justify-center chat-box" method="post">
                    <input hidden name="uniqueId" id="send" type="text" value="' . htmlspecialchars($_SESSION['unique_id']) . '">
                    <input hidden name="receive" id="receive" type="text" value="' . $chooseFri . '">
                    <div class="flex justify-between">
                        <button class="sendImg-btn" type="button">
                            <i class="fa-solid fa-photo-film"></i>
                        </button>
                        <input placeholder=" Write a message . . . " type="text" name="message" class="sendText">
                    </div>
                    <button class="send-message-btn" id="send-message-btn" type="button">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </section>';

            echo $response;
        } else {
            echo "<p>User not found.</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Error preparing statement.</p>";
    }

    $conn->close();
} else {
    echo "<p>Invalid user selection.</p>";
}
?>
