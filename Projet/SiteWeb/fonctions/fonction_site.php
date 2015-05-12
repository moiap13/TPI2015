<?php

/**
 * Permet de fair un var_dump preformater en une ligne
 * -----------------------------------------------------------------------------
 * @param type $var : variable dans laquelle on va regarder
 */
function var_dump_pre($var)
{
    echo '<pre>';
        echo var_dump($var);
    echo '</pre>';
}

/**
 * test une chaine afin de savoir s'il y a des chiffre dedans
 * -----------------------------------------------------------------------------
 * @param type $chaine : chaine a tester
 * @return boolean : retourne oui ou non en fonction de ce qu'il trouve
 */
function contient_chiffre($chaine)
{
    $pathern = '#[^0-9]#';
    
    if(preg_match($pathern,$chaine)) // test la chaine avec le pathern (experssion régulière)
    {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 * permet de decouper une chaine a partir d'un separateur
 * -----------------------------------------------------------------------------
 * @param type $chaine : chaine à tester
 * @param type $separateur : separeteur pour separer les éléments d'une chaine
 * @return tableau :  tableau avec chaques element dans une case 
 */
function couper_avec_separateur($chaine, $separateur)
{
    // déclaration des variables
    $tableau = array();
    $chaine_2 = "";
    
    $i_index = 0;
    
    if($chaine != "" && strlen($chaine) > 0) // test si la chaine est plus grande que 0 et si elle n'est pas vide
    {
        for($i=0;$i< strlen($chaine) ;$i++) // on boucle sur chaques carachtere de la chaine
        {
            if($chaine[$i] != $separateur) // si le carachtere lu est différent du separateur
            {
                $chaine_2 .= $chaine[$i]; // on met ce carachtere dans une variable temporraire 
            }
            else // si le carachtere lu est le separateur 
            {
                $tableau[$i_index] = $chaine_2; // on met le contennu de la variable temporraire dans un tableau avec un index précis
                $chaine_2 = ""; // on remet a vide cette chaine temporraire
                $i_index++; // on incrémente l'indice pour la prochaine étape
            }
        }
    }
    
    return $tableau;
}

/**
 * Coupe une chaine a chaques fois qu'il y a un espace
 * -----------------------------------------------------------------------------
 * @param type $chaine : chaine à tester
 * @return tableau :  tableau avec chaques element dans une case 
 */
function couper_espaces($chaine)
{
    // déclaration des variable
    
    $tableau = array();
    $chaine_2 = "";
    $i_index_chaine = 0;
    
    $i_index = 0;
    
    while(($i_index_chaine = strpos($chaine, ' ')) !== false) // regarde qu'il y ait encore des éspaces
    {
        for($i=0;$i<=$i_index_chaine;$i++)
        {
            if($i != $i_index_chaine && $chaine[$i] != '#')
            {
                $chaine_2 .= $chaine[$i];
            }
            
            $chaine[$i] = '#';
        }
        
        $tableau[$i_index] = $chaine_2;
        $i_index++;
        $chaine_2 = "";
    }
    
    
    return $tableau;
}

/**
 * retourne la date d'ajourd'hui
 * -----------------------------------------------------------------------------
 * @return la date d'aujourd'hui au format Y-m-d
 */
function date_ajourdhui($mode = null)
{
    $date = localtime(time());

    $mois = $date[4]+1;
    $annee = $date[5] + 1900;

    $aujourdhui = mktime(0,0,0,$mois,$date[3],$annee,-1);
    
    return date('Y-m-d', $aujourdhui);  
} 

/**
 * calcule le nombre de jours entre aujourd'hui et une date donnée
 * -----------------------------------------------------------------------------
 * @param type $date_user : date a verifier
 * @return type
 */
function savoir_les_jours_entre_2_dates($date_user)
{
    $date = couper_avec_separateur($date_user,'-');
    
    $annee = $date[0];
    $mois = $date[1];
    $jour = $date[2];

    $date = mktime(0,0,0,$mois,$jour,$annee,-1);
    $date = date('Y-m-d', $date);

    $date = new DateTime($date);
    $aujourdhui = new DateTime(date_ajourdhui());

    $date = $aujourdhui->diff($date,1);
    return $date->format('%a jours');
}

/**
 * calcule le nombre de jours entre aujourd'hui et une date donnée
 * retourne le nombre de jours ains que s'il a reussi a calculer ou pas
 * -----------------------------------------------------------------------------
 * @param type $date_user : date a verifier
 * @return tableau : [0] => le nombre de jours | [1] => s'il a reussi ou pas
 */
function savoir_les_jours_restants($date_user)
{
    $t_jours_mois = array(31,28,31,30,31,30,31,31,30,31,30,31);
    $result[0] = "";
    
    $date = couper_avec_separateur($date_user . '-','-');
    
    $annee = $date[0];
    $mois = $date[1];
    $jour = $date[2];
    
    $annee += 0;
    $mois += 0;
    $jour += 0;
    
    if(($annee - 2012)%4==0)
    {
        $t_jours_mois[1] = 29;
    }
    
    $jour += 15;
    
    if($jour > $t_jours_mois[$mois-1])
    {
        $jour -= $t_jours_mois[$mois-1];
        $mois++;
    }
    
    $date = mktime(0,0,0,$mois,$jour,$annee,-1);
    $date = date('Y-m-d', $date);

    $date = new DateTime($date);
    
    $aujourdhui = date_ajourdhui();
    $aujourdhui = new DateTime($aujourdhui);
    
    $date = $aujourdhui->diff($date);
    
    if($date->format('%R%a') >= 0)
    {
        if($date->format('%R%a') == 0)
        {
            $result[0] = 'Dernier jour de l\'annonce';
        }
        else if($date->format('%R%a') == 1)
        {
            $result[0] = '1 jour restant';
        }
        else
        {
            $result[0] = $date->format('%a jours restants');
        }
        $result[1] = true;
    }
    else 
    {
        $result[0] = 'Annonce Expirée';
        $result[1] = false;
    }
    
    return $result;
}

/**
 * Cahnge le formate entre un $_File et les formats connus pour les images
 * -----------------------------------------------------------------------------
 * @param type $type : valeur du champs format du $_File
 * @return string : le format normal
 */
function changer_formats($type)
{
    $format = "";
    
    switch ($type)
    {
        case 'image/png':
            $format = '.png';
            break;
        case 'image/jpeg':
            $format = '.jpg';
            break;
        case 'image/gif':
            $format = '.gif';
            break;
        case 'image/bmp':
            $format = '.bmp';
            break;
        case 'image/vnd.microsoft.icon':
            $format = '.ico';
            break;
        case 'image/tiff':
            $format = '.tif';
            break;
        case 'image/svg+xml':
            $format = '.svg';
            break;
    }
     
    return $format;
}

/**
 * Lis les fichier d'un dossier et le retorune sous forme de tableau PHP
 * -----------------------------------------------------------------------------
 * @param type $dossier_parametre : dossier a lire
 * @return tableau : avec les fichiers du dossier
 */
function mettre_fichier_dossier_dans_tableau($dossier_parametre)
{
    $tableau = "";
    $i =0;
    
    if ($dossier = opendir($dossier_parametre)) 
    {
        while (false !== ($fichier = readdir($dossier))) 
        {
            if ($fichier != "." && $fichier != ".." && $fichier != ".DS_Store") 
            {
                $tableau[$i] = $fichier;
                $i++;
            }
        }
        
        closedir($dossier);
    }
    
    return $tableau;
}

/**
 * Verifie si un dossier existe
 * --------------------------------------------------------------------
 * @param type $dossier : dossier a verifier
 * @return boolean :  retourne true si le dossier existe false si non
 */
function dossier_existe($dossier)
{
    $result = false;
    
    if(file_exists($dossier) && is_dir($dossier))
        $result = true;
    
    return $result;
}
function supprimer_photo($nom_photo, $id_annonce)
{
    if(file_exists('../../img/annonces/' . $id_annonce . '/' . $nom_photo))
    {
        unlink('../../img/annonces/' . $id_annonce . '/' . $nom_photo);
    }
}

function supprimer_photo_avatar($nom_photo)
{
    if(file_exists($nom_photo))
    {
        unlink($nom_photo);
    }
}

function efface_dossier($dossier)
{
    $result = false;
    
    if(dossier_existe($dossier))
    {
        rmdir($dossier);
        $result = true;
    }
    
    return $result;
}

/**
 * Lis un tableau et regarde s'il y des doublons si oui il les supprime afin 
 * d'avoir uniquement des données unique
 * -----------------------------------------------------------------------------
 * @param type $tableau : tableau a verifier
 * @return tableau : tableau unique
 */
function copie_donnee_unique($tableau)
{
    $tableau_result[0] = $tableau[0];
    
    for($i=0;$i<count($tableau);$i++)
    {
        $b_ajout = true;
        
        for($y=0;$y<count($tableau_result);$y++)
        {
            if($tableau[$i] == $tableau_result[$y])
            {
                $b_ajout = false;
            }
        }
        
        if($b_ajout)
        {
            $tableau_result[count($tableau_result)] = $tableau[$i];
        }
    }
    
    return $tableau_result;
}

/**
 * Permet de supprimer une photo d'une annonce
 * ----------------------------------------------------------------------------
 * @param type $nom_photo : le nom de la photo a supprimer
 * @param type $id_annonce : l'id est utiliser comme nom de dossier
 */
function supprimer_photo_annonce($nom_photo, $id_annonce)
{
    if(file_exists('../../img/annonces/' . $id_annonce . '/' . $nom_photo))
    {
        unlink('../../img/annonces/' . $id_annonce . '/' . $nom_photo);
    }
}

/**
 * Lis un dossier et retourne le nombres d'élements
 * -----------------------------------------------------------------------------
 * @param type $id_annonce : l'id est utilisé comme nom de dossier
 * @return max_num : int avec le nombre de fichiers dans le dossier
 */
function savoir_nombre_photo_max($id_annonce)
{
    $tableau = mettre_fichier_dossier_dans_tableau('../../img/annonces/' . $id_annonce . '/');
    $max_num = couper_avec_separateur($tableau[0] . '.', '.')[0];
    
    for($i=0;$i<count($tableau);$i++)
    {
        $tableau[$i] = couper_avec_separateur($tableau[$i] . '.', '.')[0];
        
        if($tableau[$i] > $max_num)
        {
            $max_num = $tableau[$i];
        }
    }
    
    return $max_num+1;
}

/**
 * En fonction d'un chiffre la fonction retourne une érreure
 * -----------------------------------------------------------------------------
 * @param type $erreur : chiffre de l'eurreure
 * @return type : retourne un alerte javascript avec l'erreur
 */
function afficher_erreur($erreur)
{
    switch ($erreur)
    {
        case 0:
            $result = "MDP ou Pseudo non entré";
            break;
        case 1:
            $result = "MDP ou Pseudo Faux";
            break;
        case 2:
            $result = "Les mots de passes ne concordent pas";
            break;
        case 3:
            $result = "Les mots de passes sont vide";
            break;
        case 4:
            $result = "Le nom est vide";
            break;
        case 5:
            $result = "Le prénom est vide";
            break;
        case 6:
            $result = "Pseudo vide";
            break;
        case 7:
            $result = "Vous devez être connecter";
            break;
        case 8:
            $result = "Pseudo indisponible";
            break;
        case 9:
            $result = "Email non valide";
            break;
        case 10:
            $result = "Email non disponible";
            break;
        case 11:
            $result = "Inscription échouée";
            break;
        case 12:
            $result = "Impossible de supprimer le dossier";
            break; 
        case 13:
            $result = "Aucune annonce a modifier";
            break; 
        case 14:
            $result = "Annonce modifiée correctement";
            break; 
        case 15:
            $result = "Annonce correctement supprimée";
            break;
        case 16:
            $result = "Categorie modifiée correctement";
            break; 
        case 17:
            $result = "Categorie correctement supprimée";
            break;
        case 18:
            $result = "Annonce rendue active";
            break;
        case 19:
            $result = "Utilisateur correctement supprimer";
            break;
        case 20:
            $result = "Utilisateur correctement changé de statut";
            break;
        case 21:
            $result = "vous devez être admin";
            break;
        case 22:
            $result = "annonce activée";
            break;
        case 23:
            $result = "annonce désactivée";
            break;
    }
    
    return $affichage = '<script type="text/javascript">alert("' . $result . '");</script>';
}

function creer_menu_admin($chemin)
{
    $affichage = "";
    
    $affichage .= '<ul id="menu-deroulant">';
	$affichage .= '<li><img src="'.$chemin.'img/image_site/bouton_menu.png" width="10" height="10"/> Gestion du site ';
		$affichage .= '<ul>';
			$affichage .= '<li><a href="'.$chemin.'pages/gestion/gestion_utilisateur.php">Gestion utilisateurs</a></li>';
			$affichage .= '<li><a href="'.$chemin.'pages/gestion/gestion_annonces.php">Gestion annonces</a></li>';
			$affichage .= '<li><a href="'.$chemin.'pages/gestion/gestion_categorie.php">Gestion catégories</a></li>';
		$affichage .= '</ul>';
	$affichage .= '</li>';
    $affichage .= '</ul>';
    
    return $affichage;
}
function verifie_categorie($name, $bdd)
{
    $array = recupere_categories($bdd);
    $return = true;
    
    for($i=0;$i<count($array);$i++)
    {
        if($array[$i][1] == $name)
        {
            $return = false;
        }
    }
    
    return $return;
}

function convertir_statut($statut)
{
    if($statut == 0)
    {
        return 'Utilisateur';
    }
    else if($statut == 1)
    {
        return 'Admin';
    }
        
        
}