import { allQuestions } from "./class.js";
import { allGames } from "./class.js";

let score = 0;
const usedQuestions = [];
let currentQuestion; 
var list = document.getElementById('gameAnswer');

allGames.forEach(function (item) {
    var option = document.createElement('option');
    option.value = item[0];
    list.appendChild(option);
});

function resetGame() {
    location.reload();
}

function getQuestion() {
    resetbutton.style.display = "none";
    sendbutton.style.display = "none";
    userInput.style.display = "none";
    newbutton.style.display = "none";
    document.getElementById("question").innerHTML = "";
    startbutton.style.display = "none";
    let availableQuestions = allQuestions.filter(question => !usedQuestions.includes(question));
    if (availableQuestions.length === 0) {
        document.getElementById("question").innerHTML = "Vous avez terminé toutes les questions !";
        document.getElementById("first-display").innerHTML = "";
        startbutton.style.display = "none";
        resetbutton.style.display = "inline-block";

        resetbutton.addEventListener("click", function () {
            location.reload();
        });
    }
    let randomIndex = Math.floor(Math.random() * availableQuestions.length);
    let question = availableQuestions[randomIndex];
    currentQuestion = question; 

    document.getElementById("score").innerHTML = "Score: " + score;

    if (question[2] === "Music" || question[2] === "Sound") {
        let music = document.createElement("audio");
        music.src = "../Assets/Question/" + question[0] + ".mp3";
        music.controls = true;
        document.getElementById("question").appendChild(music);
        sendbutton.style.display = "inline-block";
        userInput.style.display = "inline-block";
    } else {
        let picture = document.createElement("img");
        picture.src = "../Assets/Question/" + question[0] + ".png";
        document.getElementById("question").appendChild(picture);
        sendbutton.style.display = "inline-block";
        userInput.style.display = "inline-block";
    }
}

function answer() {
    let answer = userInput.value;
    if (answer === currentQuestion[1][0]) {
        score += 1;
        document.getElementById("score").innerHTML = "Score: " + score;
    } else if (score >= 1) {
        score -= 1;
        document.getElementById("score").innerHTML = "Score: " + score;
    }
    usedQuestions.push(currentQuestion); 
    userInput.value = ""; 
}

function questionRevealed() {
    document.getElementById("revealed").innerHTML = "Réponse : " + currentQuestion[1][0] + " (" + currentQuestion[1][1][0] + "), par " + currentQuestion[1][1][1] + ", " + currentQuestion[1][2];
}

const startbutton = document.getElementById("start");
const resetbutton = document.getElementById("reset");
const sendbutton = document.getElementById("send");
const userInput = document.getElementById("game");
const newbutton = document.getElementById("newQuestion");

resetbutton.style.display = "none";
sendbutton.style.display = "none";
userInput.style.display = "none";
newbutton.style.display = "none";
document.getElementById("score").innerHTML = "";

startbutton.addEventListener("click", getQuestion); 
sendbutton.addEventListener("click", function() {
    answer();
    sendbutton.style.display = "none";
    questionRevealed();
    newbutton.style.display = "inline-block";
}); 
newbutton.addEventListener("click",function() {
    document.getElementById("revealed").innerHTML = "";
    getQuestion();
});