<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
</head>
<body>
<?php
require 'bdd.php';

if (isset($_POST['submit'])) {
    if (isset($_POST['nom_utilisateur'], $_POST['email'], $_POST['password'], $_POST['confirm_password'])) {

        if (empty($_POST['nom_utilisateur'])) {
            echo "nom utilisateur est vide";
        } elseif (strlen($_POST['nom_utilisateur']) > 20) {
            echo "le nom utilisateur doit être au maximum 20 caractères";
        } elseif (!preg_match('/^[\p{L}0-9 ._-]+$/u', $_POST['nom_utilisateur'])) {
            echo "Le nom d'utilisateur contient des caractères non autorisés.";
        } elseif (empty($_POST['email'])) {
            echo "email est vide";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "email n'est pas valide";
        } elseif (empty($_POST['password'])) {
            echo "mot de passe est vide";
        } elseif (empty($_POST['confirm_password'])) {
            echo "confirm mot de passe est vide";
        } elseif ($_POST['password'] != $_POST['confirm_password']) {
            echo "les mots de passe ne correspondent pas";
        } else {
            $blindgamedb = connexionbdd();
            $verification_nom_utilisateur = $blindgamedb->prepare("SELECT id_joueur FROM compte WHERE username = ?");
            $verification_nom_utilisateur->execute([$_POST['nom_utilisateur']]);

            $verification_email = $blindgamedb->prepare("SELECT email FROM compte WHERE email = ?");
            $verification_email->execute([$_POST['email']]);

            if ($verification_nom_utilisateur->rowCount() > 0) {
                echo "ce nom utilisateur est déjà utilisé";
            } elseif ($verification_email->rowCount() > 0) {
                echo "cet email est déjà rattaché à un compte";
            } else {
                $crypted_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $request = $blindgamedb->prepare("INSERT INTO compte (username, email, password) VALUES (?, ?, ?)");

                $insertionn_reussie = $request->execute([
                        $_POST['nom_utilisateur'],
                        $_POST['email'],
                        $crypted_password
                ]);

                if ($insertionn_reussie) {
                    echo "Votre compte a bien été créé !";
                } else {
                    echo "Une erreur est survenue lors de la création du compte";
                }
            }
        }
    }
} else {
    echo "Veuillez remplir le formulaire.";
}
?>
<form method="POST">
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