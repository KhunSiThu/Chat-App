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
}, 1000);

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
}, 1000);

// Search friend functionality
const addFriendBtn = document.querySelector(".add-friend-btn");
const searchFriendCon = document.querySelector(".searchFriend-con");
const mainContainer = document.querySelector(".main-container");
const searchText = document.querySelector(".searchText");
const searchBtn = document.querySelector(".searchBtn");
const allFriendList = document.querySelector(".allFriendList");

addFriendBtn.addEventListener("click", () => {
  searchFriendCon.style.display = "block";
  startSearchInterval("");
});

let searchInterval;

const startSearchInterval = (search) => {
  clearInterval(searchInterval);
  searchInterval = setInterval(() => {
    allFriendShow(search);
  }, 1000);
};

searchBtn.addEventListener("click", () => {
  clearInterval(searchInterval);
  startSearchInterval(searchText.value);
});

function allFriendShow(search) {
  let xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    "../Controller/getAllFriend.php?search=" + encodeURIComponent(search),
    true
  );
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const data = xhr.response;
        allFriendList.innerHTML = data; // Assuming response contains the list of friends

        // No need to initialize buttons, as event delegation will handle clicks
      }
    }
  };

  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send();
}

// Event delegation: listen for button clicks in the parent container
allFriendList.addEventListener("click", (e) => {
  if (e.target && e.target.matches(".requestBtn")) {
    const url = e.target.getAttribute("data");
    actionButton(url, e.target);
  } else if (e.target && e.target.matches(".confirmBtn")) {
    const url = e.target.getAttribute("data");
    actionButton(url, e.target);
  } else if (e.target && e.target.matches(".friendBtn")) {
    const url = e.target.getAttribute("data");
    actionButton(url, e.target);
  } else if (e.target && e.target.matches(".friReqBtn")) {
    const url = e.target.getAttribute("data");
    actionButton(url, e.target);
  }
});

const container = document.querySelector("#sidebar3");

container.addEventListener("click", (e) => {
  if (e.target && e.target.matches(".confirmBtn")) {
    const url = e.target.getAttribute("data");
    actionButton(url, e.target);
  }
});

function actionButton(url, button) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        console.log(xhr.response);
      }
    }
  };

  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send();
}

// Mobile
// const menuShowBtn = document.querySelector(".menu-show-btn");
// const friListShowBtn = document.querySelector(".friListShowBtn");
// const sidebar2 = document.querySelector("#main-page #sidebar2");
// const sidebar3 = document.querySelector("#main-page #sidebar3");
// const chatBox = document.querySelector("#chatBox");

// menuShowBtn.addEventListener("click", () => {
//   sidebar2.style.display = "none";
//   sidebar3.style.display = "flex";
//   document.querySelector(".friReq-list-con").style.display = "none";
// });

// friListShowBtn.addEventListener("click", () => {
//   sidebar2.style.display = "none";
//   sidebar3.style.display = "flex";
//   document.querySelector(".menu").style.display = "none";
//   document.querySelector(".menuCloseBtn").style.display = "none";
//   chatBox.style.display = "block";
// });

// document.querySelector(".menuCloseBtn").addEventListener("click", () => {
//   sidebar2.style.display = "";
//   sidebar3.style.display = "";
//   document.querySelector(".friReq-list-con").style.display = "";
//   document.querySelector(".menu").style.display = "";
// });

// document.querySelector(".themeCloseBtn").addEventListener("click", () => {
//   sidebar3.style.display = "flex";
//   document.querySelector(".customize-theme").style.display = "none";
//   document.querySelector(".main-container").style.display = "none";
//   chatBox.style.display = "block";
// });
