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
}
else
{
    header('Location: ../../index.php?erreur=7');
    exit();
}

if(isset($_REQUEST['id']))
{
    $categorie = recupere_categories_par_id_gestion($_REQUEST['id'], $bdd);
    $titre = $categorie[0][1];
    $description = $categorie[0][2];
}

if(isset($_REQUEST['btn_modifier_2']))
{
    maj_categorie($_REQUEST['id'], $_REQUEST['tbxtitre'], $_REQUEST['tbxdescription'], $bdd);
    header('Location: ../gestion/gestion_categorie.php?erreur=16');
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
                    <p>Modification de la categorie <label class="nom_categorie"><?php echo $titre; ?></label></p>
                </div>
                <div id="gestion">
                    <div class="ligne_gestion">
                        <div class="gestion_table_categorie_modification">
                            <form action="modifier_categorie.php?id=<?php echo $_REQUEST['id']; ?>" method="post">
                                <div class="titre_gestion_categorie">titre : <input type="text" name="tbxtitre" value="<?php echo $titre;?>" /></div>

                                <div class="description_gestion_categorie">description : <input type="text" name="tbxdescription" value="<?php echo $description;?>" /></div>
                                <div class="form_gestion_categorie"> 
                                    <input type="submit" name="btn_modifier_2" value="Modifier" />
                                    <a href="../gestion/gestion_categorie.php">
                                        <input type="button" value="Annuler">
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="pied_page">
                
            </div>
        </div>
    </body>
</html>