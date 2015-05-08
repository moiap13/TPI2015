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

if(isset($_REQUEST['id']))
{
    $utilisateur = recupere_utilisateur_par_id($_REQUEST['id'], $bdd);
    $titre = $utilisateur[0][1];
}
    
if(isset($_REQUEST['btn_non']))
{
    header ("Location: ../gestion/gestion_utilisateur.php");
}

if(isset($_REQUEST['btn_oui']))
{
    supprimer_utilisateur($_REQUEST['id'], $bdd);
    header ("Location: ../gestion/gestion_utilisateur.php?erreur=19");
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>AnnoLigne</title>
        <link href="../../css/style_gestion.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div>
            <form action="confirmer_suppression_utilisateur.php?id=<?php echo $_REQUEST['id']; ?>" method="post">
                <h1>Voulez vous vraiment supprimer <label class="nom_categorie"><?php echo $titre; ?></label></h1><br/>
                <input type="submit" value='oui' name='btn_oui'/>
                <input type="submit" value='non' name='btn_non'/>
            </form>
        </div>
    </body>
</html>
