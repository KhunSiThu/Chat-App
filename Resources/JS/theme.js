// Theme customization logic
const theme = document.querySelector("#theme");
const mobTheme = document.querySelector("#mobTheme");
const themeModal = document.querySelector(".customize-theme");
const fontSizes = document.querySelectorAll(".fontSize");
var root = document.querySelector(":root");
const colorPalette = document.querySelectorAll(".choose-color span");
const Bg1 = document.querySelector(".bg-1");
const Bg2 = document.querySelector(".bg-2");
const Bg3 = document.querySelector(".bg-3");
const chatRoom = document.querySelector(".chat-room");

// Function to apply background color changes
const changeBG = () => {
    root.style.setProperty('--light-color-lightness', lightColorLightness);
    root.style.setProperty('--white-color-lightness', whiteColorLightness);
    root.style.setProperty('--dark-color-lightness', darkColorLightness);
}

// Checking for saved theme settings in localStorage and applying them
if (localStorage.getItem("primaryHue")) {
    root.style.setProperty('--primary-color-hue', localStorage.getItem("primaryHue"));
}

if(localStorage.getItem("dark")) {
    darkColorLightness = localStorage.getItem("dark");
    whiteColorLightness = localStorage.getItem("white");
    lightColorLightness = localStorage.getItem("light");
    changeBG();
}

// Open the theme customization modal
const openThemeModal = () => {
    themeModal.style.display = "grid";
    // chatRoom.style.display = "none"; // Optional: Hide chat room when theme modal is open
}

// Close the theme customization modal
const closeThemeModal = (e) => {
    if (e.target.classList.contains("customize-theme")) {
        themeModal.style.display = "none";
        // chatRoom.style.display = "block"; // Optional: Show chat room again after modal closes
    }
}

themeModal.addEventListener("click", closeThemeModal);
theme.addEventListener("click", openThemeModal);
mobTheme.addEventListener("click", () => {
    openThemeModal();
    document.querySelector(".main-container").style.display = "block";
    document.querySelector("#main-page #sidebar3").style.display = "none";
})

// Function to remove the active class from all font size selectors
const removeSizeSelector = () => {
    fontSizes.forEach(size => {
        size.classList.remove('active');
    });
}

// Function to remove active color class
const changeActiveColorClass = () => {
    colorPalette.forEach(color => {
        color.classList.remove("active");
    });
}

// Event listener for color palette selection
colorPalette.forEach(color => {
    color.addEventListener('click', () => {
        let primaryHue;

        changeActiveColorClass();

        // Determine the primary color based on the selected color class
        if (color.classList.contains('color-1')) {
            primaryHue = 252;
        } else if (color.classList.contains('color-2')) {
            primaryHue = 52;
        } else if (color.classList.contains('color-3')) {
            primaryHue = 352;
        } else if (color.classList.contains('color-4')) {
            primaryHue = 152;
        } else if (color.classList.contains('color-5')) {
            primaryHue = 202;
        }

        color.classList.add("active");

        // Store selected color in localStorage
        localStorage.setItem("primaryHue", primaryHue);
        root.style.setProperty('--primary-color-hue', primaryHue);
    });
});

// Event listener for background change
Bg1.addEventListener('click', () => {
    localStorage.removeItem("dark");
    localStorage.removeItem("white");
    localStorage.removeItem("light");

    Bg1.classList.add('active');
    Bg2.classList.remove('active');
    Bg3.classList.remove('active');
    window.location.reload(); // Refresh the page to apply changes
    changeBG();
});

Bg2.addEventListener('click', () => {
    darkColorLightness = "95%";
    whiteColorLightness = "20%";
    lightColorLightness = "15%";

    // Store background color settings in localStorage
    localStorage.setItem("dark", "95%");
    localStorage.setItem("white", "20%");
    localStorage.setItem("light", "15%");

    Bg1.classList.remove('active');
    Bg2.classList.add('active');
    Bg3.classList.remove('active');
    changeBG();
});

Bg3.addEventListener('click', () => {
    darkColorLightness = "95%";
    whiteColorLightness = "10%";
    lightColorLightness = "0%";

    // Store background color settings in localStorage
    localStorage.setItem("dark", "95%");
    localStorage.setItem("white", "10%");
    localStorage.setItem("light", "0%");

    Bg1.classList.remove('active');
    Bg2.classList.remove('active');
    Bg3.classList.add('active');
    changeBG();
});