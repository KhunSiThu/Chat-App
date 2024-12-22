<?php

session_start();

include_once "db_connect.php";
$uniqueId = $_SESSION['unique_id'];

$sql = "select * from friendRequests left join users on users.unique_id = friendRequests.request_id where forConfirm_id = $uniqueId";
$Query = mysqli_query($conn, $sql);

$response = '
<h2>   <a href="" id="mobile"><i class="fa-solid fa-arrow-left mr-4 friReqCloseBtn"></i></a>       
 Friend Requests <span class="req-count" id="desktop">' . mysqli_num_rows($Query) . '</span>
</h2>

<a href="" id="chatBox">
    <span>Chat Box</span>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-16">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
    </svg>
</a>

<ul class="friReq-list side3FriReq w-full">
';

if (mysqli_num_rows($Query) > 0) {
    while ($friReq = mysqli_fetch_assoc($Query)) {
        $response .= '
         <li class="flex items-center cursor-pointer ">

            <a href="" class="flex items-center cursor-pointer w-full ">
                <div class="con mr-3">
                    <img src="../Uploads/' . $friReq['profile_image'] . '"
                        class="rounded-full border-color shrink-0 pro" />
                    <!-- <i class="fa-solid fa-circle active"></i> -->
                </div>
                <div class="ml-3">
                    <h1 class="whitespace-nowrap mb-1">' . $friReq['name'] . '</h1>
                    <p class="text-xs whitespace-nowrap text-muted ">Active free account</p>
                </div>
            </a>

            <button data ="../Controller/addFriend.php?friId=' . $friReq['unique_id'] . '" class=" btn-primary flex justify-center items-center confirmBtn">
                Confirm
            </button>

        </li>';
    }
}

echo $response .= '    
    </ul>';
