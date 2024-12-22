<?php
include_once "./db_connect.php";

session_start();

$search = isset($_GET["search"]) ? $_GET["search"] : '';
$uniqueId = $_SESSION['unique_id'];

$sql = "SELECT users.*, 
            (SELECT 'Request' FROM friendRequests WHERE request_id = ? AND forConfirm_id = users.unique_id LIMIT 1) AS request_status,
            (SELECT 'Confirm' FROM friendRequests WHERE forConfirm_id = ? AND request_id = users.unique_id LIMIT 1) AS confirm_status,
            (SELECT 'Friend' FROM friendList WHERE (request = ? AND confirm = users.unique_id) OR (confirm = ? AND request = users.unique_id) LIMIT 1) AS friend_status
        FROM users
        WHERE unique_id != ? AND (name LIKE ? OR ? = '')";

$stmt = $conn->prepare($sql);
$searchTerm = "%" . $search . "%";
$stmt->bind_param("iiiisss", $uniqueId, $uniqueId, $uniqueId, $uniqueId, $uniqueId, $searchTerm, $search);
$stmt->execute();
$result = $stmt->get_result();

$response = "";

while ($allUser = $result->fetch_assoc()) {
    $status = $allUser['request_status'] ?: ($allUser['confirm_status'] ?: ($allUser['friend_status'] ?: 'Add'));

    $actionButton = '';
    switch ($status) {
        case 'Request':
            $actionButton = '<button id="" data ="../Controller/friendRequest.php?friendId=' . $allUser['unique_id'].'" class="btn-primary requestBtn">Request</button>';
            break;
        case 'Confirm':
            $actionButton = '<button id="" data ="../Controller/addFriend.php?friId=' . $allUser['unique_id'] . '" class="btn-primary confirmBtn">Confirm</button>';
            break;
        case 'Friend':
            $actionButton = '<button id="" data ="../Controller/addFriend.php?friId=' . $allUser['unique_id'] . '" class="btn-primary friendBtn">Unfriend</button>';
            break;
        default:
            $actionButton = '<button id="" data ="../Controller/friendRequest.php?friendId=' . $allUser['unique_id'] . '" class="btn-primary friReqBtn">Add Friend</button>';
            break;
    }

    $response .= '
    <li class="flex items-center justify-between cursor-pointer">
        <div class="flex items-center">
            <img src="../Uploads/' . htmlspecialchars($allUser['profile_image']) . '" class="rounded-full border-color shrink-0 pro" />
            <div class="ml-3">
                <h1 class="text-sm whitespace-nowrap mb-1">' . htmlspecialchars($allUser['name']) . '</h1>
                <p class="text-xs whitespace-nowrap text-muted">Active free account</p>
            </div>
        </div>
        ' . $actionButton . '
    </li>';
}

echo $response;
?>

