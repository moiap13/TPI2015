<?php
include '../../../fonctions/fonction_site.php';
include '../../../fonctions/fonction_bdd.php';
include '../../../fonctions/fonction_lecture_donnee.php';
include '../../../fonctions/fonction_affichage_donnee.php';
include '../../../fonctions/fonction_connexion.php';
include '../../../parametres/parametres.php';

$bdd = connexion($BASE_DE_DONNEE, $SERVEUR, $UTILISATEUR_BDD, $MDP_UTILISATEUR_BDD);

if(isset($_REQUEST['query']))
{
    //sleep(1);
    recupere_annonces_ajax($_REQUEST['query'], $bdd);
}
?>
