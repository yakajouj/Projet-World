const loginli = document.getElementById("login");
const loginbox = document.getElementById("loginbox");
//si clique sur le lien
loginli.addEventListener("click", function (event)
{
    event.preventDefault(); //empêche rechargement de la page
    loginbox.style.display = "block"; //afficher la boîte
    const positionlien = loginli.getBoundingClientRect(); //calcul ou est le lien a écran
    //placement de la boîte
    loginbox.style.top = (positionlien.bottom + window.scrollY) + 'px';
    loginbox.style.left = (positionlien.left + window.scrollX) + 'px';
});