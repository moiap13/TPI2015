<?php
session_start();

/****************************************************************
 * Author               : Antonio Pisanello                     *
 * Class                : Ecole d'informatique Genève IN-P4A    *
 * Version              : 1.0                                   *
 * Date of modification : AVRIL - MAI 2015                      *
 * Modification         :                                       *
 ****************************************************************/

// j'inclus mes fonctions
include '../../fonctions/fonction_site.php';
include '../../fonctions/fonction_bdd.php';
include '../../fonctions/fonction_lecture_donnee.php';
include '../../fonctions/fonction_affichage_donnee.php';
include '../../fonctions/fonction_connexion.php';
include '../../parametres/parametres.php';


// instentie la base de donnée
$bdd = connexion($BASE_DE_DONNEE, $SERVEUR, $UTILISATEUR_BDD, $MDP_UTILISATEUR_BDD);

// je test si l'utilisateur n'est pas connecté
if(!isset($_SESSION['CONN']) && !$_SESSION['CONN'])
{
    header('Location: ../../index.php?erreur=7');
}

// si on doit faire une action
if(isset($_REQUEST['action']))
{
    if($_REQUEST['action'] == 'activer')
    {
        maj_active ($_REQUEST['id'], 1, $bdd);
        header('Location: menu_annonces.php?erreur=22');
    }
    else
    {
        maj_active ($_REQUEST['id'], 0, $bdd);
        header('Location: menu_annonces.php?erreur=23');
    }
}

?>