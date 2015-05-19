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
include 'fonctions/fonction_site.php';
include 'fonctions/fonction_bdd.php';
include 'fonctions/fonction_lecture_donnee.php';
include 'fonctions/fonction_affichage_donnee.php';
include 'fonctions/fonction_connexion.php';
include 'parametres/parametres.php';

// j'initialise mes variables
$s_login = "Connexion";
$s_url = "connexion.php";
$lien_menu_annonces = '';
$lien_gestion_compte = '';
$pseudo = '';

// j'instentie une liaison avec la base
$bdd = connexion($BASE_DE_DONNEE, $SERVEUR, $UTILISATEUR_BDD, $MDP_UTILISATEUR_BDD);

// je regarde si l'utilisateur est connecter si oui j'affiche les liens 
if(isset($_SESSION['CONN']) && $_SESSION['CONN'])
{
    $s_login = "Déconnexion";
    $s_url = "deconnexion.php";
    $pseudo = 'Bienvenue ' . $_SESSION['PSEUDO'];

    $lien_menu_annonces =  '<p><a href="pages/annonces/menu_annonces.php">Menu annonces</a></p>';
    $lien_gestion_compte = '<p><a href="pages/gestion/gestion_compte.php">Gérer son compte</a></p>';
    
    if($_SESSION['ADMIN'] == 1)
    {
        //$pseudo = '<p><a href="pages/utilisateur/gestion_site.php">Gérer le site</a></p>';
        $pseudo = creer_menu_admin('./');
    }
}

// je regarde si un message d'erreur est la si oui je l'ffiche
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
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/menu_deroulant.css" rel="stylesheet" type="text/css" />
        <link href="css/recherche_ajax.css" rel="stylesheet" type="text/css" />
        <script src="javascript/jquery.js"></script>
        <script src="javascript/fonction_globales.js"></script>
        <script type='text/javascript' src='javascript/ajax.js'></script>
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
                <div class="div_banniere"><p id="titre_site"><a href="#">AnnoLigne<br/>Site d'annonce en ligne</a></p></div>
                <div class="div_banniere">
                    <p><a href="pages/connexion/<?php echo $s_url; ?>"><?php echo $s_login; ?></a></p>
                </div>
                <div class="div_banniere">
                    <?php
                        echo $lien_menu_annonces;
                    ?>
                </div>
            </div>
            <div id="categorie">
                <?php echo afficher_categories(recupere_categories($bdd), 0, $bdd); ?>
            </div>
            <div id="contenent">
                <div id='recherche'>
                    <form method="get" action="./pages/recherche/recherche.php">
                        <label>Recherche :</label>
                        <input type="text" autocomplete="off" name='tbx_search' onkeyup='keypressed(event, "index");' id="tbx_search"/>
                        <button type="submit" name='btn_submit' onmousedown="submit();">
                            <div>
                                <img src="img/image_site/image_search.png" width="40" height="40"/>
                            </div>
                        </button>  
                    </form>
                    <div id='div_result' class='tumevoispas'>
                    </div>  
                </div>
                <p>Dernières annonces :</p>
                <div id="derniere_annonces">
                    <?php echo afficher_photo_dernieres_annonces_postees(recupere_dernieres_annonces_postee($bdd)); ?>
                </div>
                <div id="titre_derniere_annonces">
                    <?php echo afficher_dernieres_annonces_postees(recupere_dernieres_annonces_postee($bdd)); ?>
                </div>
                <div id='explications'>
                    <p>Bonjour et bienvenue</p>
                    <p>
                       Ce site a été crée par <a href='mailto:antonio.pisanello.cfpt.ei@gmail.com'>Antonio Pisanello</a>. 
                       Le but de ce site est de pouvoir publier des annonces et trouver les annonces qui vous intérressent.
                    </p>
                    <p>
                        Le principe est simple pour poster une annnce il faut être connécté avec un compte, 
                        pour lire une annonce un compte n'est pas nécessaire, mais on peut enregistrer les annonces qui nous
                        plaisent et le nottants favori, ainsi on peut retourner voir cette annonce ultérieurement.
                    </p>
                    <p>
                        Une annonce dure 15j mais on peut remettre a 0 ce compteur a l'aide du boutton republier, même si
                        les 15 jours ne sont pas passés
                    </p>
                </div>
            </div>
            <div id="pied_page">
                
            </div>
        </div>
    </body>
</html>