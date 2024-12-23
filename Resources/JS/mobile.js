// Mobile

// const menuShowBtn = document.querySelector(".menu-show-btn");
// const friListShowBtn = document.querySelector(".friListShowBtn");
// const sidebar2 = document.querySelector("#main-page #sidebar2");
// const sidebar3 = document.querySelector("#main-page #sidebar3");
// const chatBox = document.querySelector("#chatBox");

menuShowBtn.addEventListener("click", () => {
  sidebar2.style.display = "none";
  sidebar3.style.display = "flex";
  document.querySelector(".friReq-list-con").style.display = "none";
});

friListShowBtn.addEventListener("click", () => {
  sidebar2.style.display = "none";
  sidebar3.style.display = "flex";
  document.querySelector(".menu").style.display = "none";
  document.querySelector(".menuCloseBtn").style.display = "none";
  // chatBox.style.display = "block";
});

document.querySelector(".menuCloseBtn").addEventListener("click", () => {
  sidebar2.style.display = "";
  sidebar3.style.display = "";
  document.querySelector(".friReq-list-con").style.display = "";
  document.querySelector(".menu").style.display = "";
});

