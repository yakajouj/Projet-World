<?php
session_start();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <script type="module" src="../script/script.js" defer></script>
    <title>BLIND GAME SCORES </title>
</head>
<body>
<header>
    <h1>BLIND GAME SCORES</h1>    <!-- Entête identique-->
    <?php
    if (isset($_SESSION['joueur'])) {
        include '../header.php';
    }
    ?>
</header>
<table border="1">
    <tr>
        <th >Mes Scores</th>
        <th >Scores Mensuels</th>
        <th >Scores Hebdomadaires</th>
        <th > Scores Quotidiens</th>
    </tr>
    <?php
    require_once ('../bdd.php');
    if (isset($_SESSION['joueur'])) {
        $mes_score = connexionbdd()->prepare("SELECT score,username  FROM jeu
    inner join compte on jeu.id_joueur = compte.id_joueur 
    where username = ?");
        $mes_score->execute([$_SESSION['joueur']]);
        while ($mes_score_result = $mes_score->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>";
            echo $mes_score_result['score'];
            echo "</td>";
            echo "</tr>";
        }
    }
    else{
        echo "<tr>";
        echo "<td>";
        echo "veulier vous connecter à la page d'acceuil pour avoir vos score";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>
</body>
</html>
