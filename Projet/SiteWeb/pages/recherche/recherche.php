<?php
session_start();

/****************************************************************
 * Author               : Antonio Pisanello                     * 
 * Class                : Ecole d'informatique Genève IN-P4A    *
 * Version              : 1.0                                   *
 * Date of modification : AVRIL - MAI 2015                      *
 * Modification         :                                       *
 ****************************************************************/


// j'inclus toutes mes fonctions
include '../../fonctions/fonction_site.php';
include '../../fonctions/fonction_bdd.php';
include '../../fonctions/fonction_lecture_donnee.php';
include '../../fonctions/fonction_affichage_donnee.php';
include '../../fonctions/fonction_connexion.php';
include '../../parametres/parametres.php';

// initialiasion des variables
$s_login = "Connexion";
$s_url = "connexion.php";
$lien_menu_annonces = '';
$lien_gestion_compte = '';
$pseudo = '';
$mot_rechercher = '';
$aujourdhui = date_ajourdhui();


// j'instentie une liaison avec la base
$bdd = connexion($BASE_DE_DONNEE, $SERVEUR, $UTILISATEUR_BDD, $MDP_UTILISATEUR_BDD);

// je regarde si l'utilisateur est connecter si oui j'affiche les liens 
if(isset($_SESSION['CONN']) && $_SESSION['CONN'])
{
    $s_login = "Déconnexion";
    $s_url = "deconnexion.php";
    $pseudo = 'Bienvenue ' . $_SESSION['PSEUDO'];

    $lien_menu_annonces =  '<p><a href="../annonces/menu_annonces.php">Menu annonces</a></p>';
    $lien_gestion_compte = '<p><a href="../gestion/gestion_compte.php">Gérer son compte</a></p>';
    
    if($_SESSION['ADMIN'] == 1)
    {
        $pseudo = creer_menu_admin('../../');
    }
}

// si on recherche par categorie
if(isset($_REQUEST['categorie']))
{
    $mot_rechercher = $_REQUEST['categorie'];
}

// si on recherche par texte
if(isset($_REQUEST['tbx_search']))
{   
    // on verifie si le textBox est vide ou pas et s'il ne contient pas de chiffres
    if($_REQUEST['tbx_search'] != '' && contient_chiffre($_REQUEST['tbx_search']))
    {    
        $mot_rechercher = (string)$_REQUEST['tbx_search'];
        $array[0] = strtolower($mot_rechercher);
        $test = array_merge($array, couper_espaces(strtolower($mot_rechercher) . ' '));
    }
    else // 
    {
        $mot_rechercher = "Vous avez entrer un ou plusieurs chiffres";
        $test = null;   
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
        <link href="../../css/style.css" rel="stylesheet" type="text/css" />
        <link href="../../css/menu_deroulant.css" rel="stylesheet" type="text/css" />
        <link href="../../css/recherche_ajax.css" rel="stylesheet" type="text/css" />
        <script src="../../javascript/jquery.js"></script>
        <script src="../../javascript/fonction_globales.js"></script>
        <script type='text/javascript' src='../../javascript/ajax.js'></script>
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
            <div id="categorie">
                <?php echo afficher_categories(recupere_categories($bdd), 2, $bdd); ?>
            </div>
            <div id="contenent">
                <div id='recherche'>
                    <form method="get" action="./recherche.php">
                        <label>Recherche :</label>
                        <input type="text" autocomplete="off" name='tbx_search' onkeyup='keypressed(event, "recherche");' id="tbx_search" value="<?php if(isset($_REQUEST['categorie']))echo "CATEGORIE::". $mot_rechercher;else if(isset($_REQUEST['tbx_search']))  echo $mot_rechercher; ?>"/>
                        <button type="submit" name='btn_submit' onmousedown="submit();">
                            <div>
                                <img src="../../img/image_site/image_search.png" width="40" height="40"/>
                            </div>
                        </button>  
                    </form>
                    <div id='div_result' class='tumevoispas'>
                    </div>  
                </div>
                <div id="annonce_recherche">
                    <?php
                        if(isset($_REQUEST['categorie']))
                        {
                            echo afficher_annonces_recherchee(recupere_annonces_par_categorie($mot_rechercher, $bdd)); 
                        }
                        if(isset($_REQUEST['tbx_search']))
                        {
                            echo afficher_Annonces_recherchee(search($test, $bdd)); 
                        }
                    ?>
                </div>
            </div>
            <div id="pied_page">
                
            </div>
        </div>
    </body>
</html>