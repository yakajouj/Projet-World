<?php
session_start();
require_once ('../bdd.php');
$bdd = connexionbdd();

// --- mes score ---
$mes_scores_survive = [];
if (isset($_SESSION['joueur'])) {
    $req_ms = $bdd->prepare("SELECT score FROM jeu 
                          INNER JOIN compte ON jeu.id_joueur = compte.id_joueur 
                          WHERE username = ? ORDER BY score DESC LIMIT 10");
    $req_ms->execute([$_SESSION['joueur']]);
    $mes_scores_survive = $req_ms->fetchAll(PDO::FETCH_ASSOC); // ON STOCKE TES SCORES ICI
    $req_time=$bdd->prepare("select score from jeu
                                   inner join compte on jeu.id_joueur = compte.id_joueur
                                   WHERE username = ? order by score desc limit 10 ");
    $req_time->execute();
    $mes_scores_time = $req_time->fetchAll(PDO::FETCH_ASSOC);
}

// --- 2. RÉCUPÉRATION DES SCORES MENSUELS ---
$req_m = $bdd->prepare("SELECT score, username FROM jeu 
                        INNER JOIN compte ON jeu.id_joueur = compte.id_joueur 
                        WHERE MONTH(score_date) = MONTH(CURRENT_DATE()) 
                        AND YEAR(score_date) = YEAR(CURRENT_DATE()) 
                        ORDER BY score DESC LIMIT 10");
$req_m->execute();
$mensuels = $req_m->fetchAll(PDO::FETCH_ASSOC); // ON STOCKE LES MENSUELS ICI
//score hebdomadaire
$req_h = $bdd-> prepare("SELECT score,username from jeu
                        inner join compte on jeu.id_joueur = compte.id_joueur
                        WHERE WEEK(score_date,1) = WEEK(CURRENT_DATE(),1)
                        and year(score_date) = YEAR(CURRENT_DATE())
                        ORDER BY score DESC LIMIT 10");
$req_h->execute();
$hebdo= $req_h->fetchAll(PDO::FETCH_ASSOC);
//score quotidien
$req_q  = $bdd->prepare("SELECT score, username FROM jeu
                        INNER JOIN compte ON jeu.id_joueur = compte.id_joueur
                        where DATE(score_date) = CURRENT_DATE()
                        ORDER BY score DESC LIMIT 10");
$req_q->execute();
$quotidien = $req_q->fetchAll(PDO::FETCH_ASSOC);

// On calcule le nombre de lignes à afficher (le plus grand des deux)
$nb_lignes = max(count($mes_scores_survive), count($mensuels),count($hebdo),count($quotidien));
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
if (isset($_POST['class_survive'])) {
    echo "<style>#survive_class{display: block}form{display: none}</style>"

    ?>
    <table border = "1" style = "width:100%; border-collapse: collapse; text-align: center;"  id="survive_class">
    <thead >
    <tr >
        <th rowspan = "2" > Classement</th >
        <th > Mes Scores </th >
        <th colspan = "2" > Scores Mensuels </th >
        <th colspan = "2" > Scores Hebdo </th >
        <th colspan = "2" > Scores Quotidien </th >
    </tr >
    <tr style = "background-color: #f2f2f2; font-size: 0.9em;" >
        <th > Score</th >
        <th > Pseudo</th >
        <th > Score</th >
        <th > Pseudo</th >
        <th > Score</th >
        <th > Pseudo</th >
        <th > Score</th >
    </tr >
    </thead >
    <tbody >
    <?php
    // ON CRÉE LE TABLEAU LIGNE PAR LIGNE
    for ($i = 0; $i < $nb_lignes; $i++) {
        echo "<tr>";
        echo "<td>#" . ($i + 1) . "</td>";
        // --- ICI ON INSERE TES SCORES PERSO ---
        echo "<td>";
        if (isset($mes_scores_survive[$i])) {
            echo "<b>" . $mes_scores_survive[$i]['score'] . "</b>"; // Ton score s'affiche ici !
        } else {
            echo "-";
        }
        echo "</td>";

        // --- ICI ON INSERE LES MENSUELS ---
        if (isset($mensuels[$i])) {
            echo "<td>" . htmlspecialchars($mensuels[$i]['username']) . "</td>";
            echo "<td>" . $mensuels[$i]['score'] . "</td>";
        } else {
            echo "<td>-</td><td>-</td>";
        }
        //SCORE hebdomadaire
        if (isset($hebdo[$i]['score'])) {
            echo "<td>" . htmlspecialchars($hebdo[$i]['username']) . "</td>";
            echo "<td>" . $hebdo[$i]['score'] . "</td>";
        } else {
            echo "<td>-</td><td>-</td>";
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
    ?>
    <?php
    }else if (isset($_POST["class_time_attack"])){
    echo "<style>#survive_class{display: block}form{display: none}</style>"
    ?>
    <table border = "1" style = "width:100%; border-collapse: collapse; text-align: center;"  id="survive_class">
    <thead >
    <tr >
        <th rowspan = "2" > Classement</th >
        <th > Mes Scores </th >
        <th colspan = "2" > Scores Mensuels </th >
        <th colspan = "2" > Scores Hebdo </th >
        <th colspan = "2" > Scores Quotidien </th >
    </tr >
    <tr style = "background-color: #f2f2f2; font-size: 0.9em;" >
        <th > Score</th >
        <th > Pseudo</th >
        <th > Score</th >
        <th > Pseudo</th >
        <th > Score</th >
        <th > Pseudo</th >
        <th > Score</th >
    </tr >
    </thead >
    <tbody >
    <?php
    // ON CRÉE LE TABLEAU LIGNE PAR LIGNE
    for ($i = 0; $i < $nb_lignes; $i++) {
        echo "<tr>";
        echo "<td>#" . ($i + 1) . "</td>";
        // --- ICI ON INSERE TES SCORES PERSO ---
        echo "<td>";
        if (isset($mes_scores_time[$i])) {
            echo "<b>" . $mes_scores_time[$i]['score'] . "</b>"; // Ton score s'affiche ici !
        } else {
            echo "-";
        }
        echo "</td>";

        // --- ICI ON INSERE LES MENSUELS ---
        if (isset($mensuels[$i])) {
            echo "<td>" . htmlspecialchars($mensuels[$i]['username']) . "</td>";
            echo "<td>" . $mensuels[$i]['score'] . "</td>";
        } else {
            echo "<td>-</td><td>-</td>";
        }
        //SCORE hebdomadaire
        if (isset($hebdo[$i]['score'])) {
            echo "<td>" . htmlspecialchars($hebdo[$i]['username']) . "</td>";
            echo "<td>" . $hebdo[$i]['score'] . "</td>";
        } else {
            echo "<td>-</td><td>-</td>";
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
    ?>
    <?php
    }
    ?>
    </tbody>
</table>
</body>
</html>