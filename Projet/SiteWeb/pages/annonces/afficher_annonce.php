<?php
session_start();

/****************************************************************
 * Author               : Antonio Pisanello                     * 
 * Class                : Ecole d'informatique Genève IN-P4A    *
 * Version              : 1.0                                   *
 * Date of modification : 25.09.14                              *
 * Modification         :                                       *
 ****************************************************************/

/*echo '<pre>';
var_dump($_SESSION);
echo '</pre>';*/

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

if(isset($_REQUEST['id_annonce']))
{
    $id_annonce = $_REQUEST['id_annonce'];
    $annonce = recupere_annonces_par_id($_REQUEST['id_annonce'], $bdd);
}
else 
{
    $annonce = "";
}

if(!isset($_REQUEST['droit']))
{
    $jours = savoir_les_jours_restants($annonce[0][3])[0];
    $jours = $jours[0] . $jours[1];

    if($jours <= 15 && $annonce[0][6] == 0)
    {
        $annonce = "";
    }
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
                <?php echo afficher_categories(recupere_categories($bdd), 0);  ?>
            </div>
            <div id="contenent">
                <?php echo afficher_annonce($annonce, $id_annonce, $bdd); ?>
            </div>
            <div id="pied_page">
                
            </div>
        </div>
        <script type="text/javascript">
            //Insere ton Javascript ;P
        </script>
    </body>
</html>