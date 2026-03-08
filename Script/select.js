const gameSelect0 = document.getElementById("gameSelect0");
const gameSelect1 = document.getElementById("gameSelect1");
const gameSelect2 = document.getElementById("gameSelect2");
const gameFunction = document.getElementById("gameFunction");

const startbutton = document.getElementById("start");
const survivebutton = document.getElementById("survive");



gameSelect0.style.display = "inline-block";
startbutton.addEventListener("click", function() {
    gameSelect0.remove()
    gameSelect1.style.display = "inline-block";
});

survivebutton.addEventListener("click", function() {
    gameSelect1.remove()
    gameSelect2.style.display = "inline-block";
});



