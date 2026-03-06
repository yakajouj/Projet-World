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
    <script src="script/script.js" defer></script>
    <title>blindgame</title>
</head>
<body>
    <header>
        <?php
        include ('header.php');
        ?>
    </header>
<ul><li><a href="blindgame.php">jouer</a></li></ul>
</body>
</html>