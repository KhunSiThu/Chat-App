<?php
include_once "./db_connect.php";

session_start();

// Ensure uniqueId is set, if not, redirect to login
$uniqueId = $_SESSION['unique_id'] ?? null;
if (!$uniqueId) {
    header("Location: ../login.php");
    exit;
}

// Query to get friend list
$sql1 = "SELECT * FROM `friendList` 
         LEFT JOIN users ON users.unique_id = friendList.request OR users.unique_id = friendList.confirm 
         WHERE (request = $uniqueId OR confirm = $uniqueId) 
         ORDER BY name;";

$Query1 = mysqli_query($conn, $sql1);

$response = '';

while ($allUser = mysqli_fetch_assoc($Query1)) {
    // Avoid showing current user's own data
    if ($allUser['unique_id'] != $uniqueId) {
        // Check if user is active
        $statusIcon = '';
        if ($allUser['status'] === "Active now") {
            $statusIcon = '<i class="fa-solid fa-circle pointer-events-none active"></i>';
        }

        $sql = "SELECT * FROM messages
                LEFT JOIN users ON users.unique_id = messages.send_id
                WHERE (receive_id = ? AND send_id = ?) OR (receive_id = ? AND send_id = ?)
                ORDER BY message_id DESC LIMIT 1";


        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "iiii", $allUser['unique_id'], $uniqueId, $uniqueId, $allUser['unique_id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $lastMessage = mysqli_fetch_assoc($result);

            $howMess = $lastMessage['unique_id'] == $uniqueId ? "You" : $lastMessage["name"];
        }

        $profileImage = !empty($allUser['profile_image']) ? '../Uploads/' . $allUser['profile_image'] : './images/default-profile.png';

        // Constructing the list item
        $response .= '
        <li class="flex items-center cursor-pointer">
            <a id="desktop" href="#" data ="../Controller/chatRoom.php?chooseFri=' . $allUser['unique_id'] . '" class="flex items-center w-full chooseFriBtn ">
                <div class="con pointer-events-none">
                    <img src="' . $profileImage . '" class="rounded-full border-color shrink-0 pro pointer-events-none" />
                    ' . $statusIcon . '
                </div>
                <div class="ml-3 pointer-events-none">
                    <h1 class="whitespace-nowrap pointer-events-none">' . $allUser['name'] . '</h1>
                    <p class="text-xs whitespace-nowrap text-muted pointer-events-none">' . $howMess . ' : ' . $lastMessage["message"] . '</p>
                </div>
            </a>

            <a id="mobFlex" href="#" data ="../Controller/chatRoom.php?chooseFri=' . $allUser['unique_id'] . '" class="flex items-center w-full mobChooseFriBtn ">
                <div class="con pointer-events-none">
                    <img src="' . $profileImage . '" class="rounded-full border-color shrink-0 pro pointer-events-none" />
                    ' . $statusIcon . '
                </div>
                <div class="ml-3 pointer-events-none">
                    <h1 class="whitespace-nowrap pointer-events-none">' . $allUser['name'] . '</h1>
                    <p class="text-xs whitespace-nowrap text-muted pointer-events-none">' . $howMess . ' : ' . $lastMessage["message"] . '</p>
                </div>
            </a>

            <button class="fri-control">
                <i class="fa-solid fa-ellipsis-vertical text-2xl"></i>
            </button>
        ';
    }
}

// Echo the response at the end
echo $response;
