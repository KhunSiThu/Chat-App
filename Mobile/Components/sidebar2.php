<nav id="sidebar2" class="desk-side-2 transition-all duration-500 z-[100]">
    <div class="side2-header flex justify-between">
        <div class="flex items-center justify-between">
            <a href="javascript:void(0)" class="flex items-center gap-2 log-con">
                <img src="../Images/chat.png" alt="">
                <h1 class="text-base font-semibold tracking-wide">Chat!</h1>
            </a>
        </div>

        <div class="mob-menu-btns">
            <a href="../mobile/friendRequestMob.php">
                <i class="fa-solid fa-user-group"></i>
            </a>

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
    <a href="../Views/searchFriend.php?search" class="add-friend-btn btn-primary">
        <i class="fa-solid fa-user-plus"></i>
    </a>

</nav>

<?php
include_once "../Controller/db_connect.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION['unique_id'])) {
    header("location: form.php");
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

<nav id="sidebar3" class="transition-all duration-500 z-[100]">

    <button class="menuCloseBtn"><i class="fa-solid fa-xmark text-3xl fa-fade"></i></button>

    <ul class="menu rounded-box w-full" id="phone-menu">

        <li class="items-center user-profile flex justify-between flex-row">
            <a>
                <img src="../../Uploads/<?= htmlspecialchars($youData['profile_image']) ?>" class="rounded-full border-color shrink-0 pro" />

                <div class="ml-4">
                    <h1 class="text-2xl whitespace-nowrap"><?= htmlspecialchars($youData['name']) ?></h1>
                    <p class="text-xs whitespace-nowrap text-muted"><?= htmlspecialchars($youData['email']) ?></p>
                </div>
            </a>
        </li>

        <!-- Friends Link -->
        <li>
            <a>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                Friends
            </a>
        </li>

        <!-- Edit Profile Link -->
        <li>
            <a>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                Edit Profile
            </a>
        </li>

        <!-- Theme Links -->
        <li class="phone-dis-none">
            <a id="theme">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                </svg>
                Theme Settings
            </a>
        </li>

        <!-- Logout Links -->
        <li class="">
            <a href="../Controller/logout.php">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                </svg>

                Logout
            </a>
        </li>

    </ul>
</nav>

<div class="customize-theme">
    
    <div class="card">
        <h2>Customize your view</h2>
        <p class="text-muted">Manage your font size, color, and background.</p>

        <div class="font-size">
            <h4>Font Size</h4>
            <div>
                <h6>Aa</h6>
                <div class="choose-size">
                    <span class="font-size-1 fontSize"></span>
                    <span class="font-size-2 fontSize active"></span>
                    <span class="font-size-3 fontSize"></span>
                    <span class="font-size-4 fontSize"></span>
                    <span class="font-size-5 fontSize"></span>
                </div>
                <h3>Aa</h3>
            </div>
        </div>

        <div class="color">
            <h4>Color</h4>
            <div class="choose-color">
                <span class="color-1 active"></span>
                <span class="color-2"></span>
                <span class="color-3"></span>
                <span class="color-4"></span>
                <span class="color-5"></span>
            </div>
        </div>

        <div class="background">
            <h4>Background</h4>
            <div class="choose-bg">

                <div class="bg-1 active">
                    <span></span>
                    <h6 for="bg-1">Light</h6>
                </div>
                <div class="bg-2">
                    <span></span>
                    <h6 for="bg-2">Dim</h6>
                </div>
                <div class="bg-3">
                    <span></span>
                    <h6 for="bg-3">Lights</h6>
                </div>

            </div>
        </div>
    </div>
</div>


<script>

    // Automatically refresh friend list every 500ms
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../Controller/get-friend-list.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = xhr.response;
                document.querySelector(".friend-list").innerHTML = data;
            }
        }
    };

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();
}, 500);

</script>



