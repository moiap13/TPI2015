<?php
session_start();

/****************************************************************
 * Author               : Antonio Pisanello                     *
 * Class                : Ecole d'informatique Genève IN-P4A    *
 * Version              : 1.0                                   *
 * Date of modification : AVRIL - MAI 2015                      *
 * Modification         :                                       *
 ****************************************************************/

// inclus les fonctions
include '../../fonctions/fonction_site.php';
include '../../fonctions/fonction_bdd.php';
include '../../fonctions/fonction_lecture_donnee.php';
include '../../fonctions/fonction_affichage_donnee.php';
include '../../fonctions/fonction_connexion.php';
include '../../parametres/parametres.php';

// initialise les variables
$s_login = "Login";
$s_url = "login.php";
$pseudo = '';
$input_delete = '<input type="submit" name="btn_delete_ads" value="Supprimer Annonce"/>';
$input_modifier = '<input type="submit" name="btn_modifier" value="Modifier Annonce"/>';

// liaison a la base de donnée
$bdd = connexion($BASE_DE_DONNEE, $SERVEUR, $UTILISATEUR_BDD, $MDP_UTILISATEUR_BDD);

// verifie si l'utilisateur est connécter
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
else // si non on le redirrige
{
    header('Location: ../../index.php?erreur=7');
}

// regarde s'il faut supprimer une photo
if(isset($_REQUEST['photo_supprimer']))
{
    supprimer_photo($_REQUEST['photo_supprimer'], $_REQUEST['id_annonce']); // supprime la photo
}

// deplace les photos dans un dossier
if(isset($_FILES['photos']['error'][0]) && $_FILES['photos']['error'][0] != 4)
{
    $nb = count($_FILES['photos']['name']);
    
    // si le dossier existe on rajoute les photos
    if(dossier_existe('../../img/annonces/' . $_REQUEST['id_annonce'] . '/'))
    {
        for($z=0;$z<$nb ;$z++)
        {
            move_uploaded_file($_FILES['photos']['tmp_name'][$z], '../../img/annonces/'. $_REQUEST['id_annonce'] . '/' . ($z + savoir_nombre_photo_max($_REQUEST['id_annonce'])) . changer_formats($_FILES['photos']['type'][$z]));
        }
    }
    else // si non on crée le dossier
    {
        mkdir('../../img/annonces/' . $_REQUEST['id_annonce']);
        
        for($z=0;$z<$nb;$z++)
        {
            move_uploaded_file($_FILES['photos']['tmp_name'][$z], '../../img/annonces/'. $_REQUEST['id_annonce'] . '/' . $z . changer_formats($_FILES['photos']['type'][$z]));
        }
        
        maj_photo($_REQUEST['id_annonce'], 1, $bdd);
    }
    
}

// verifie si le btn modifier est pressé
if(isset($_REQUEST["btn_modifier"]))
{
    $id_categorie = $_REQUEST['hidden_combobox'];
    
    if($id_categorie == "new" && isset($_REQUEST['tbx_autre']))
    {
        if(verifie_categorie($_REQUEST['tbx_autre'], $bdd))
        {
           $id_categorie = inserer_categorie($_REQUEST['tbx_autre'], $bdd);
        }
        else 
        {
            $id_categorie = 1;
        }
    }
    maj_annonce($_REQUEST['id_annonce'], $_REQUEST["hidden_titre"], $_REQUEST["hidden_prix"], $_REQUEST["hidden_description"], $_REQUEST["hidden_date"], $id_categorie, $bdd);
    header('Location: menu_annonces.php?erreur=14');
}

// on recupere l'id de l'annonce
if(isset($_REQUEST['id_annonce']))
{
    $annonce = recupere_annonces_par_id($_REQUEST['id_annonce'], $bdd); // recupere l'annonce
    
    // verifie si l'annonce existe
    if(!empty($annonce))
    {
        // initialise les variables
        $date = $annonce[0][3];
        $titre = $annonce[0][0];
        $prix = $annonce[0][5];
        $description = $annonce[0][1];
        $photo = $annonce[0][2];

        if($photo == 1) // verifie s'il y a des photos
        {
            $photos = afficher_photo_annonce($_REQUEST['id_annonce']);
        }
        else
        {
            $photos[0] = '<img src="../../img/image_site/No_Image_Available.png" alt="no_image" />';
        }
    }

        $user = recupere_utilisateur_par_id($annonce[0][4], $bdd) ;
        $pseudo_annonceur = $user[0][1];
        $mail = $user[0][1];
}
else
{
    header('Location: ../../index.php?erreur=13');
}

if($annonce[0][4] != $_SESSION['ID'])
{
    header('Location: menu_annonces.php');
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
                
                    <div id="afficher_annonce">
                        <div id="titre_prix">
                            <div id="titre">
                                <input type="text" name="modifier_titre" value="<?php echo $titre; ?>" id="modifier_titre" onchange="copy_input_value(0);" />
                            </div>
                            <div id="prix">
                                <input type="text" name="modifier_prix" value="<?php echo $prix; ?>" id="modifier_prix" onchange="copy_input_value(1);"/>
                            </div>
                        </div>
                        <div id="categorie_annonce">
                            Categorie :
                            <?php echo afficher_combobox_categories(recupere_categories($bdd)); ?>
                            <input type="hidden" name="tbx_autre" id="tbx_autre" onchange="copy_input_value(5);"/>
                        </div>
                        <div id="photos">
                            <div id="photo_principale">
                                <?php echo $photos[0]; ?>
                            </div>
                            <div id="photos_miniatures">
                                <?php
                                    echo afficher_photo_miniature_modifier($photos, $_REQUEST['id_annonce']);
                                ?>
                            </div>
                        </div>
                        <div id="enveloppe_description">
                            <div id="description">
                                <textarea rows="15" cols="40" name="modifier_description" id="modifier_description" onchange="copy_input_value(2);"><?php echo $description; ?></textarea>
                            </div>
                        </div>
                        <div id="va_menu">
                            <fieldset>
                                <legend>Menu</legend>
                                <div>
                                    <form action="confirmer_suppression.php?id=<?php echo $_REQUEST['id_annonce']; ?>" method="post">
                                        <?php echo $input_delete; ?>
                                    </form>
                                </div>
                                <div>
                                    <form action="modifier_annonce.php?id_annonce=<?php echo $_REQUEST['id_annonce']; ?>" method="post">
                                        <?php echo $input_modifier; ?>
                                        <input type="hidden" name="hidden_titre" value="" id="hidden_titre" />
                                        <input type="hidden" name="hidden_prix" value="" id="hidden_prix"/>
                                        <input type="hidden" name="hidden_description" value="" id="hidden_description"/>
                                        <input type="hidden" name="hidden_date" value="" id="hidden_date"/>
                                        <input type="hidden" name="hidden_combobox" value="" id="hidden_combobox"/>
                                    </form>
                                </div>
                            </fieldset>
                        </div>
                        <div id="infos">
                            <div class="info">
                                Pseudo de l'annonceur : <span class="red">
                                <?php echo $pseudo_annonceur; ?>
                                </span>
                            </div>
                            <div class="info">
                                <?php echo '<a href="mailto:' . $mail . '">Contacter l\'anonceur par mail</a>'; ?>
                            </div>
                            <div class="info">
                                <input type='date' name='modifier_date' value='<?php echo  $date; ?>' id="modifier_date" onchange="copy_input_value(3);"/>
                            </div>
                        </div>
                    </div>
            </div>
            <div id="pied_page">
                
            </div>
        </div>
        <script type="text/javascript">
            //Insere ton Javascript ;P
            
            var tbx_titre = document.getElementById("modifier_titre");
            var hidden_titre = document.getElementById("hidden_titre");
            
            var tbx_prix = document.getElementById("modifier_prix");
            var hidden_prix = document.getElementById("hidden_prix");
            
            var txta_description = document.getElementById("modifier_description");
            var hidden_description = document.getElementById("hidden_description");
            
            var tbx_date = document.getElementById("modifier_date");
            var hidden_date = document.getElementById("hidden_date");
            
            var categorie = document.getElementById("cb_categorie");
            var tbx_autre = document.getElementById("tbx_autre");
            var hidden_combobox = document.getElementById("hidden_combobox");
            
            function copy_input_value(mode)
            {
                switch(mode)
                {
                    case 0:
                        hidden_titre.value = "";
                    hidden_titre.value = tbx_titre.value;
                    console.log(hidden_titre);
                        break;
                    case 1:
                    hidden_prix.value = tbx_prix.value;  
                    console.log(hidden_prix.value);
                        break;
                    case 2:
                    hidden_description.value = txta_description.value;  
                    console.log(hidden_description.value);
                        break;
                    case 3:
                    hidden_date.value = tbx_date.value;  
                    console.log(hidden_date.value);
                        break;
                    case 4:
                    tbx_autre.value = categorie.value;
                    hidden_combobox.value = tbx_autre.value;  
                    console.log(hidden_date.value);
                        break;
                    case 5:
                    hidden_combobox.value = tbx_autre.value;  
                    console.log(hidden_date.value);
                        break;
                }
            }
            
            document.onload = copy_input_value(0);
            document.onload = copy_input_value(1);
            document.onload = copy_input_value(2);
            document.onload = copy_input_value(3);
            document.onload = copy_input_value(4);
        </script>
    </body>
</html>