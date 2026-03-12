<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="../style/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu</title>
</head>

<body>
<header>
    <?php
    include ('../header.php');
    ?>
</header>
<div class="tableau">
    <div id="gameSelect0">
        <img src="" alt="">
        <p>Bienvenue sur Blind.gg !</p>
        <button id="start">Commencer la partie</button>
    </div>
    <div id="gameSelect1">
        <p>Séléctionnez le mode de jeu !</p>
        <button id="survive">SURVIVE</button>
        <button id="timeAttack">TIME ATTACK</button>
        <button id="infinite">INFINITE</button>
    </div>
    <div id="gameSelect2">
        <p>Séléctionnez la difficulté !</p>
        <button id="easy">FACILE</button>
        <button id="medium">MOYEN</button>
        <button id="hard">DIFFICILE</button>
    </div>
    <div id="gameFunction">
        <span id="question" autoplay></span>
        <p id="questionName"></p>
        <form id="userImputForm">
            <input type="text" id="game" list="gameAnswer">
            <datalist id="gameAnswer"></datalist>
            <button type="submit" id="send">Envoyer</button>
        </form>
        <p id="revealed"></p>
        <button id="newQuestion">Prochaine question</button>
        <p id="score"></p>
    </div>
    <div id="gameEnd1">
        <p>Vous avez perdu !</p>
        <p id="scoredisplay"></p>

    </div>
    <div id="gameEnd2">
        <p>Fin de la partie !</p>
        <p id="scoredisplay"></p>

    </div>
    <br><button id="reset">Clique ici pour recommencer</button>
</div>

<script type="module" src="../script/script.js"></script>
</body>
</html>