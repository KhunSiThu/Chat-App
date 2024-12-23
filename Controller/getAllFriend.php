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
            $actionButton = '<button id="" data ="../Controller/friendRequest.php?friendId=' . $allUser['unique_id'] . '" class="btn-primary requestBtn">Request</button>';
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

$section = '

<a href="" id="chatBox" class="chatBox">
    <span>Chat Box</span>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-16">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
    </svg>
</a>

<div class="searchFriend-con">
    <div class="searchFriend">
        <div class="search-con">
            <form action="#" class="searchForm flex justify-between relative my-6 p-3 rounded-md border border-color">
                <input class="text-sm outline-none bg-transparent px-1 w-[330px] searchText" placeholder="Search Friends ..." name="search" value="" />
                <button type="button" class="searchBtn">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                </button>
            </form>
        </div>

        <div class="friList-con">
            <ul class="friend-list allFriendList mt-5">
                '.$response.'
            </ul>
        </div>
    </div>
</div>
';

echo $section;
