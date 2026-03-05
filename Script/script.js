import { allQuestions } from "./class.js";

const usedQuestions = [];
const startbutton = document.getElementById("answer");
const resetbutton = document.getElementById("reset");
resetbutton.style.display = "none";

startbutton.addEventListener("click", function () {
    document.getElementById("question").innerHTML = "";
    const availableQuestions = allQuestions.filter(question => !usedQuestions.includes(question));
    if (availableQuestions.length === 0) {
        document.getElementById("question").innerHTML = "Vous avez terminé toutes les questions !";
        document.getElementById("first-display").innerHTML = "";
        startbutton.style.display = "none"; 
        resetbutton.style.display = "inline-block";

        resetbutton.addEventListener("click", function () {
            document.getElementById("question").innerHTML = "";
            usedQuestions = [];
    })};
    const randomIndex = Math.floor(Math.random() * availableQuestions.length);
    const question = availableQuestions[randomIndex];

    if (question[2] === "Music" || question[2] === "Sound") {
        const music = document.createElement("audio");
        music.src = "../Assets/Question/" + question[0] + ".mp3";
        music.controls = true;
        document.getElementById("question").appendChild(music);
    } else {
        const picture = document.createElement("img");
        picture.src = "../Assets/Question/" + question[0] + ".png";
        document.getElementById("question").appendChild(picture);
    }

    usedQuestions.push(question);
});

/* resetbutton.style.display = "none";
 "";
            document.getElementById("question").innerHTML = "";
            startbutton.style.display = "inline-block";
            */