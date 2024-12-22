<?php
include_once "../Controller/db_connect.php";

session_start();

$uniqueId = isset($_SESSION['unique_id']) ? $_SESSION['unique_id'] : null;

// Get user profile image or default
$sql = "SELECT * FROM users WHERE unique_id = $uniqueId";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$defaultImage = "../Images/" . $row['gender'] . ".webp";
$profileImage = isset($row['profile_image']) ? $row['profile_image'] : $defaultImage;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Profile</title>
  <link rel="stylesheet" href="../Resources/CSS/output.css">
  <link rel="stylesheet" href="../Resources/CSS/mobile.css">
</head>

<style>
  body {
    .profile-con {

      width: 350px;
      height: 350px;
      ;

      button {
        width: 350px;
        opacity: 0;
        height: 350px;
        display: flex;
        justify-content: center;
        position: absolute;
        top: 0;
        color: white;
        font-size: 40px;
      }

      button:hover {
        background-color: rgba(0, 0, 0, 0.77);
        opacity: 1;
      }
    }
  }

  @media (max-width: 600px) {

    #desktop {
      display: none;
    }

    #mobile {
      display: block;
    }

    body {
      width: 100vw;
      height: 100vh;

      .profile-con {
        width: 250px;
        height: 250px;

        button {
          width: 250px;
        height: 250px;
        }
      }
    }



  }
</style>

<body>

  <!-- Profile Update Form -->
  <form enctype="multipart/form-data" action="../Controller/uploadProfileImg.php" method="POST" class="flex items-center justify-center w-screen h-screen">
    <!-- Profile Card -->
    <div class="p-10 relative">
      <h1 class="text-3xl font-bold text-center mb-8">Update Your Profile</h1>

      <!-- Profile Image -->
      <div class="flex p-6 justify-center mb-8">
        <div class="relative group profile-con">
          <!-- Profile Image -->
          <img id="profile-image"
            src="<?= $profileImage ?>"
            alt="Profile Image"
            class="rounded-full border-4 border-gray-300 shadow-lg object-cover transition-transform group-hover:scale-105"
            style="object-fit: cover; width: 100%; height: 100%;" />
          <input id="image-input" name="image" type="file" accept="image/*" class="hidden" />
          <button type="button" onclick="document.getElementById('image-input').click()"
            class="absolute bottom-0 right-0 text-black text-sm rounded-full shadow-md transition flex flex-col items-center justify-end pb-5">
            Change
          </button>
        </div>
      </div>


      <!-- Action Buttons -->
      <div class="flex justify-evenly gap-8 space-x-6 upProfile-btns">
        <button id="cancel-button" type="button" class="py-3 w-full bg-red-600 text-white rounded-lg text-lg font-medium shadow-md hover:bg-red-700 transition">Skip</button>
        <button type="submit" class="py-3 w-full text-white rounded-lg text-lg font-medium shadow-md transition bg-cyan-400 hover:bg-cyan-500">Confirm</button>
      </div>
    </div>
  </form>

  <!-- Cancel Button JS to Reset Form -->
  <script>
    document.getElementById("cancel-button").addEventListener("click", () => {
      document.getElementById("profile-image").src = "https://via.placeholder.com/200";
      document.getElementById("image-input").value = "";
    });

    // Handle image preview
    document.getElementById("image-input").addEventListener("change", (event) => {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          document.getElementById("profile-image").src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  </script>

</body>

</html>

<?php
$conn->close(); // Close database connection
?>