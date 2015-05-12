<?php
session_start();

include '../../fonctions/fonction_site.php';
include '../../fonctions/fonction_bdd.php';
include '../../fonctions/fonction_lecture_donnee.php';
include '../../fonctions/fonction_affichage_donnee.php';
include '../../fonctions/fonction_connexion.php';
include '../../parametres/parametres.php';



$bdd = connexion($BASE_DE_DONNEE, $SERVEUR, $UTILISATEUR_BDD, $MDP_UTILISATEUR_BDD);

if(!isset($_SESSION['CONN']) && !$_SESSION['CONN'])
{
    header('Location: ../../index.php?erreur=7');
}


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