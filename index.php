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
        <nav>
            <ul>
                <li>
                    <?php
                    if (isset($_SESSION['joueur'])) {
                        echo "<style>#login img {display: none}</style> <a href='#' id='login'>" . htmlspecialchars($_SESSION['joueur']) . "</a>";
                    }?>
                    <a href="#" id="login"><img src="img/login.png" alt="login"></a>
                    <div id="loginbox">
                        <?php
                        if (isset($_SESSION['joueur']))
                        {
                            echo "<p>connecté à <strong>".$_SESSION['joueur']."</strong></p>";
                            echo  "<style>.form_conexion{display: none}</style>";
                            echo "<a href='deconexion.php'>déconexion</a>";
                        }
                        else
                        {
                            echo "saisir les information de conexion";
                        }
                        ?>
                        <form method="POST" class="form_conexion">
                            <label> nom utilisateur
                                <input type="text" name="nom_utilisateur" id="user_name">
                            </label>
                            <label> mot de passe
                                <input type="password" id="password" name="db_password">
                            </label>
                            <input type="submit" value="connexion" name="submit">
                        </form>
                        <ul><li id="inscription"><a href="inscription.php">s'inscrire</a></li></ul>
                    </div>
                </li>
                </ul>
        </nav>
    </header>
</body>
</html>