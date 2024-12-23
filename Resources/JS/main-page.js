let loading = "Loading . . .";

const menuShowBtn = document.querySelector(".menu-show-btn");
const friListShowBtn = document.querySelector(".friListShowBtn");
const sidebar2 = document.querySelector("#main-page #sidebar2");
const sidebar3 = document.querySelector("#main-page #sidebar3");

// User Friend List Section
const userFriendList = document.querySelector(".userFriendList");

// Refresh friend list every 1 second
setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../Controller/get-friend-list.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status == 200) {
      userFriendList.innerHTML = xhr.response;
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send();
}, 800);

// Handle click events on the friend list
userFriendList.addEventListener("click", (e) => {
  if (e.target && e.target.matches(".chooseFriBtn")) {
    const url = e.target.getAttribute("data");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        document.querySelector(".main-container").innerHTML = xhr.response;
        chatFunction();
      }
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();
  }

  if (e.target && e.target.matches(".mobChooseFriBtn")) {
    const url = e.target.getAttribute("data");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        mainContainer.style.display = "block";
        sidebar2.style.display = 'none';
        mainContainer.innerHTML = xhr.response;
        chatFunction();
      }
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();
  }
});

// Friend Requests Section
setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../Controller/get-friReq.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status == 200) {
      document.querySelector(".friReq-list-con").innerHTML = xhr.response;
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send();
}, 800);

// Search Friend Section
const addFriendBtn1 = document.querySelector(".deskAddFri");
const addFriendBtn2 = document.querySelector(".mobAddFri");
const mainContainer = document.querySelector(".main-container");
let searchInterval;

addFriendBtn1.addEventListener("click", () => {
  mainContainer.innerHTML = loading;
  startSearchInterval("");
});

addFriendBtn2.addEventListener("click", () => {
  mainContainer.style.display = "block";
  sidebar2.style.display = "none";
  mainContainer.innerHTML = loading;
  startSearchInterval("");
});

const startSearchInterval = (search) => {
  clearInterval(searchInterval);
  searchInterval = setInterval(() => allFriendShow(search), 800);
};

function allFriendShow(search) {
  let xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    "../Controller/getAllFriend.php?search=" + encodeURIComponent(search),
    true
  );
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      mainContainer.innerHTML = xhr.response;
      handleSearchAndActions();
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send();
}

function handleSearchAndActions() {
  const searchText = document.querySelector(".searchText");
  const searchBtn = document.querySelector(".searchBtn");
  const allFriendList = document.querySelector(".allFriendList");

  searchText.addEventListener("mouseover", () => clearInterval(searchInterval));
  searchBtn.addEventListener("click", () => {
    allFriendList.innerHTML = loading;
    clearInterval(searchInterval);
    startSearchInterval(searchText.value);
  });

  allFriendList.addEventListener("click", (e) => {
    if (e.target.matches(".requestBtn, .confirmBtn, .friendBtn, .friReqBtn")) {
      e.target.style.display = "none";
      const url = e.target.getAttribute("data");
      actionButton(url);
    }
  });
}

function actionButton(url) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      console.log(xhr.response);
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send();
}

// Sidebar Actions Section
const container = document.querySelector("#sidebar3");

container.addEventListener("click", (e) => {
  if (e.target && e.target.matches(".confirmBtn")) {
    const url = e.target.getAttribute("data");
    actionButton(url);
  }
});

// chat function

function chatFunction() {
  clearInterval(searchInterval);

  const sendMessageForm = document.querySelector("#send-message-form");
  const sendMessageBtn = document.querySelector(".send-message-btn");
  const receiveId = document.querySelector("#receive").value;
  const uniqueId = document.querySelector("#send").value;
  const chatContainer = document.querySelector(".chat-container");
  const sendTextInput = document.querySelector(".sendText");

  function scrollToBottom() {
    chatContainer.scrollTop = chatContainer.scrollHeight;
  }

  sendMessageForm.onsubmit = (e) => {
    e.preventDefault(); // Prevent form from reloading the page
  };

  sendMessageBtn.onclick = (e) => {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../../Controller/send-message.php", true);

    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        console.log("Response Status:", xhr.status); // Log status
        console.log("Response Text:", xhr.responseText); // Log response text

        if (xhr.status === 200) {
          sendTextInput.value = ""; // Clear input
          fetchMessages(); // Fetch updated messages
        } else {
          console.error("Message send failed:", xhr.responseText); // Log server error
        }
      }
    };

    const formData = new FormData(sendMessageForm);
    xhr.send(formData);
  };

  const fetchMessages = () => {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../Controller/get-messages.php", true);

    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        const newMessages = xhr.responseText.trim(); // Get response text
        if (chatContainer.innerHTML.trim() !== newMessages) {
          chatContainer.innerHTML = newMessages; // Update chat container only if there are new messages
          scrollToBottom(); // Scroll to the bottom on new messages
        }
      } else {
        console.error("Failed to fetch messages:", xhr.statusText);
      }
    };

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("receive_id=${receiveId}&uniqueId=${uniqueId}"); // Send user IDs to server
  };

  // Fetch messages every 500ms
  const intervalId = setInterval(fetchMessages, 500);

  // Optional: Stop updating messages when the user navigates away
  window.addEventListener("beforeunload", () => clearInterval(intervalId));
}

// Theme

// Theme customization logic
const theme = document.querySelector("#theme");
const mobTheme = document.querySelector("#mobTheme");
const themeModal = document.querySelector(".customize-theme");
const fontSizes = document.querySelectorAll(".fontSize");
var root = document.querySelector(":root");

const chatRoom = document.querySelector(".chat-room");

// Function to apply background color changes
const changeBG = () => {
  root.style.setProperty("--light-color-lightness", lightColorLightness);
  root.style.setProperty("--white-color-lightness", whiteColorLightness);
  root.style.setProperty("--dark-color-lightness", darkColorLightness);
};

// Checking for saved theme settings in localStorage and applying them
if (localStorage.getItem("primaryHue")) {
  root.style.setProperty(
    "--primary-color-hue",
    localStorage.getItem("primaryHue")
  );
}

if (localStorage.getItem("dark")) {
  darkColorLightness = localStorage.getItem("dark");
  whiteColorLightness = localStorage.getItem("white");
  lightColorLightness = localStorage.getItem("light");
  changeBG();
}

// Open the theme customization modal
const openThemeModal = () => {
  clearInterval(searchInterval);

  mainContainer.innerHTML = `
    
    <div class="customize-theme">

    <a href="" id="chatBox">
        <span>Chat Box</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-14">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
        </svg>
    </a>

    
    <div class="card">
        <h2>Customize your view <button class="themeCloseBtn" id="mobile"><i class="fa-solid fa-bars"></i></button></h2>
      

        <div class="font-size s">
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

        <div class="color s">
            <h4>Color</h4>
            <div class="choose-color">
                <span class="color-1 active"></span>
                <span class="color-2"></span>
                <span class="color-3"></span>
                <span class="color-4"></span>
                <span class="color-5"></span>
            </div>
        </div>

        <div class="background s">
            <h4>Background</h4>
            <div class="choose-bg">

                <div class="bg-1 active">
                   
                    <h5 for="bg-1">Light</h5>
                </div>
                <div class="bg-2">
                   
                    <h5 for="bg-2">Dim</h5>
                </div>
                <div class="bg-3">
                    
                    <h5 for="bg-3">Dark</h5>
                </div>

            </div>
        </div>
    </div>
</div>
    
    `;

  themeFunction();
};

theme.addEventListener("click", openThemeModal);
mobTheme.addEventListener("click", () => {
  mainContainer.style.display = "block";
  openThemeModal();
  sidebar3.style.display = "none";
})

function themeFunction() {
  // Close the theme customization modal
  const closeThemeModal = (e) => {
    if (e.target.classList.contains("customize-theme")) {
      themeModal.style.display = "none";
      // chatRoom.style.display = "block"; // Optional: Show chat room again after modal closes
    }
  };

  document.querySelector(".themeCloseBtn").addEventListener("click", () => {
  sidebar3.style.display = "flex";
  document.querySelector(".customize-theme").style.display = "none";
  document.querySelector(".main-container").style.display = "none";
  chatBox.style.display = "block";
});

  const colorPalette = document.querySelectorAll(".choose-color span");
  const Bg1 = document.querySelector(".bg-1");
  const Bg2 = document.querySelector(".bg-2");
  const Bg3 = document.querySelector(".bg-3");

  // themeModal.addEventListener("click", closeThemeModal);

  mobTheme.addEventListener("click", () => {
    openThemeModal();
    document.querySelector(".main-container").style.display = "block";
    document.querySelector("#main-page #sidebar3").style.display = "none";
  });

  // Function to remove the active class from all font size selectors
  const removeSizeSelector = () => {
    fontSizes.forEach((size) => {
      size.classList.remove("active");
    });
  };

  // Function to remove active color class
  const changeActiveColorClass = () => {
    colorPalette.forEach((color) => {
      color.classList.remove("active");
    });
  };

  // Event listener for color palette selection
  colorPalette.forEach((color) => {
    color.addEventListener("click", () => {
      let primaryHue;

      changeActiveColorClass();

      // Determine the primary color based on the selected color class
      if (color.classList.contains("color-1")) {
        primaryHue = 252;
      } else if (color.classList.contains("color-2")) {
        primaryHue = 52;
      } else if (color.classList.contains("color-3")) {
        primaryHue = 352;
      } else if (color.classList.contains("color-4")) {
        primaryHue = 152;
      } else if (color.classList.contains("color-5")) {
        primaryHue = 202;
      }

      color.classList.add("active");

      // Store selected color in localStorage
      localStorage.setItem("primaryHue", primaryHue);
      root.style.setProperty("--primary-color-hue", primaryHue);
    });
  });

  // Event listener for background change
  Bg1.addEventListener("click", () => {
    localStorage.removeItem("dark");
    localStorage.removeItem("white");
    localStorage.removeItem("light");

    Bg1.classList.add("active");
    Bg2.classList.remove("active");
    Bg3.classList.remove("active");
    window.location.reload(); // Refresh the page to apply changes
    changeBG();
  });

  Bg2.addEventListener("click", () => {
    darkColorLightness = "95%";
    whiteColorLightness = "20%";
    lightColorLightness = "15%";

    // Store background color settings in localStorage
    localStorage.setItem("dark", "95%");
    localStorage.setItem("white", "20%");
    localStorage.setItem("light", "15%");

    Bg1.classList.remove("active");
    Bg2.classList.add("active");
    Bg3.classList.remove("active");
    changeBG();
  });

  Bg3.addEventListener("click", () => {
    darkColorLightness = "95%";
    whiteColorLightness = "10%";
    lightColorLightness = "0%";

    // Store background color settings in localStorage
    localStorage.setItem("dark", "95%");
    localStorage.setItem("white", "10%");
    localStorage.setItem("light", "0%");

    Bg1.classList.remove("active");
    Bg2.classList.remove("active");
    Bg3.classList.add("active");
    changeBG();
  });
}
