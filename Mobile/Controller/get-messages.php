<?php

session_start();

if (isset($_SESSION['unique_id'])) {

    include_once "db_connect.php";
    $uniqueId = $_SESSION['unique_id'];
    $chooseFri = $_SESSION['chooseFri'];

    $sql = "SELECT * FROM messages
            LEFT JOIN users ON users.unique_id = messages.send_id
            WHERE (receive_id = ? AND send_id = ?) OR (receive_id = ? AND send_id = ?)
            ORDER BY message_id";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "iiii", $chooseFri, $uniqueId, $uniqueId, $chooseFri);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $response = '';

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $messageTime = date("d M h:i A", strtotime($row['create_at']));
                $profileImage ="../../Uploads/". htmlspecialchars($row['profile_image']);
                $userName = htmlspecialchars($row['name']);
                $messageText = htmlspecialchars($row['message']);
                
                if ($row['send_id'] == $uniqueId) {
                    $response .= "
                    <div class='chat chat-end mb-3'>
                        <div class='chat-image avatar'>
                            <div class='w-8 rounded-full'>
                                <img alt='Tailwind CSS chat bubble component' src='$profileImage' />
                            </div>
                        </div>
                        <div class='chat-header text-muted text-x'>$userName</div>
                        <div class='chat-bubble my-1 text-xl messText'>$messageText</div>
                        <time class='text-xs opacity-50 '>$messageTime</time>
                    </div>";
                } else {
                    $response .= "
                    <div class='chat chat-start mb-3'>
                        <div class='chat-image avatar'>
                            <div class='w-8 rounded-full'>
                                <img alt='Tailwind CSS chat bubble component' src='$profileImage' />
                            </div>
                        </div>
                        <div class='chat-header text-muted text-xs'>$userName</div>
                        <div class='chat-bubble my-1 text-xl messText'>$messageText</div>
                    </div>
                    <time class='text-xs opacity-50 '>$messageTime</time>";
                }
            }
        }

        mysqli_stmt_close($stmt);
        echo $response;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "User not logged in.";
}
?>
