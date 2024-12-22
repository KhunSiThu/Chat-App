
<nav id="sidebar2" class="desk-side-2 transition-all duration-500 z-[100] mobFriendList">
    <div class="side2-header flex justify-between">
        <div class="flex items-center justify-between">
            <a href="javascript:void(0)" class="flex items-center gap-2 log-con">
                <img src="../Images/chat.png" alt="">
                <h1 id="h1" class=" text-base font-semibold tracking-wide">Chat!</h1>
            </a>
        </div>
        <div class="mob-menu-btns" id="mobile">
            <button class="friListShowBtn" href="../mobile/friendRequestMob.php">
                <i class="fa-solid fa-user-group"></i>
            </button>

            <button class="ml-5 menu-show-btn">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </div>

    <hr id="hr" />

    <div class="friList-con">
        <ul class="friend-list mt-1">
           
        </ul>
    </div>

    <!-- Add Friend Button -->
    <button class="add-friend-btn btn-primary">
        <i class="fa-solid fa-user-plus"></i>
    </button>

</nav>

<?php
include_once "../Controller/db_connect.php";  
session_start();

// Check if the user is logged in
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit;
}

$uniqueId = $_SESSION['unique_id']; // Make sure unique_id is coming from the session

// Prepared SQL query to fetch the logged-in user's data
$sql3 = "SELECT * FROM users WHERE unique_id = ?";
$stmt = $conn->prepare($sql3);
$stmt->bind_param("i", $uniqueId); // Bind the unique_id parameter
$stmt->execute();
$result = $stmt->get_result();
$youData = $result->fetch_assoc();

?>
