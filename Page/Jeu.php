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
        if ($_POST['difficulte']=== "Easy")
        {
            $_SESSION['vie'] = 3;
        }
        elseif ($_POST['difficulte']=== "Medium")
        {
            $_SESSION['vie'] = 2;
        }
        elseif ($_POST['difficulte']=== "Hard")
        {
            $_SESSION['vie'] = 1;
        }
        echo "Partie initialisée !";
        exit();
    }

    elseif ($action === 'goodreponse') {
        if (isset($_SESSION['score'])) {

            // LA SÉCURITÉ : Si on est en Time Attack, on vérifie l'heure AVANT de donner le point !
            if (isset($_SESSION['mode_partie']) && $_SESSION['mode_partie'] === "Time Attack" && isset($_SESSION['heure_debut'])) {
                $temps_ecoule = time() - $_SESSION['heure_debut'];
                if ($temps_ecoule > 122) {
                    echo "Triche détectée : Temps écoulé, point refusé !";
                    exit();
                }
            }

            // SÉCURITÉ SURVIVE : On vérifie les vies
            if (isset($_SESSION['mode_partie']) && $_SESSION['mode_partie'] === "Survive") {
                if (!isset($_SESSION['vie']) || $_SESSION['vie'] <= 0) {
                    echo "ERREUR : Plus de vies, point refusé !";
                    exit(); // On bloque, le score n'augmente pas.
                }
            }

            // Si on arrive ici, c'est que tout est bon !
            $_SESSION['score'] += 1;
            echo "Points ajoutés ! (" . $_SESSION['score'] . " point(s), Vies restantes : " . (isset($_SESSION['vie']) ? $_SESSION['vie'] : 'N/A') . ")";
        }
        exit();
    }

    elseif ($action === 'badreponsse') {
        if (isset($_SESSION['mode_partie']) && $_SESSION['mode_partie'] === "Survive") {
            if (isset($_SESSION['vie']) && $_SESSION['vie'] > 0) {
                $_SESSION['vie'] -= 1;
                echo "Vie perdue ! Il reste " . $_SESSION['vie'] . " vie(s).";
            } else {
                echo "Le joueur est déjà à 0 vie !";
            }
        }
        exit();
    }
    elseif ($action=== 'badreponsse')
    {
        if ($_SESSION['mode_partie'] === "Survive" && $_SESSION['vie']  > 0)
        {
            $_SESSION['vie'] -=  1;
        }

    }

    elseif ($action === 'fin_partie') {
        // C'EST L'HEURE DE SAUVEGARDER !
        if (isset($_SESSION['score']) && isset($_SESSION['id_joueur'])) {
            if ($_SESSION['score'] >0) {
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
                echo "Score sauvegardé en BDD !";
            }
            // On nettoie la mémoire
            unset($_SESSION['score']);
            unset($_SESSION['difficulte_partie']);
            unset($_SESSION['mode_partie']);
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
    if (isset($_SESSION['joueur'])) {
        include('../header.php');
    }
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