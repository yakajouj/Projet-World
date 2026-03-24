<?php
session_start();
require_once ('../bdd.php');
$bdd = connexionbdd();

// --- 1. RÉCUPÉRATION DE TES SCORES PERSO ---
$mes_scores = [];
if (isset($_SESSION['joueur'])) {
    $req = $bdd->prepare("SELECT score FROM jeu 
                          INNER JOIN compte ON jeu.id_joueur = compte.id_joueur 
                          WHERE username = ? ORDER BY score DESC LIMIT 10");
    $req->execute([$_SESSION['joueur']]);
    $mes_scores = $req->fetchAll(PDO::FETCH_ASSOC); // ON STOCKE TES SCORES ICI
}

// --- 2. RÉCUPÉRATION DES SCORES MENSUELS ---
$req_m = $bdd->prepare("SELECT score, username FROM jeu 
                        INNER JOIN compte ON jeu.id_joueur = compte.id_joueur 
                        WHERE MONTH(score_date) = MONTH(CURRENT_DATE()) 
                        AND YEAR(score_date) = YEAR(CURRENT_DATE()) 
                        ORDER BY score DESC LIMIT 10");
$req_m->execute();
$mensuels = $req_m->fetchAll(PDO::FETCH_ASSOC); // ON STOCKE LES MENSUELS ICI

// On calcule le nombre de lignes à afficher (le plus grand des deux)
$nb_lignes = max(count($mes_scores), count($mensuels));
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/style.css">
    <title>BLIND GAME SCORES</title>
</head>
<body>
<header>
    <h1>BLIND GAME SCORES</h1>
    <?php if (isset($_SESSION['joueur'])) { include '../header.php'; } ?>
</header>

<table border="1" style="width:100%; border-collapse: collapse; text-align: center;">
    <thead>
    <tr>
        <th>Mes Scores</th>
        <th colspan="2">Scores Mensuels</th>
        <th>Scores Hebdo</th>
        <th>Scores Jour</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // ON CRÉE LE TABLEAU LIGNE PAR LIGNE
    for ($i = 0; $i < $nb_lignes; $i++) {
        echo "<tr>";

        // --- ICI ON INSERE TES SCORES PERSO ---
        echo "<td>";
        if (isset($mes_scores[$i])) {
            echo "<b>" . $mes_scores[$i]['score'] . "</b>"; // Ton score s'affiche ici !
        }
        echo "</td>";

        // --- ICI ON INSERE LES MENSUELS ---
        if (isset($mensuels[$i])) {
            echo "<td>" . htmlspecialchars($mensuels[$i]['username']) . "</td>";
            echo "<td>" . $mensuels[$i]['score'] . "</td>";
        }
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
</body>
</html>