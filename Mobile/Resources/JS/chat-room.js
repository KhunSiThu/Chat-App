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
  e.preventDefault();
};

sendMessageBtn.onclick = () => {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "../Controller/send-message.php", true);

  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      sendTextInput.value = "";  // Clear input field after sending message
    }
  };

  const formData = new FormData(sendMessageForm);
  xhr.send(formData);
  scrollToBottom();  // Scroll to the bottom after sending the message
};

const fetchMessages = () => {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "../Controller/get-messages.php", true);

  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      chatContainer.innerHTML = xhr.responseText;  // Update chat container with new messages
      scrollToBottom();  // Scroll to the bottom on new messages
    }
  };

  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(`receive_id=${receiveId}&uniqueId=${uniqueId}`);
};

// Update messages every 500ms
setInterval(fetchMessages, 500);
