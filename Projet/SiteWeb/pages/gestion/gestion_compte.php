<?php
session_start();

/****************************************************************
 * Author               : Antonio Pisanello                     * 
 * Class                : Ecole d'informatique Genève IN-P4A    *
 * Version              : 1.0                                   *
 * Date of modification : Vendredi, 4 MARS 2014                 *
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

if(isset($_SESSION['CONN']) && $_SESSION['CONN'])
{
    $s_login = "Déconnexion";
    $s_url = "deconnexion.php";
    $pseudo = 'Bienvenue ' . $_SESSION['PSEUDO'];

    $lien_menu_annonces =  '<p><a href="../annonces/menu_annonces.php">Menu annonces</a></p>';
    $lien_gestion_compte = '<p><a href="./gestion_compte.php">Gérer son compte</a></p>';
    
    if($_SESSION['ADMIN'] == 1)
    {
        //$pseudo = '<p><a href="pages/utilisateur/gestion_site.php">Gérer le site</a></p>';
        $pseudo = creer_menu_admin('../../');
    }
    
    $utilisateur = recupere_utilisateur_par_id($_SESSION['ID'], $bdd);
    
    if(!empty($utilisateur))
    {
        if($utilisateur[0][3] == 0)
        {
            $avatar_image = '<img src="../../img/image_site/avatar.jpeg" />';
        }
        else
        {
            if(dossier_existe('../../img/avatar/' . $_SESSION['ID']))
            {
                $a_images = mettre_fichier_dossier_dans_tableau('../../img/avatar/' . $_SESSION['ID'] .'/');
            }
            
            if(!empty($a_images))
                $avatar_image = '<img src="../../img/avatar/'. $_SESSION['ID'] .'/'. $a_images[0] .'" />';
            else
                $avatar_image = '<img src="../../img/image_site/avatar.jpeg" />';
        }
        
        $placeholder_mail = $utilisateur[0][0];
        $placeholder_pseudo = $utilisateur[0][1];
        $placeholder_mdp = $utilisateur[0][2];
    }
    else
    {
        $placeholder_mail = "";
        $placeholder_pseudo = "";
        $placeholder_mdp = "";
    }
}
else
{
    header('Location: ../../index.php?erreur=7');
    exit();
}

if(isset($_REQUEST['btn_avatar']))
{
    if(isset($_FILES['avatar']['error']) && $_FILES['avatar']['error'] != 4)
    {
        $avatar = 1;
        
        if(dossier_existe('../../img/avatar/' . $_SESSION['ID']))
        {
            $a_photos = mettre_fichier_dossier_dans_tableau('../../img/avatar/' . $_SESSION['ID']);
            
            if(!empty($a_images))
                supprimer_photo_avatar('../../img/avatar/' . $_SESSION['ID'] . '/' . $a_photos[0]);
        }
        else
        {
            mkdir('../../img/avatar/' . $_SESSION['ID']);
        }
        
        move_uploaded_file($_FILES['avatar']['tmp_name'], '../../img/avatar/'. $_SESSION['ID'] . '/avatar' . changer_formats($_FILES['avatar']['type']));
    }
    else 
    {
        $avatar = 0;
    }
    
    modification_avatar($_SESSION['ID'], $avatar, $bdd);
}

if(isset($_REQUEST['btn_supprimer_avatar']))
{
    $a_photos = mettre_fichier_dossier_dans_tableau('../../img/avatar/' . $_SESSION['ID']);
    supprimer_photo_avatar('../../img/avatar/' . $_SESSION['ID'] . '/' . $a_photos[0]);
    
    $avatar = 0;
    
    $avatar_image = '<img src="../../img/image_site/avatar.jpeg" />';
    
    modification_avatar($_SESSION['ID'], $avatar, $bdd);
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
                </div>
                <div id="gestion_compte">
                    <fieldset>
                        <legend>Gestion du compte</legend>
                        <div>
                            <div id="form_avatar">
                                <div id="avatar">
                                    <?php echo $avatar_image; ?>
                                </div>
                                <div id="input_avatar">
                                    <form action="#" method="post" enctype="multipart/form-data">
                                        <p>Pour changer votre avatar veuillez séléctionner une photo</p>
                                        <input type="file" name="avatar"  class="grande_taille" />
                                        <input type="submit" name="btn_avatar" value="Charger la photo" />
                                    </form>
                                    <form action="#" method="post">
                                        <input type="submit" name="btn_supprimer_avatar" value="Supprimer avatar" />
                                    </form>
                                </div>
                            </div>
                            <div id="form_infos">
                                <div id="table_form">
                                    <div id="titre_table">
                                        Modification de ses données (seul les champs remplit seront pris en compte)
                                    </div>
                                    <div class="ligne">
                                        <div class="cellule"> Email</div>
                                        <div class="deux_points">: </div>
                                        <div class="cellule"><input type="text" name="tbxemail" placeholder="<?php echo $placeholder_mail; ?>"/> </div>
                                    </div>
                                    <div class="ligne">
                                        <div class="cellule"> Pseudo</div>
                                        <div class="deux_points">: </div>
                                        <div class="cellule"><input type="text" name="tbxpseudo" placeholder="<?php echo $placeholder_pseudo; ?>"/> </div>
                                    </div>
                                    <div class="ligne">
                                        <div class="cellule"> Ancien mot de passe</div>
                                        <div class="deux_points">: </div>
                                        <div class="cellule"><input type="password" name="tbxancienmdp" placeholder="<?php echo $placeholder_mdp; ?>" id="tbx_pwd"/> </div>
                                    </div>
                                    <div class="ligne">
                                        <div class="cellule"> nouveau Mot de passe</div>
                                        <div class="deux_points">: </div>
                                        <div class="cellule"><input type="password" name="tbxnouveaumdp" id="tbx_pwd_2"/> </div>
                                    </div>
                                    <div class="ligne">
                                        <div class="cellule"> confirmer nouveau mot de passe</div>
                                        <div class="deux_points">: </div>
                                        <div class="cellule"><input type="password" name="tbxnouveaumdp_2" id="tbx_pwd_3"/> </div>
                                    </div>
                                    <div class="ligne">
                                        <div class="cellule">Afficher MDP</div>
                                        <div class="deux_points">:</div>
                                        <div class="cellule"><input type="checkbox" name="ckb_show_pwd" id="ckb" onclick="showPwd();"/></div>
                                    </div>
                                    <div class="ligne retour_ligne">
                                        <input type="submit" name="btn_modifier_infos" value="Modifier ses données" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div id="pied_page">
                
            </div>
        </div>
    </body>
</html>