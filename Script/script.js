import { allQuestions } from "./class.js";
import { allGames } from "./class.js";

allGames.sort((a, b) => a[0].localeCompare(b[0]));
var goodAnswer = 0;
const usedQuestions = [];
let currentQuestion; 
var list = document.getElementById('gameAnswer');

const resetbutton = document.getElementById("reset");
const sendbutton = document.getElementById("send");
const userInput = document.getElementById("game");
const newbutton = document.getElementById("newQuestion");
const timeAttackbutton = document.getElementById("timeAttack");
const infinitebutton = document.getElementById("infinite");

const gameSelect1 = document.getElementById("gameSelect1");
const gameSelect2 = document.getElementById("gameSelect2");
const gameFunction = document.getElementById("gameFunction");

allGames.forEach(function (item) {
    var option = document.createElement('option');
    option.value = item[0];
    list.appendChild(option);
});

function getQuestion() {
    resetbutton.style.display = "none";
    sendbutton.style.display = "none";
    userInput.style.display = "none";
    newbutton.style.display = "none";
    document.getElementById("question").innerHTML = "";
    let availableQuestions = allQuestions.filter(question => !usedQuestions.includes(question));
    if (availableQuestions.length === 0) {
        document.getElementById("question").innerHTML = "Vous avez terminé toutes les questions !";
        resetbutton.style.display = "inline-block";

        resetbutton.addEventListener("click", function () {
            location.reload();
        });
    }
    let randomIndex = Math.floor(Math.random() * availableQuestions.length);
    let question = availableQuestions[randomIndex];
    currentQuestion = question; 

    switch (question[2]) {
    case "Music":
        let music = document.createElement("audio");
        music.src = "../Assets/Question/" + question[0] + ".mp3";
        music.controls = true;
        document.getElementById("question").appendChild(music);
        music.play();
        document.getElementById("questionName").innerHTML = "De quel jeu vidéo provient cette musique?";
        sendbutton.style.display = "inline-block";
        userInput.style.display = "inline-block";
        break;
    case "Sound":   
        let sound = document.createElement("audio");
        sound.src = "../Assets/Question/" + question[0] + ".mp3";
        sound.controls = true;
        document.getElementById("question").appendChild(sound);
        sound.play();
        document.getElementById("questionName").innerHTML = "De quel jeu vidéo provient cet extrait audio ?";
        sendbutton.style.display = "inline-block";
        userInput.style.display = "inline-block";
        break;
    case "Screenshot":
        let screenshot = document.createElement("img");
        screenshot.src = "../Assets/Question/" + question[0] + ".png";
        document.getElementById("question").appendChild(screenshot);
        document.getElementById("questionName").innerHTML = "De quel jeu vidéo provient cette capture d'écran ?";
        sendbutton.style.display = "inline-block";
        userInput.style.display = "inline-block";
        break;
    }
}

 function answer() {
    let answer = userInput.value;
    if (answer === currentQuestion[1][0] && goodAnswer === 0) {
        goodAnswer += 1;
        if (currentQuestion[1][1][0] === currentQuestion[1][0]) {
        document.getElementById("revealed").innerHTML = "Oui ! La réponse était bien : <br> " + currentQuestion[1][0] + ", par " + currentQuestion[1][1][1] + ", " + currentQuestion[1][2];
        document.getElementById("score").innerHTML = "Bonne réponses: " + goodAnswer;
        } else {
            document.getElementById("revealed").innerHTML = "Oui ! La réponse était bien : <br> " + currentQuestion[1][0] + " (" + currentQuestion[1][1][0] + "), par " + currentQuestion[1][1][1] + ", " + currentQuestion[1][2];
            document.getElementById("score").innerHTML = "Bonne réponse: " + goodAnswer;
    }
    } else  if (answer === currentQuestion[1][0]) {
        goodAnswer += 1;
        if (currentQuestion[1][1][0] === currentQuestion[1][0]) {
        document.getElementById("revealed").innerHTML = "Oui ! La réponse était bien : <br> " + currentQuestion[1][0] + ", par " + currentQuestion[1][1][1] + ", " + currentQuestion[1][2];
        document.getElementById("score").innerHTML = "Bonnes réponses: " + goodAnswer;
        } else {
            document.getElementById("revealed").innerHTML = "Oui ! La réponse était bien : <br> " + currentQuestion[1][0] + " (" + currentQuestion[1][1][0] + "), par " + currentQuestion[1][1][1] + ", " + currentQuestion[1][2];
            document.getElementById("score").innerHTML = "Bonnes réponses: " + goodAnswer;
    }
    } else {
        if (currentQuestion[1][1][0] === currentQuestion[1][0]) {
        document.getElementById("revealed").innerHTML = "Eh non ! La réponse était : <br> " + currentQuestion[1][0] + ", par " + currentQuestion[1][1][1] + ", " + currentQuestion[1][2];
    } else {
        document.getElementById("revealed").innerHTML = "Eh non ! La réponse était : <br> " + currentQuestion[1][0] + " (" + currentQuestion[1][1][0] + "), par " + currentQuestion[1][1][1] + ", " + currentQuestion[1][2];
    }
    }
    
    usedQuestions.push(currentQuestion); 
    userInput.value = ""; 
} 


sendbutton.addEventListener("click", function() {
    sendbutton.style.display = "none";
    userInput.style.display = "none";
    answer();
    newbutton.style.display = "inline-block";
}); 

newbutton.addEventListener("click",function() {
    document.getElementById("revealed").innerHTML = "";
    getQuestion();
});

infinitebutton.addEventListener("click", function() {
    gameSelect1.style.display = "none";
    gameFunction.style.display = "inline-block";
    document.getElementById("score").innerHTML = "Bonne réponse: " + goodAnswer;
    getQuestion();
});

timeAttackbutton.addEventListener("click", function() {
    gameSelect1.style.display = "none";
    gameSelect2.style.display = "inline-block";
});