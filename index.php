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
                <li><a href="#" id="login"><img src="img/login.png" alt="login"></a></li>
                </ul>
        </nav>
        <div id="loginbox">
            <form>
                <label> nom utilisateur</label>
                <input type="text" name="nom_utilisateur" id="user_name">
                <label> mot de passe </label>
                <input type="password" id="password">
                <input type="submit" value="connexion">
            </form>
            <li id="inscription"><a href="inscription.php">s'inscrire</a></li>
        </div>
    </header>
</body>
</html>
<?php

?>