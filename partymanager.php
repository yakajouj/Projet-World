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
        $this->heure_debut = time();
        $this->temps_restant = 120;

    }
    public function compter_score()
    {
        if ($this->dificulte === "facile")
        {
            $this->score += 100;
        }
        elseif ($this->dificulte === "moyen")
        {
            $this->score += 300;
        }
        elseif ($this->dificulte === "dificile")
        {
            $this->score += 500;
        }
    }
    public function sauvgarder_score($id_joueur)
    {
        if ($this->mode_de_jeu === "survive")
        {
            if ($this-> vie === 0 && $this-> score > 0)
            {
                $request = $this-> bdd->prepare("INSERT INTO  jeu  (score,id_joueur)VALUES(?,?)");
                $request->execute(array($this->score,$id_joueur));
            }
        }
        elseif ($this->mode_de_jeu === "time_attack")
        {
            if ($this-> chrono() === true && $this-> score > 0)
            {
                $request = $this-> bdd->prepare("INSERT INTO  jeu  (score,id_joueur) VALUES (?,?)");
                $request->execute(array($this->score,$id_joueur));
            }
            else
            {
                echo "<p class='alerte_temps'>temps écrouler</p>";
            }
        }
    }
    public function chrono()
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