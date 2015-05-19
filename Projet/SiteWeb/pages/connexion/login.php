<?php
session_start();
session_destroy();
session_start();

/****************************************************************
 * Author               : Antonio Pisanello                     *
 * Class                : Ecole d'informatique Genève IN-P4A    *
 * Version              : 1.0                                   *
 * Date of modification : AVRIL - MAI 2015                      *
 * Modification         :                                       *
 ****************************************************************/

include '../../fonctions/fonction_site.php';
include '../../fonctions/fonction_bdd.php';
include '../../fonctions/fonction_lecture_donnee.php';
include '../../fonctions/fonction_affichage_donnee.php';
include '../../fonctions/fonction_connexion.php';
include "../../parametres/parametres.php";

$bdd = connexion($BASE_DE_DONNEE, $SERVEUR, $UTILISATEUR_BDD, $MDP_UTILISATEUR_BDD);

if((isset($_REQUEST["login"])))
{
    $uid = (isset($_REQUEST["user"])?$_REQUEST["user"]:"");
    $mdp = (isset($_REQUEST["mdp"])?/*md5(*/$_REQUEST["mdp"]/*)*/:"");
    
    $Login = login($uid, $mdp, $bdd);
    
    if(!empty($Login))
    {
        $user = recupere_utilisateur_par_id($Login[0][0], $bdd);

        $_SESSION["ID"] = $Login[0][0];
        $_SESSION["PSEUDO"] = $user[0][1];
        $_SESSION["ADMIN"] = $user[0][4];
        $_SESSION["CONN"] = true;
        
        if(isset($_REQUEST["page"]))
            header("Location: " . $_REQUEST["page"] . ".php");
        else
            header("Location: ../../index.php");
    }
    else
    {
        header("Location: connexion.php?erreur=1&tbxusers=$uid");
    }
}
else
{
    header("Location: connexion.php?error=0");
}


