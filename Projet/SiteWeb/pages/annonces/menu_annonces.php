<?php
session_start();

/****************************************************************
 * Author               : Antonio Pisanello                     *
 * Class                : Ecole d'informatique Genève IN-P4A    *
 * Version              : 1.0                                   *
 * Date of modification : AVRIL - MAI 2015                      *
 * Modification         :                                       *
 ****************************************************************/
// inclus mes fonction 
include '../../fonctions/fonction_site.php';
include '../../fonctions/fonction_bdd.php';
include '../../fonctions/fonction_lecture_donnee.php';
include '../../fonctions/fonction_affichage_donnee.php';
include '../../fonctions/fonction_connexion.php';
include '../../parametres/parametres.php';

// initialise mes variables
$s_login = "Login";
$s_url = "login.php";
$pseudo = '';
$today = date_ajourdhui();

// liaison a la base de donnée
$bdd = connexion($BASE_DE_DONNEE, $SERVEUR, $UTILISATEUR_BDD, $MDP_UTILISATEUR_BDD);

// regarde si l'utilisateur est connécté
if(isset($_SESSION["CONN"]) && $_SESSION["CONN"])
{
    $s_login = "Déconnexion";
    $s_url = "deconnexion.php";
    $pseudo = 'Bienvenue ' . $_SESSION['PSEUDO'];

    $lien_menu_annonces =  '<p><a href="./menu_annonces.php">Menu annonces</a></p>';
    $lien_gestion_compte = '<p><a href="../gestion/gestion_compte.php">Gérer son compte</a></p>';
    
    if($_SESSION['ADMIN'] == 1)
    {
        //$pseudo = '<p><a href="pages/utilisateur/gestion_site.php">Gérer le site</a></p>';
        $pseudo = creer_menu_admin('../../');
    }
}
else // si non le redirrige
{
    header('Location: ../../index.php?erreur=7');
    exit();
}

// verifier si le btn poster est pressé
if(isset($_REQUEST["btn_poster"]))
{
    if(isset($_REQUEST["tbx_titre_annonce"], $_REQUEST["text_annonce"],  
            $_REQUEST['date_debut'],$_REQUEST['categorie'] )) // verifie que toutes les données sont entrées
    {
        // initialisation des variables
        $titre = $_REQUEST["tbx_titre_annonce"];
        $text = $_REQUEST["text_annonce"];
        $date = $_REQUEST["date_debut"];
        $id_categorie = $_REQUEST["categorie"];
        $prix = $_REQUEST["tbx_prix"];
        $lastinsertid = -1;
        
        // test pour savoir s'il y a des photos
        if(isset($_FILES['photos']['error'][0]) && $_FILES['photos']['error'][0] != 4)
        {
            $photos = 1;
        }
        else 
        {
            $photos = 0;
        }
        
        // recupere le dernier ID
        $lastinsertid = ajout_annonce($titre, $text, $date, $prix,$_SESSION['ID'], $id_categorie, $photos, $bdd);
        
        // deplace les photos dans le dossier
        if($lastinsertid > -1 && $photos == 1)
        {
            $nb = count($_FILES['photos']['name']);
        
            mkdir('../../img/annonces/' . $lastinsertid);
            
            for($z=0;$z<$nb;$z++)
            {
                move_uploaded_file($_FILES['photos']['tmp_name'][$z], '../../img/annonces/'. $lastinsertid . '/' . $z . changer_formats($_FILES['photos']['type'][$z]));
            }
        }
    }
    else // sinon affiche un message
    {
        echo 'Pas tous les champs ont été saisis';
    }
}

// si une erreure existe on l'affiche
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
        <link href="../../css/style_menu_annonces.css" rel="stylesheet" type="text/css" />
        <link href="../../css/menu_deroulant.css" rel="stylesheet" type="text/css" />
        <script src="../../javascript/fonction_globales.js"></script>
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
            <div id="contenent">
                <div id="inserer_annonce">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="titre">Inserer une annonce</div>
                        <div id="formulaire">
                            
                            <div class="ligne_petite">
                                <div class="colonne_gauche">
                                    <p>Titre de l'annonce</p>
                                </div>
                                <div class="colonne_droite">
                                    <input type="text" name="tbx_titre_annonce" placeholder="Titre de l'annonce" class="grande_taille" require/>
                                </div>
                            </div>
                            <div id="ligne_grande">
                                <div class="colonne_gauche">
                                    <p>Texte de l'annonce</p>
                                </div>
                                <div class="colonne_droite">
                                    <textarea rows="15" cols="40" required name="text_annonce"></textarea>
                                </div>
                            </div>
                            <div class="ligne_petite" >
                                <div class="colonne_gauche">
                                    <p>Prix</p>
                                </div>
                                <div class="colonne_droite">
                                    <input type="text" name="tbx_prix" placeholder="Prix en CHF" class="grande_taille" required/>
                                </div>
                            </div>
                            <div class="ligne_petite" >
                                <div class="colonne_gauche">
                                    <p>Date début (aaaa-mm-jj)</p>
                                </div>
                                <div class="colonne_droite">
                                    <input type="date" name="date_debut" min="<?php echo $today; ?>" value="<?php echo $today; ?>" class="grande_taille" required/>
                                </div>
                            </div>
                            <div class="ligne_petite">
                                <div class="colonne_gauche">
                                    <p>Catégorie</p>
                                </div>
                                <div class="colonne_droite">
                                    <?php echo afficher_combobox_categories(recupere_categories($bdd)); ?>
                                    <input type="hidden" name="tbx_autre" id="tbx_autre" />
                                </div>
                            </div>
                            
                            <div class="ligne_petite">
                                <div class="colonne_gauche">
                                    <p>Ajouter des photos</p>
                                </div>
                                <div class="colonne_droite">
                                    <input type="file" name="photos[]"  class="grande_taille" multiple />
                                </div>
                            </div>
                            <div class="ligne_petite">
                                <input type="submit" name="btn_poster" value="Publier l'annonce" id="btn_envoyer" required/>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="user_annonces">
                    <div class="titre">Vos annonces</div>
                    <div class="contour">
                        <?php 
                            echo affichage_annonces_utilisateur(recupere_annonces_utilisateur($_SESSION['ID'], $bdd));
                        ?>
                    </div>
                </div>
            </div>
            <div id="pied_page">
            </div>
        </div>
    </body>
</html>