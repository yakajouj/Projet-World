<?php
require 'bdd.php';
$blindgamedb = connexionbdd();
class scoremanager
{
    private $score;
    private $bdd;
    public function __construct($conexionBdd)
    {
        $this->bdd = $conexionBdd;
    }
}