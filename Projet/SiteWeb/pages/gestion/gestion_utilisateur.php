<?php
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
include '../../parametres/parametres.php';

$s_login = "Connexion";
$s_url = "connexion.php";
$lien_menu_annonces = '';
$lien_gestion_compte = '';
$pseudo = '';

$bdd = connexion($BASE_DE_DONNEE, $SERVEUR, $UTILISATEUR_BDD, $MDP_UTILISATEUR_BDD);

if(isset($_REQUEST['btn_rendre_admin']))
{
    maj_admin($_REQUEST['id'], 1, $bdd);
    echo afficher_erreur(20);
}

if(isset($_REQUEST['btn_enlever_admin']))
{
    if($_SESSION['ID'] == $_REQUEST['id'])
    {
        $_SESSION['ADMIN'] = 0;
    }
    maj_admin($_REQUEST['id'], 0, $bdd);
}

if(isset($_SESSION['CONN']) && $_SESSION['CONN'])
{
    $s_login = "Déconnexion";
    $s_url = "deconnexion.php";
    $pseudo = 'Bienvenue ' . $_SESSION['PSEUDO'];

    $lien_menu_annonces =  '<p><a href="../annonces/menu_annonces.php">Menu annonces</a></p>';
    $lien_gestion_compte = '<p><a href="./gestion_compte.php">Gérer son compte</a></p>';
    
    if($_SESSION['ADMIN'] == 1)
    {
        $pseudo = creer_menu_admin('../../');
    }
    else
    {
       header('Location: ../../index.php?erreur=21'); 
    }
}
else
{
    header('Location: ../../index.php?erreur=7');
    exit();
}

if(isset($_REQUEST['erreur']))
{
    echo afficher_erreur($_REQUEST['erreur']);
}

?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>AnnoLigne</title>
        <meta name="keywords" lang="fr" content="motcle1,mocle2" />
        <meta name="description" content="Description de ma page web." />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="fr" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <link href="../../css/style_gestion.css" rel="stylesheet" type="text/css" />
        <link href="../../css/menu_deroulant.css" rel="stylesheet" type="text/css" />
        <script src="../../javascript/fonction_globales.js"></script>
    </head>
    <body>
        <div id="principal">
            <div id="banniere">
                <div class="div_banniere"><p id="display_user"><?php echo $pseudo; ?></p></div>
                <div class="div_banniere">
                    <?php
                        echo $lien_gestion_compte;
                    ?>
                </div>
                <div class="div_banniere"><p id="titre_site"><a href="../../index.php">AnnoLigne<br/>Site d'annonce en ligne</a></p></div>
                <div class="div_banniere">
                    <p><a href="../connexion/<?php echo $s_url; ?>"><?php echo $s_login; ?></a></p>
                </div>
                <div class="div_banniere">
                    <?php
                        echo $lien_menu_annonces;
                    ?>
                </div>
            </div>
            <div id="contenent">
                <div id="bienvenue">
                    <span>Bienvennue - <?php echo $_SESSION['PSEUDO']; ?></span>
                    <p>Gestion des Utilisateurs</p>
                </div>
                <div id="gestion">
                    <?php echo afficher_utilisateur_gestion(recupere_utilisateur_gestion($bdd)); ?>
                </div>
            </div>
            <div id="pied_page">
                
            </div>
        </div>
    </body>
</html>