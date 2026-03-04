<?php
function connexionbdd()
{
    $userbd = "c43bouchard";
    $passwordbd = "2019200Rb@betryu";
    $dbname = "c43blindgame";
    $host = "ispconfig.net.local";
    try
    {
        $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $userbd, $passwordbd);
        // On configure PDO pour qu'il affiche les futures erreurs SQL s'il y en a
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        echo "Connexion à la base de données réussie !";
        return $conexion;
    } catch (PDOException $e)
    {
        die('Erreur : impossible de se connecter à la base de donnée' . $e->getMessage());
    }
}
?>