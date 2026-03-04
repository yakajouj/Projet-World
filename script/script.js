const loginli = document.getElementById("login");
const loginbox = document.getElementById("loginbox");
//si clique sur le lien
loginli.addEventListener("click", function (event)
{
    event.preventDefault(); //empêche rechargement de la page
    if (loginbox.style.display === "block") {
        loginbox.style.display = "none";
    } else {
        loginbox.style.display = "block";
    }
});