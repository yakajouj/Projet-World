import {allQuestions} from "./class.js";







const bouton = document.getElementById("answer");

bouton.addEventListener("click", function() {
    const randomQuestion = Math.floor(Math.random() * allQuestions.length);
    const question = allQuestions[randomQuestion];
    if (question[2] == "Music") {
        const music = document.createElement("audio");
        music.src = "../Assets/Question/" + question[0] + ".mp3";
        music.controls = true;
    document.getElementById("question").appendChild(music);
    } else if (question[2] == "Sound") {
        const music = document.createElement("audio");
        music.src = "../Assets/Question/" + question[0] + ".mp3";
        music.controls = true;
        document.getElementById("question").appendChild(music);
    } else if (question[2] == "Screenshot") {
        const picture = document.createElement("img");
        picture.src = "../Assets/Question/" + question[0] + ".png";
        document.getElementById("question").appendChild(picture);
    } else {
        const picture = document.createElement("img");
        picture.src = "../Assets/Question/" + question[0] + ".png";
        document.getElementById("question").appendChild(picture);
    }
});