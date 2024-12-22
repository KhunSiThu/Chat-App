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


// Mobile 
const menuShowBtn = document.querySelector(".menu-show-btn");
const friListShowBtn = document.querySelector(".friListShowBtn");
const sidebar2 = document.querySelector("#main-page #sidebar2");
const sidebar3 = document.querySelector("#main-page #sidebar3");
const chatBox = document.querySelector("#chatBox");

menuShowBtn.addEventListener("click" , () => {
    sidebar2.style.display = 'none';
    sidebar3.style.display = 'flex';
    document.querySelector(".friReq-list-con").style.display = 'none';
});

friListShowBtn.addEventListener("click" , () => {
    sidebar2.style.display = 'none';
    sidebar3.style.display = 'flex';
    document.querySelector(".menu").style.display = 'none';
    document.querySelector(".menuCloseBtn").style.display = 'none';
    chatBox.style.display = "block";

});

document.querySelector(".menuCloseBtn").addEventListener("click" , () => {
    sidebar2.style.display = '';
    sidebar3.style.display = '';
    document.querySelector(".friReq-list-con").style.display = '';
    document.querySelector(".menu").style.display = '';
})

// document.querySelector(".friReqCloseBtn").addEventListener("click" , () => {
//     sidebar2.style.display = '';
//     sidebar3.style.display = 'none';
//     document.querySelector(".friReq-list-con").style.display = '';
//     document.querySelector(".menu").style.display = '';
// })

document.querySelector(".themeCloseBtn").addEventListener("click", () => {
    sidebar3.style.display = 'flex';
    document.querySelector(".customize-theme").style.display = 'none';
    document.querySelector(".main-container").style.display = "none";
    chatBox.style.display = "block";
})




