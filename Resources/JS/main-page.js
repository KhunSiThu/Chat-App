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


// Automatically refresh friend requests every 500ms
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../Controller/get-friReq.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = xhr.response;
                document.querySelector(".friReq-list-con").innerHTML = data;
            }
        }
    };

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();
}, 500);




// Search friend functionality
const addFriendBtn = document.querySelector(".add-friend-btn");
const searchFriendCon = document.querySelector(".searchFriend-con");

addFriendBtn.addEventListener("click", () => {
    themeModal.style.display = "none"; // Hide theme modal
    chatRoom.style.display = "none"; // Hide chat room
    document.querySelector('#search-link').click(); // Trigger search link
});

// Mobile phone view menu
const mainContainer = document.querySelector(".main-container");

const friReqShowBtn = document.querySelector(".friReq-show-btn");
const menuShowBtn = document.querySelector(".menu-show-btn");
const sidebar2 = document.querySelector("#sidebar2");
const sidebar3 = document.querySelector("#sidebar3");

// Handle menu visibility on mobile
menuShowBtn.addEventListener("click", () => {
    sidebar3.style.display = 'flex'; // Show the mobile sidebar
    sidebar2.style.display = "none"; // Hide the other sidebar
    document.querySelector("#sidebar3 .menu").style.display = "flex"; // Show the menu in sidebar

    document.querySelector(".phone-menu-close").addEventListener("click", () => {
        sidebar3.style.display = 'none'; // Hide the mobile sidebar
        sidebar2.style.display = "block"; // Show the original sidebar
    });

    theme.classList.add("phoneTheme"); // Add phone theme class

    const phoneTheme = document.querySelector(".phoneTheme");

    // Close sidebar when theme icon is clicked
    phoneTheme.addEventListener("click", () => {
        sidebar3.style.display = 'none'; // Hide sidebar
        mainContainer.style.display = "block"; // Show the main container
    });
});
