

// Search friend functionality
const addFriendBtn = document.querySelector(".add-friend-btn");
const searchFriendCon = document.querySelector(".searchFriend-con");

addFriendBtn.addEventListener("click", () => {
    themeModal.style.display = "none"; // Hide theme modal
    chatRoom.style.display = "none"; // Hide chat room
    document.querySelector('#search-link').click(); // Trigger search link
});

const friReqShowBtn = document.querySelector(".friReq-show-btn");
const menuShowBtn = document.querySelector(".menu-show-btn");
const sidebar2 = document.querySelector("#sidebar2");
const sidebar3 = document.querySelector("#sidebar3");

// Handle menu visibility on mobile
menuShowBtn.addEventListener("click", () => {
    sidebar3.style.display = 'flex'; // Show the mobile sidebar
    sidebar2.style.display = "none"; // Hide the other sidebar

    document.querySelector(".menuCloseBtn").addEventListener("click", () => {
        sidebar3.style.display = 'none'; // Hide the mobile sidebar
        sidebar2.style.display = "block"; // Show the original sidebar
    });

    theme.classList.add("phoneTheme"); // Add phone theme class

    const phoneTheme = document.querySelector(".phoneTheme");

    // Close sidebar when theme icon is clicked
    phoneTheme.addEventListener("click", () => {
       
        
    });
});
