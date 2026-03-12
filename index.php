<?php
session_start();
require 'bdd.php';
$blindgamedb = connexionbdd();
if (isset($_POST['submit']))
{
    if (isset($_POST['nom_utilisateur']) && isset($_POST['db_password']))
    {
        if (empty($_POST['nom_utilisateur']))
        {
            echo " le nom utilisateur  est vide";
        }
        elseif (empty($_POST['db_password']))
        {
            echo " le mot de passe est vide";
        }
        else
        {
            $verification_utilisateur = $blindgamedb->prepare ("SELECT * FROM compte WHERE username = ?");
            $verification_utilisateur->execute([$_POST['nom_utilisateur']]);
            $result_utilisateur = $verification_utilisateur->fetch();
            if ($result_utilisateur && password_verify($_POST['db_password'], $result_utilisateur['password']))
            {
                $_SESSION['joueur'] = $result_utilisateur['username'];
                header("Location: ". $_SERVER['PHP_SELF']);
                exit();

            }
            else
            {
                echo "nom utilisateur ou mot de passe incorrect ou utilisateur non inscrit";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <script src="script/script.js" defer type="module"></script>
    <title>blindgame</title>
</head>
<body>
    <header>
        <?php
        include ('header.php');
        ?>
    </header>
    <p> Testez vos connaissances en jeux vidéo</p>
    <h2><a href="Page/Jeu.html"><button>JOUER</button></a><a href="Page/explications.html"><button>REGLES</button></a></h2>
    <p> COUP DE COEUR</p>
    <p>Dans BlindGame, le but est de trouver le plus de bonnes réponses !
        Vous aurez un mélange d'images et de sons provennant de divers jeux vidéo, à vous
        retrouver le jeu d'origine.</p>
    <br>
    Romain Yanis Alexis
</body>
</html>