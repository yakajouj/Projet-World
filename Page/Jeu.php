<?php
require_once "../bdd.php";
require_once "../partymanager.php";
session_start();

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'demarrer') {
        // Au lieu de stocker l'objet (qui fait planter PHP), on stocke juste les infos en texte/nombre !
        $_SESSION['score'] = 0;
        $_SESSION['difficulte_partie'] = $_POST['difficulte'];
        $_SESSION['mode_partie'] = $_POST['mode_jeu'];
        $_SESSION['heure_debut'] = time();
        echo "Partie initialisée !";
        exit();
    }

    elseif ($action === 'goodreponse') {
        if (isset($_SESSION['score'])) {
            // LA SÉCURITÉ : Si on est en Time Attack, on vérifie l'heure AVANT de donner le point !
            if ($_SESSION['mode_partie'] === "Time Attack" && isset($_SESSION['heure_debut'])) {
                $temps_ecoule = time() - $_SESSION['heure_debut'];
                // On laisse une petite marge de 2 secondes (122) pour les lags d'internet
                if ($temps_ecoule > 122) {
                    echo "Triche détectée : Temps écoulé, point refusé !";
                    exit(); // On bloque ! Le score n'augmente pas.
                }
                $_SESSION['score'] += 1;
                echo "Points ajoutés ! (" . $_SESSION['score'] . " point(s))";
            }
        }
        exit();
    }

    elseif ($action === 'fin_partie') {
        // C'EST L'HEURE DE SAUVEGARDER !
        if (isset($_SESSION['score']) && isset($_SESSION['id_joueur'])) {
            $id_joueur = $_SESSION['id_joueur'];
            $conexionbdd = connexionbdd();

            // On recrée ton objet proprement juste pour la sauvegarde !
            $partymanager = new partymanager($conexionbdd, 3, $_SESSION['difficulte_partie'], $_SESSION['mode_partie']);

            // On lui ajoute tous les points que le joueur a gagnés
            for ($i = 0; $i < $_SESSION['score']; $i++) {
                $partymanager->compter_score();
            }

            // On sauvegarde en base de données
            $partymanager->sauvegarder_score($id_joueur);

            // On nettoie la mémoire
            unset($_SESSION['score']);
            unset($_SESSION['difficulte_partie']);
            unset($_SESSION['mode_partie']);

            echo "Score sauvegardé en BDD !";
        } else {
            // Petit message d'erreur si on n'est pas connecté
            echo "Erreur : Joueur non connecté, pas de sauvegarde.";
        }
        exit();
    }
    exit();
}
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