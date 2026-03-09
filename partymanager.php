<?php
$blindgamedb = connexionbdd();
class partymanager
{
    private $score;
    private $bdd;
    private $vie;
    public function __construct($conexionBdd,$viedepart)
    {
        $this->bdd = $conexionBdd;
        $this->score = 0;
        $this->vie = $viedepart;
    }
    public function compter_score($dificulte)
    {

    }
    public function sauvgarder_score()
    {

    }
    public function perdre_vie()
    {

    }
}