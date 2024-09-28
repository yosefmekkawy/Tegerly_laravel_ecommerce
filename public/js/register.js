

// start of toggle password

const togglePassword = document.getElementById("togglePassword");
const togglePasswordConfirm = document.getElementById("togglePasswordConfirm");
const password = document.getElementById("password");
const passwordConfirmation = document.getElementById("passwordConfirmation");
const togglePasswordIcon = document.getElementById("togglePasswordIcon");
const togglePasswordConfirmIcon = document.getElementById(
    "togglePasswordConfirmIcon"
);

// Toggle for the password field
togglePassword.addEventListener("click", function () {
    // Toggle the type attribute for the password field
    const type =
        password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    // Toggle the icon
    togglePasswordIcon.classList.toggle("ri-eye-fill");
    togglePasswordIcon.classList.toggle("ri-eye-off-fill");
});

// Toggle for the confirm password field
togglePasswordConfirm.addEventListener("click", function () {

    const type =
        passwordConfirmation.getAttribute("type") === "password"
            ? "text"
            : "password";
    passwordConfirmation.setAttribute("type", type);


    togglePasswordConfirmIcon.classList.toggle("ri-eye-fill");
    togglePasswordConfirmIcon.classList.toggle("ri-eye-off-fill");
});

// end of toggle password
