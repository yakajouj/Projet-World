<nav>
            <ul>
                <li>
                    <?php
                    if (isset($_SESSION['joueur'])) {
                        echo "
<style>
#login img {display: none} 
#login
{
text-decoration: none;
color: black;
border: 1px solid;
}
</style> <a href='#' id='login'>" . htmlspecialchars($_SESSION['joueur']) . "</a>";
                    }?>
                    <a href="#" id="login"><img src="img/login.png" alt="login"></a>
                    <div id="loginbox">
                        <?php
                        if (isset($_SESSION['joueur']))
                        {
                            echo "<p>connecté à <strong>".$_SESSION['joueur']."</strong></p>";
                            echo  "<style>.form_conexion{display: none}</style>";
                            echo "<a href='deconexion.php'>déconexion</a>";
                        }
                        else
                        {
                            echo "saisir les information de conexion";
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
                        <ul><li id="inscription"><a href="inscription.php">s'inscrire</a></li></ul>
                    </div>
                </li>
                </ul>
        </nav>