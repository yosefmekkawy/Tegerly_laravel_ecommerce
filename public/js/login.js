

// toggle password visibility

const togglePassword = document.getElementById("togglePassword");
const password = document.querySelector("input[type='password']");
const togglePasswordIcon = document.getElementById("togglePasswordIcon");

togglePassword.addEventListener("click", function () {
    // Toggle the type attribute of the password field
    const type =
        password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    // Toggle the icon
    togglePasswordIcon.classList.toggle("ri-eye-fill");
    togglePasswordIcon.classList.toggle("ri-eye-off-fill");
});

// end of toggle password visibility
