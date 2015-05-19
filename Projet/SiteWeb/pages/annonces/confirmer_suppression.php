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

// instentie une connexion a la base
$bdd = connexion($BASE_DE_DONNEE, $SERVEUR, $UTILISATEUR_BDD, $MDP_UTILISATEUR_BDD);

// verifie si l'utilisateur est connecté
if(!isset($_SESSION['CONN']) && !$_SESSION['CONN'])
{
    header('Location: ../../index.php?erreur=7');
}

// recupere l'id
if(isset($_REQUEST['id']))
{
    $annonce = recupere_annonces_par_id($_REQUEST['id'], $bdd);
    $titre = $annonce[0][0];
}

// recupere le droit et verifie si c'est le proprietaire
if($_REQUEST['droit'] == 'proprietaire')
{
    if($annonce[0][4] != $_SESSION['ID'])
        header('Location: menu_annonces.php');
}

// recupere si le bouton non est pressé
if(isset($_REQUEST['btn_non']))
{
    if($_REQUEST['droit'] == 'proprietaire')
        header('Location: menu_annonces.php');
    else if($_REQUEST['droit'] == 'admin')
        header ("Location: ../gestion/gestion_annonces.php");
}

// recupere si le bouton oui est pressé
if(isset($_REQUEST['btn_oui']))
{
    supprimer_annonce($_REQUEST['id'], $bdd);
    
    if(dossier_existe('../../img/annonces' . $_REQUEST['id'] . '/'))
    {
        rmdir('../../img/annonces' . $_REQUEST['id'] . '/');
    }
    
    if($_REQUEST['droit'] == 'proprietaire')
        header('Location: menu_annonces.php?erreur=15');
    else if($_REQUEST['droit'] == 'admin')
        header ("Location: ../gestion/gestion_annonces.php?erreur=15");
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
            <form action="confirmer_suppression.php?id=<?php echo $_REQUEST['id']; ?>&droit=<?php echo $_REQUEST['droit']; ?>" method="post">
                <h1>Voulez vous vraiment supprimer l'annonce suivante</h1><br/>
                titre : <?php echo $titre; ?> <br/>
                <input type="submit" value='oui' name='btn_oui'/>
                <input type="submit" value='non' name='btn_non'/>
            </form>
        </div>
    </body>
</html>
