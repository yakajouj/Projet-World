<?php
$blindgamedb = connexionbdd();
class partymanager
{
    private $score;
    private $bdd;
    private $vie;
    private $heure_debut;
    private $temps_restant;
    private $dificulte;
    private $mode_de_jeu;
    public function __construct($conexionBdd,$viedepart,$dificulte,$mode_de_jeu)
    {
        $this->bdd = $conexionBdd;
        $this->score = 0;
        $this->vie = $viedepart;
        $this->dificulte = $dificulte;
        $this->mode_de_jeu = $mode_de_jeu;
        $this->temps_restant = 120;
        if (isset($_SESSION['heure_debut']))
        {
            $this->heure_debut = $_SESSION['heure_debut'];
        }else{
            $this->heure_debut = time();
        }

    }
    public function compter_score()
    {
        if ($this->dificulte === "Easy")
        {
            $this->score += 100;
        }
        elseif ($this->dificulte === "Medium")
        {
            $this->score += 300;
        }
        elseif ($this->dificulte === "Hard")
        {
            $this->score += 500;
        }
    }
    public function sauvegarder_score($id_joueur)
    {
        if ($this->mode_de_jeu === "Survive" || $this->mode_de_jeu === "Time Attack")
        {
                $request = $this-> bdd->prepare("INSERT INTO  jeu  (mode_de_jeu,difficulty,score,id_joueur) VALUES (?,?,?,?)");
                $reussite = $request->execute(array($this->mode_de_jeu,$this->dificulte,$this->score,$id_joueur));
                if (!$reussite) {
                    echo " ERREUR SQL : ";
                    print_r($request->errorInfo());
                    exit(); // On bloque la suite pour bien voir l'erreur dans la console
                }
            }
            else
            {
                echo "<p class='alerte_temps'>temps écrouler</p>";
            }
    }
    public function temprestant()
    {
        $heure_actuelle = time();
        $temps_passe = $heure_actuelle - $this->heure_debut;
        if ($temps_passe >= $this->temps_restant)
        {
            return true;
        } else {return false;}
    }
    public function perdre_vie()
    {
        $this->vie -= 1;
    }
}