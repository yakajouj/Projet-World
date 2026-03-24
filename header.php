<?php
// On gère le chemin pour toutes les pages
if (basename($_SERVER['PHP_SELF']) == 'Jeu.php' || basename($_SERVER['PHP_SELF']) == 'Scores.php'){
    $chemin = '../';
} else {
    $chemin = '';
}
?>
<nav>
    <ul>
        <li>
            <a href="<?php echo $chemin; ?>Page/Scores.php">classement</a>

            <?php
            // LA MAGIE EST ICI : On affiche SOIT le pseudo, SOIT l'image !
            if (isset($_SESSION['joueur'])) {
                // S'il est connecté : On affiche son Pseudo (avec l'id="login" pour le JS)
                echo "
                <style>
                #login {
                    text-decoration: none;
                    color: black;
                    border: 1px solid;
                    padding: 2px 5px; /* Un peu d'espace pour faire joli */
                }
                .form_conexion { display: none; }
                </style>";
                echo "<a href='#' id='login'>" . htmlspecialchars($_SESSION['joueur']) . "</a>";
            }
            else {
                // S'il n'est PAS connecté : On affiche l'image (avec l'id="login" pour le JS)
                echo "<a href='#' id='login'><img src='" . $chemin . "img/login.png' alt='login'></a>";
            }
            ?>

            <div id="loginbox">
                <?php
                if (isset($_SESSION['joueur'])) {
                    echo "<p>connecté à <strong>".$_SESSION['joueur']."</strong></p>";
                    echo "<a href='" . $chemin . "deconexion.php'>déconnexion</a>";
                } else {
                    echo "saisir les informations de connexion";
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
                <ul>
                    <li id="inscription"><a href="<?php echo $chemin; ?>inscription.php">s'inscrire</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
<h1>BLIND GAME</h1>