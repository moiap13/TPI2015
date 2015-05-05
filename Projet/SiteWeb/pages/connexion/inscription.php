<?php
session_start();

include '../../fonctions/fonction_site.php';
include '../../fonctions/fonction_bdd.php';
include '../../fonctions/fonction_lecture_donnee.php';
include '../../fonctions/fonction_affichage_donnee.php';
include '../../fonctions/fonction_connexion.php';
include '../../parametres/parametres.php';

$bdd = connexion($BASE_DE_DONNEE, $SERVEUR, $UTILISATEUR_BDD, $MDP_UTILISATEUR_BDD);

$nom = (isset($_REQUEST['tbxnom'])?$_REQUEST['tbxnom']:"");
$prenom = (isset($_REQUEST['tbxprenom'])?$_REQUEST['tbxprenom']:"");
$pseudo = (isset($_REQUEST['tbxpseudo'])?$_REQUEST['tbxpseudo']:"");
$email = (isset($_REQUEST['tbxemail'])?$_REQUEST['tbxemail']:"");



if(isset($_REQUEST['erreur']))
{
    echo afficher_erreur($_REQUEST['erreur']);
}

if(isset($_REQUEST["btninscr"]) == true) 
{
    
    if(filter_input(INPUT_POST, "tbxemail", FILTER_VALIDATE_EMAIL))
    {var_dump_pre($pseudo);
        $sql = 'select idUtilisateur from utilisateur where Email = :mail';
        $requete = $bdd->prepare($sql);
        $requete->execute(array(':mail' => $_REQUEST['tbxemail']));
        $pseudo = $requete->fetchAll();

        if(empty($pseudo))
        {
            verifie_formulaire($_REQUEST, $bdd);
        }
        else
        {
            echo afficher_erreur(10);
        }
    }
    else
    {
        echo afficher_erreur(9);
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
        <link href="../../css/style_login.css" rel="stylesheet" type="text/css" />
        <script src="../../javascript/fonction_globales.js"></script>
    </head>
    <body>
        <?php
            // insère ton gros code ici Antonio ;P
        ?>
        <div id="principal">
            <div id="banniere">
                <div class="div_banniere"><p id="display_user"></p></div>
                <div class="div_banniere">
                </div>
                <div class="div_banniere"><p id="titre_site"><a href="../../index.php">AnnoLigne<br/>Site d'annonce en ligne</a></p></div>
                <div class="div_banniere">
                </div>
                <div class="div_banniere">
                    <a href="../../index.php">Revennir sur la page d'accueil<br/>Site d'annonce en ligne</a>
                </div>
            </div>
            <div id="inscription">
                <form action="inscription.php" method="post">
                    <div id='div_table'>
                        <div class='ligne'><div id="titre_table">Inscription</div></div>
                        <div class='ligne'>
                            <div class="cellule">Nom</div>
                            <div class="deux_points">:</div>
                            <div class="cellule"><input type="text" name="tbxnom" value="<?php echo $nom; ?>" required/></div>
                        </div>
                        <div class='ligne'>
                            <div class="cellule">Prénom</div>
                            <div class="deux_points">:</div>
                            <div class="cellule"><input type="text" name="tbxprenom" value="<?php echo $prenom; ?>" required/></div>
                        </div>
                        <div class='ligne'>
                            <div class="cellule">Pseudo</div>
                            <div class="deux_points">:</div>
                            <div class="cellule"><input type="text" name="tbxpseudo" value="<?php echo $pseudo; ?>" required/></div>
                        </div>
                        <div class='ligne'>
                            <div class="cellule">E-Mail</div>
                            <div class="deux_points">:</div>
                            <div class="cellule"><input type="email" name="tbxemail" value="<?php echo $email; ?>" required/></div>
                        </div>
                        <div class='ligne'>
                            <div class="cellule">MDP</div>
                            <div class="deux_points">:</div>
                            <div class="cellule"><input type="password" name="tbxmdp" value="" id="tbx_pwd" required/></div>
                        </div>
                        <div class='ligne'>
                            <div class="cellule">Confirmer MDP</div>
                            <div class="deux_points">:</div>
                            <div class="cellule"><input type="password" name="tbxmdp_2" value="" id="tbx_pwd_2" required/></div>
                        </div>
                        <div class='ligne'>
                           <div class="cellule">ShowPwd</div>
                           <div class="deux_points">:</div>
                           <div class="cellule"><input type="checkbox" name="ckb_show_pwd" id="ckb" onclick="showPwd();"/></div>
                        </div>
                        <div class='ligne'>   
                            <input type="submit" name="btninscr" value="S'inscrire" />
                        </div>
                        <div class='ligne'>  
                            <a href="login.php">Retourner au login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>