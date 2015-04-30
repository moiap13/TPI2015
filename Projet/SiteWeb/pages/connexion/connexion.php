<?php
session_start();
session_destroy();
session_start();

include '../../fonctions/fonction_site.php';
include '../../fonctions/fonction_bdd.php';
include '../../fonctions/fonction_lecture_donnee.php';
include '../../fonctions/fonction_affichage_donnee.php';
include '../../fonctions/fonction_connexion.php';
include '../../parametres/parametres.php';

$login = false;
$users = '';
$password = '';

if(isset($_REQUEST['erreur']))
{
    echo afficher_erreur($_REQUEST['erreur']);
}

if(isset($_REQUEST["tbxusers"]) == true && $_REQUEST["tbxusers"] != '')
{
    $users = $_REQUEST["tbxusers"];
}
else
{
    $users = "";
}

if(isset($_REQUEST["tbxpassword"]) == true && $_REQUEST["tbxpassword"] != '')
{
    $password = $_REQUEST["tbxpassword"];
}
else
{
    $password = "";
}

if($users != '' && $password != '' && isset($_REQUEST['btnlogin']))
{
    header("Location: login.php?login=true&user=$users&mdp=$password");
}
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
            <div id="div_log">
                <form action="#" method="post">
                    <div id="div_table">
                        <div class="ligne"><div id="titre_table">Login</div></div>
                        <div class="ligne"><div class="cellule">User ID / e-mail</div><div class="deux_points">:</div><div class="cellule"><input type="text" name="tbxusers" value="<?php echo "$users"; ?>" /></div></div>
                        <div class="ligne"><div class="cellule">PassWord</div><div class="deux_points">:</div><div class="cellule"><input type="password" name="tbxpassword" value="" id="tbx_pwd"/></div></div>
                        <div class="ligne"><div class="cellule">Afficher MDP</div><div class="deux_points">:</div><div class="cellule"><input type="checkbox" name="ckb_show_pwd" id="ckb" onclick="showPwd();"/></div></div>
                        <div class="ligne"><input type="submit" name="btnlogin" value="Login" /></div>
                        <div class="ligne"><a href="inscription.php">S'inscrire ici</a></div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>