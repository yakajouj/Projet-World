<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
</head>
<body>
    <form method="POST" action="inscription.php">
        <label>inscription</label>
        <label>
            <br>nom utilisateur
            <input type="text" name="nom_utilisateur" id="user_name">
        </label>
        <label>
            <br>email
            <input type="email" name="email" id="user_mail">
        </label>
        <label>
            mot de passe
            <input type="password" id="password" name="password">
        </label>
        <label>
            confirmer mot de passe
            <input type="password" id="confirm_password" name="confirm_password">
        </label>
        <input type="submit" value="s'inscrire" name="submit" id="submit">
    </form>
</body>
</html>
<?php
require 'bdd.php';
connexionbdd();
if (isset($_POST['nom_utilisateur'],$_POST['email'],$_POST['password']))
{
    if (empty($_POST['nom_utilisateur']))
    {
        echo "nom utilisateur est vide";
    }
    elseif (empty($_POST['email']))
    {
        echo "email est vide";
    }
    elseif (empty($_POST['password']))
    {
        echo "mot de passe est vide";
    }
    elseif (empty($_POST['confirm_password']))
    {
        echo "confirm mot de passe est vide";
    }
    elseif ($_POST['password'] != $_POST['confirm_password'])
    {
        echo "les mots de passe ne corespondent pas";
    }
    else
    {
        $blindgamedb = connexionbdd();
        $crypted_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $request = $blindgamedb->prepare("INSERT INTO compte (nom_utilisateur,email,password) VALUES (?,?,?)");
        $insertionn_reussie = $request->execute([
                $_POST['nom_utilisateur'],
                $_POST['email'],
                $crypted_password
        ]);
        if ($insertionn_reussie)
        {
            echo "Votre compte à bien était crée";
        }
        else{
            echo "Une erreur est survenue lors de la création du compte";
        }
    }
}
else
{
    echo "formulaire non envoyer";
}

?>