<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
</head>
<body>
    <form>
        <label>inscription</label>
        <label><br>nom utilisateur</label>
        <input type="text" name="nom_utilisateur" id="user_name">
        <label> mot de passe </label>
        <input type="password" id="password">
        <label> confirmer mot de passe </label>
        <input type="password" id="confirm_password">
        <input type="submit" value="s'inscrire">
    </form>
</body>
</html>
<?php
require 'bdd.php';
connexionbdd();
?>