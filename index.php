
<script type="text/javascript">
   const desktopUrl = "./Views/form.php";
const mobileUrl = "./Mobile/Views/form.php";

// Use matchMedia to check for mobile screens
const mediaQuery = window.matchMedia("(max-width: 600px)");

function checkDevice() {
    if (mediaQuery.matches) {
        // Redirect to the mobile version if the screen size is less than 600px
        window.location.href = mobileUrl;
    } else {
        // Redirect to the desktop version if the screen size is 600px or more
        window.location.href = desktopUrl;
    }
}

// Initial check
checkDevice();

// Add event listener to respond to window resizing
mediaQuery.addEventListener('change', checkDevice);
</script>
