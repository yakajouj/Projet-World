//--------------------Définition des premières variables------------------------------------

import { allQuestions} from "./class.js";
import { allSeries } from "./class.js";
import { allGames } from "./class.js";
import { easyQuestion } from "./class.js";
import { mediumQuestion } from "./class.js";

allGames.sort((a, b) => a[0].localeCompare(b[0]));
allSeries.sort((a, b) => a[0].localeCompare(b[0]));

var goodAnswer = 0;
const usedQuestions = [];
let currentQuestion;
let list1;
let list2;
var list = document.getElementById('gameAnswer');
let difficultyMode = "";
let gameMode = "";
let questionList;
let defeatUnit;


const startbutton = document.getElementById("start");
const resetbutton = document.getElementById("reset");
const sendbutton = document.getElementById("send");
const userInput = document.getElementById("game");
const newbutton = document.getElementById("newQuestion");
const survivebutton = document.getElementById("survive");
const timeAttackbutton = document.getElementById("timeAttack");
const infinitebutton = document.getElementById("infinite");
const easybutton = document.getElementById("easy");
const mediumbutton = document.getElementById("medium");
const hardbutton = document.getElementById("hard");


const gameSelect0 = document.getElementById("gameSelect0");
const gameSelect1 = document.getElementById("gameSelect1");
const gameSelect2 = document.getElementById("gameSelect2");
const gameFunction = document.getElementById("gameFunction");
const gameEnd1 = document.getElementById("gameEnd1");
const gameEnd2 = document.getElementById("gameEnd2");
const gameFunction2 = document.getElementById("gameFunction2");

gameSelect0.style.display = "inline-block";

//-------------------------Sélection du mode et de la difficulté----------------------------------------

newbutton.addEventListener("click",function() {
    document.getElementById("revealed").innerHTML = "";
    getQuestion();
});

resetbutton.addEventListener("click", function () {
    location.reload();
});

timeAttackbutton.addEventListener("click", function() {
    gameSelect1.style.display = "none";
    gameSelect2.style.display = "inline-block";
    return gameMode = "Time Attack";
});

survivebutton.addEventListener("click", function() {
    gameSelect1.style.display = "none";
    gameSelect2.style.display = "inline-block";
    return gameMode = "Survive";
});

infinitebutton.addEventListener("click", function() {
    gameSelect1.style.display = "none";
    gameSelect2.style.display = "inline-block";
    return gameMode = "Infinite";
});

function setGameList(difficultyMode) {
    switch (difficultyMode) {
        case "Easy":
            questionList = easyQuestion;
            allSeries.forEach(function (item) {
            var option = document.createElement('option');
            option.value = item[0];
            list.appendChild(option);
            });
            break;
        case "Medium":
            questionList = mediumQuestion;
            allSeries.forEach(function (item) {
            var option = document.createElement('option');
            option.value = item[0];
            list.appendChild(option);
            });
            break;
        case "Hard":
            questionList = allQuestions;
            allGames.forEach(function (item) {
            var option = document.createElement('option');
            option.value = item[0];
            list.appendChild(option);
            });
            break;
    }
}


function setGameRule(gameMode) {
    switch (gameMode) {
        case "Survive" :
            switch (difficultyMode) {
                case "Easy":
                    defeatUnit = 3
                    break;
                case "Medium":
                    defeatUnit = 2
                    break;
                case "Hard":
                    defeatUnit = 1
                    break;
            }
        case "Time Attack" :
            defeatUnit = Date.now();
    }
    return defeatUnit;
}

//--------------------------------------------Fonction pour faire tourner le jeu--------------------------------------------------------------------

function getQuestion() {
    resetbutton.style.display = "none";
    sendbutton.style.display = "none";
    userInput.style.display = "none";
    newbutton.style.display = "none";
    document.getElementById("question").innerHTML = "";
    let availableQuestions = questionList.filter(question => !usedQuestions.includes(question));
    if (availableQuestions.length === 0) {
        document.getElementById("score").innerHTML = "";
        document.getElementById("questionName").innerHTML = "";
        document.getElementById("question").innerHTML = "Vous avez terminé toutes les questions !";
        resetbutton.style.display = "inline-block";

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
    if (gameMode === "Hard") {
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
    } else {
        if (answer === currentQuestion[1][1][0] && goodAnswer === 0) {
        goodAnswer += 1;
        if (currentQuestion[1][1][0] === currentQuestion[1][0]) {
        document.getElementById("revealed").innerHTML = "Oui ! La réponse était bien : <br> " + currentQuestion[1][0] + ", par " + currentQuestion[1][1][1] + ", " + currentQuestion[1][2];
        document.getElementById("score").innerHTML = "Bonne réponses: " + goodAnswer;
        } else {
            document.getElementById("revealed").innerHTML = "Oui ! La réponse était bien : <br> " + currentQuestion[1][0] + " (" + currentQuestion[1][1][0] + "), par " + currentQuestion[1][1][1] + ", " + currentQuestion[1][2];
            document.getElementById("score").innerHTML = "Bonne réponse: " + goodAnswer;
    }
    } else  if (answer === currentQuestion[1][1][0]) {
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
            if (gameMode === "Survive") {
            defeatUnit -= 1;
        }
        document.getElementById("revealed").innerHTML = "Eh non ! La réponse était : <br> " + currentQuestion[1][0] + ", par " + currentQuestion[1][1][1] + ", " + currentQuestion[1][2];
    } else {
        if (gameMode === "Survive") {
            defeatUnit -= 1;
        }
        document.getElementById("revealed").innerHTML = "Eh non ! La réponse était : <br> " + currentQuestion[1][0] + " (" + currentQuestion[1][1][0] + "), par " + currentQuestion[1][1][1] + ", " + currentQuestion[1][2] ;
    }
    }
    }
    
    usedQuestions.push(currentQuestion); 
    userInput.value = "";
} 

sendbutton.addEventListener("click", function() {
    sendbutton.style.display = "none";
    userInput.style.display = "none";
    answer();
    if (gameMode === "Survive" && defeatUnit == 0) {
        gameFunction.style.display = "none";
        document.getElementById("scoredisplay").innerHTML = "Nombre de bonnes réponses : " + goodAnswer;
        gameEnd1.style.display = "inline-block"
        resetbutton.style.display = "inline-block";
    } else {
    newbutton.style.display = "inline-block";
    }
});

startbutton.addEventListener("click", function() {
    gameSelect0.remove()
    gameSelect1.style.display = "inline-block";
});

newbutton.addEventListener("click",function() {
    document.getElementById("revealed").innerHTML = "";
    getQuestion();
});

resetbutton.addEventListener("click", function () {
    location.reload();
});

timeAttackbutton.addEventListener("click", function() {
    gameSelect1.style.display = "none";
    gameSelect2.style.display = "inline-block";
    return gameMode = "Time Attack";
});

survivebutton.addEventListener("click", function() {
    gameSelect1.style.display = "none";
    gameSelect2.style.display = "inline-block";
    return gameMode = "Survive";
});

infinitebutton.addEventListener("click", function() {
    gameSelect1.style.display = "none";
    gameSelect2.style.display = "inline-block";
    return gameMode = "Infinite";
});


easybutton.addEventListener("click", function() {
    gameSelect2.style.display = "none";
    difficultyMode = "Easy";
    setGameList(difficultyMode);
    setGameRule(gameMode)
    if (gameMode === "Time Attack") {
        const timeLimit = defeatUnit + 120000;
        var timeLeft = (Math.ceil((timeLimit - Date.now()) / 1000));
            document.getElementById("score").innerHTML = "Temps restant : " + timeLeft;
        setInterval(function() {
            timeLeft = (Math.ceil((timeLimit - Date.now()) / 1000));
            document.getElementById("score").innerHTML = "Temps restant : " + timeLeft;
        }, 1000);
        setTimeout(function() {
        gameFunction.style.display = "none";
        document.getElementById("scoredisplay").innerHTML = "Nombre de bonnes réponses : " + goodAnswer;
        gameEnd2.style.display = "inline-block"
        resetbutton.style.display = "inline-block";
        }, 120000);
    }
    getQuestion();
    gameFunction.style.display = "inline-block"
});

mediumbutton.addEventListener("click", function() {
    gameSelect2.style.display = "none";
    difficultyMode = "Medium";
    setGameList(difficultyMode);
    setGameRule(gameMode);
    if (gameMode === "Time Attack") {
        const timeLimit = defeatUnit + 120000;
        var timeLeft = (Math.ceil((timeLimit - Date.now()) / 1000));
            document.getElementById("score").innerHTML = "Temps restant : " + timeLeft;
        setInterval(function() {
            timeLeft = (Math.ceil((timeLimit - Date.now()) / 1000));
            document.getElementById("score").innerHTML = "Temps restant : " + timeLeft;
        }, 1000);
        setTimeout(function() {
        gameFunction.style.display = "none";
        document.getElementById("scoredisplay").innerHTML = "Nombre de bonnes réponses : " + goodAnswer;
        gameEnd2.style.display = "inline-block"
        resetbutton.style.display = "inline-block";
        }, 120000);
    }
    getQuestion();
    gameFunction.style.display = "inline-block"
});

hardbutton.addEventListener("click", function() {
    gameSelect2.style.display = "none";
    difficultyMode = "Hard";
    setGameList(difficultyMode);
    setGameRule(gameMode);
    if (gameMode === "Time Attack") {
        const timeLimit = defeatUnit + 120000;
        var timeLeft = (Math.ceil((timeLimit - Date.now()) / 1000));
            document.getElementById("score").innerHTML = "Temps restant : " + timeLeft;
        setInterval(function() {
            timeLeft = (Math.ceil((timeLimit - Date.now()) / 1000));
            document.getElementById("score").innerHTML = "Temps restant : " + timeLeft;
        }, 1000);
        setTimeout(function() {
        gameFunction.style.display = "none";
        document.getElementById("scoredisplay").innerHTML = "Nombre de bonnes réponses : " + goodAnswer;
        gameEnd2.style.display = "inline-block"
        resetbutton.style.display = "inline-block";
        }, 120000);
    }
    getQuestion();
    gameFunction.style.display = "inline-block"
});