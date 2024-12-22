<?php
session_start();

if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit();
}

$_SESSION['chooseFri'] = isset($_GET['chooseFri']) ? $_GET['chooseFri'] : null;

if (isset($_SESSION['chooseFri'])) {
    include_once "../Controller/db_connect.php";

    $chooseFri = $_SESSION['chooseFri'];

    $sql2 = "SELECT * FROM users WHERE unique_id = ?";
    $stmt = $conn->prepare($sql2);
    $stmt->bind_param("i", $chooseFri);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
?>

<?php require_once "../Components/header.php"; ?>

<section class="chat-room">
    
    <div class="flex justify-between chat-nav items-center">
    <a href="./friendList.php"><i class="fa-solid fa-arrow-left mr-4 text-2xl"></i></a>
        <div class="flex items-center fri-pro">
            <img class="pro border-color" src="../../Uploads/<?= htmlspecialchars($row['profile_image']) ?>" class="w-16 h-16 rounded-full border-color border-2 shrink-0" />
            <div class="ml-4">
                <h1 class="text-2xl whitespace-nowrap"><?= htmlspecialchars($row['name']) ?></h1>
                <p class="text-xs whitespace-nowrap <?= $row['status'] === "Active now" ? "active" : "text-muted"; ?>">
                    <?= $row['status'] === "Active now" ? "Active now" : "Off Line"; ?>
                </p>
            </div>
        </div>
        <i class="fa-solid fa-ellipsis-vertical text-2xl"></i>
    </div>

    <div class="chat-container"></div>

    <form id="send-message-form" action="#" class="flex justify-center chat-box" method="post">
        <input hidden name="uniqueId" id="send" type="text" value="<?= htmlspecialchars($uniqueId) ?>">
        <input hidden name="receive" id="receive" type="text" value="<?= htmlspecialchars($chooseFri) ?>">

        <div class="flex justify-between">
            <button class="sendImg-btn" type="button">
            <i class="fa-solid fa-photo-film"></i>
            </button>
            <input placeholder=" Write a message . . . " type="text" name="message" class="sendText">
        </div>

        <button class="send-message-btn" type="submit">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </form>
</section>

<?php
} else {
?>

<section class="no-chat-con">
    <div>
        <img src="../Images/chat.png" alt="">
        <h1>Chat!</h1>
    </div>
</section>

<?php } ?>

<script src="../Resources/JS/chat-room.js"></script>
<?php require_once "../Components/footer.php"; ?>