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

// initialisation des variables
$s_login = "Connexion";
$s_url = "connexion.php";
$lien_menu_annonces = '';
$lien_gestion_compte = '';
$pseudo = '';
$droit = 0;

// instentie la liaison bdd
$bdd = connexion($BASE_DE_DONNEE, $SERVEUR, $UTILISATEUR_BDD, $MDP_UTILISATEUR_BDD);

// verifie si l'utilisateur est connecté
if(isset($_SESSION['CONN']) && $_SESSION['CONN'])
{
    $s_login = "Déconnexion";
    $s_url = "deconnexion.php";
    $pseudo = 'Bienvenue ' . $_SESSION['PSEUDO'];

    $lien_menu_annonces =  '<p><a href="./menu_annonces.php">Menu annonces</a></p>';
    $lien_gestion_compte = '<p><a href="../gestion/gestion_compte.php">Gérer son compte</a></p>';
    
    if($_SESSION['ADMIN'] == 1)
    {
        $pseudo = creer_menu_admin('../../');
    }
}

// récupere l'id de l'annonce
if(isset($_REQUEST['id_annonce']))
{
    $id_annonce = $_REQUEST['id_annonce'];
    $annonce = recupere_annonces_par_id($_REQUEST['id_annonce'], $bdd); // recupere l'annonce et la stocke
}
else 
{
    $annonce = ""; // si non l'annonce vaut rien
}

if(isset($_REQUEST['droit'])) // regarde s'il y a des droits
{
    $droit = $_REQUEST['droit'];
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
        <link href="../../css/style_afficher_annonces.css" rel="stylesheet" type="text/css" />
        <link href="../../css/menu_deroulant.css" rel="stylesheet" type="text/css" />
        <script src="../../javascript/fonction_globales.js"></script>
        <script type="text/javascript" src="../../javascript/galerie_photo.js"></script>
    </head>
    <body>
        <?php
            // insère ton gros code ici Antonio ;P
        ?>
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
            <div id="categorie">
                <?php echo afficher_categories(recupere_categories($bdd), 1, $bdd); ?>
            </div>
            <div id="contenent">
                <?php echo afficher_annonce($annonce, $id_annonce, $droit, $bdd); ?>
            </div>
            <div id="pied_page">
                
            </div>
        </div>
    </body>
</html>