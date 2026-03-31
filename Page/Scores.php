<?php
session_start();
require_once ('../bdd.php');
$bdd = connexionbdd();
$mode_jeu = "";
if (isset($_POST['class_survive'])) {
    $mode_jeu = "Survive";
}
if (isset($_POST['class_time_attack'])) {
    $mode_jeu = "Time Attack";
}
// --- mes score ---
$mes_scores  = [];
if (isset($_SESSION['joueur'])) {
    $req_m = $bdd->prepare("SELECT score,score_date FROM jeu 
                          INNER JOIN compte ON jeu.id_joueur = compte.id_joueur 
                          WHERE username = ? and mode_de_jeu = ? ORDER BY score DESC LIMIT 10");
    $req_m->execute([$_SESSION['joueur'], $mode_jeu]);
    $mes_scores = $req_m->fetchAll(PDO::FETCH_ASSOC); // ON STOCKE TES SCORES ICI
}
// --- 2. RÉCUPÉRATION DES SCORES MENSUELS ---
$req_sm = $bdd->prepare("SELECT MAX(score)as score, username,score_date FROM jeu 
                        INNER JOIN compte ON jeu.id_joueur = compte.id_joueur 
                        WHERE mode_de_jeu= ?  and MONTH(score_date) = MONTH(CURRENT_DATE()) 
                        AND YEAR(score_date) = YEAR(CURRENT_DATE()) 
                        group by username,score_date
                        ORDER BY score DESC LIMIT 10");
$req_sm->execute([$mode_jeu]);
$mensuels = $req_sm->fetchAll(PDO::FETCH_ASSOC);
//score hebdomadaire
$req_h = $bdd-> prepare("SELECT MAX(score) as score,username, score_date from jeu
                        inner join compte on jeu.id_joueur = compte.id_joueur
                        WHERE mode_de_jeu = ? and WEEK(score_date,1) = WEEK(CURRENT_DATE(),1)
                        and year(score_date) = YEAR(CURRENT_DATE())
                        group by username,score_date
                        ORDER BY score DESC LIMIT 10");
$req_h->execute([$mode_jeu]);
$hebdo= $req_h->fetchAll(PDO::FETCH_ASSOC);
//score quotidien
$req_q  = $bdd->prepare("SELECT max(score) as  score, username FROM jeu
                        INNER JOIN compte ON jeu.id_joueur = compte.id_joueur
                        where mode_de_jeu = ? and DATE(score_date) = CURRENT_DATE()
                        group by username
                        ORDER BY score DESC LIMIT 10");
$req_q->execute([$mode_jeu]);
$quotidien = $req_q->fetchAll(PDO::FETCH_ASSOC);

// On calcule le nombre de lignes à afficher (le plus grand des deux)
$nb_lignes = max(count($mes_scores), count($mensuels),count($hebdo),count($quotidien));
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
<form method="POST" action="Scores.php">
<button type="submit" name="class_survive">Classement survive</button>
<button type="submit" name="class_time_attack">Classement time attack</button>
</form>
<?php
if ($mode_jeu != "")
{
    echo "<style>#survive_class{display: block}form{display: none}</style>";

    ?>
    <table border = "1" style = "width:100%; border-collapse: collapse; text-align: center;"  id="survive_class">
    <thead >
    <tr >
        <th> Classement</th >
        <th > Mes Scores </th >
        <th colspan = "3" > Scores Mensuels </th >
        <th colspan = "3" > Scores Hebdo </th >
        <th colspan = "2" > Scores Quotidien </th >
    </tr >
    <tr style = "background-color: #f2f2f2; font-size: 0.9em;" >
        <th>classemen</th>
        <th > Score</th >
        <th > Pseudo</th >
        <th > Score</th >
        <th> Date Score</th>
        <th > Pseudo</th >
        <th > Score</th >
        <th> Date Score</th>
        <th > Pseudo</th >
        <th > Score</th >
    </tr >
    </thead >
    <?php
    // ON CRÉE LE TABLEAU LIGNE PAR LIGNE
    for ($i = 0; $i < $nb_lignes; $i++) {
        echo "<tr>";
        echo "<td>#" . ($i + 1) . "</td>";
        // --- ICI ON INSERE MES SCORES PERSO ---
        echo "<td>";
        if (isset($mes_scores[$i])) {
            echo "<b>" . $mes_scores[$i]['score'] . "</b>"; // MES score s'affiche ici !
        } else {
            echo "-";
        }
        echo "</td>";

        // --- ICI ON INSERE LES MENSUELS ---
        if (isset($mensuels[$i])) {
            echo "<td>" . htmlspecialchars($mensuels[$i]['username']) . "</td>";
            echo "<td>" . $mensuels[$i]['score'] . "</td>";
            echo "<td>" . $mensuels[$i]['score_date'] . "</td>";
        } else {
            echo "<td>-</td><td>-</td><td>-</td>";
        }
        //SCORE hebdomadaire
        if (isset($hebdo[$i]['score'])) {
            echo "<td>" . htmlspecialchars($hebdo[$i]['username']) . "</td>";
            echo "<td>" . $hebdo[$i]['score'] . "</td>";
            echo "<td>" . $hebdo[$i]['score_date'] . "</td>";
        } else {
            echo "<td>-</td><td>-</td><td>-</td>";
        }
        //SCORE quotidien
        if (isset($quotidien[$i]['score'])) {
            echo "<td>" . htmlspecialchars($quotidien[$i]['username']) . "</td>";
            echo "<td>" . $quotidien[$i]['score'] . "</td>";
        } else {
            echo "<td>-</td><td>-</td>";
        }
        echo "</tr>";

    }
    echo "</table>";
}
    ?>

</body>
</html>