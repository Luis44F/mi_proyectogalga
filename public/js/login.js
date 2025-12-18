const btnMostrarLogin = document.getElementById("btn-mostrar-login");
const overlay = document.getElementById("login-overlay");

btnMostrarLogin.addEventListener("click", () => {
    overlay.style.display = "flex";
});
