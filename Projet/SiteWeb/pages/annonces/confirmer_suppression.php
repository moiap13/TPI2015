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
    $annonce = recupere_annonces_par_id($_REQUEST['id'], $bdd);
    $titre = $annonce[0][0];
}
 
if($annonce[0][4] != $_SESSION['ID'])
{
    header('Location: menu_annonces.php');
}
    
if(isset($_REQUEST['btn_non']))
{
    header('Location: menu_annonces.php');
}

if(isset($_REQUEST['btn_oui']))
{
    supprimer_annonce($_REQUEST['id'], $bdd);
    header('Location: menu_annonces.php');
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
    </head>
    <body>
        <?php
        // put your code here
        ?>
        <div>
            <form action="confirmer_suppression.php?id=<?php echo $_REQUEST['id']; ?>" method="post">
                <h1>Voulez vous vraiment supprimer l'annonce suivante</h1><br/>
                titre : <?php echo $titre; ?> <br/>
                <input type="submit" value='oui' name='btn_oui'/>
                <input type="submit" value='non' name='btn_non'/>
            </form>
        </div>
    </body>
</html>
