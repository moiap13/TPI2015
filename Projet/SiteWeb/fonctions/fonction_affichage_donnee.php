<?php

/*******************************************************************************
*********************** FONCTIONS AFFICHAGE POUR LE SITE ***********************
*******************************************************************************/

/**
 * 
 * @param type $array
 * @param type $mode
 * @return string
 */
function afficher_categories($tableau, $mode)
{
    $affichage = "";
    
    if($tableau != false)
    {
        if($mode == 0)
        {
            for($i=0;$i<count($tableau);$i++)
            {
                $affichage .= '<div class="display_categorie">';
                $affichage .= '<p><a href="pages/recherche.php?index_categorie=' . $tableau[$i][1] . '">' . $tableau[$i][1] . '</a></p>';
                $affichage .= '</div>';
            }
        }
        else if($mode == 1)
        {
            for($i=0;$i<count($tableau);$i++)
            {
                $affichage .= '<div class="display_categorie">';
                $affichage .= '<p><a href="../recherche.php?index_categorie=' . $tableau[$i][1] . '">' . $tableau[$i][1] . '</a></p>';
                $affichage .= '</div>';
            }
        }
        else if($mode == 2)
        {
            for($i=0;$i<count($tableau);$i++)
            {
                $affichage .= '<div class="display_categorie">';
                $affichage .= '<p><a href="recherche.php?index_categorie=' . $tableau[$i][1] . '">' . $tableau[$i][1] . '</a></p>';
                $affichage .= '</div>';
            }
        }
    }
    else
    {
        $affichage = '<p class="warning_message">Aucune catégorie à afficher</p>';
    }
    
    return $affichage;
}

/*******************************************************************************
******************* FONCTIONS AFFICHAGE POUR LA PAGE INDEX *********************
*******************************************************************************/


function afficher_photo_dernieres_annonces_postees($tableau)
{  
    $affichage = '';
    $nb_annonces = 0;
    
    if(!empty($tableau))
    {
        for($i=0;$i<4;$i++)
        {
            if(isset($tableau[$i]))
            {
                if(get_days_remaning($tableau[$i][2])[1])
                {
                    if(dir_exist('img/annonces/' . $tableau[$i][0])  && $tableau[$i][3] == 1)
                    {
                        $str = put_dirfile_array('img/annonces/' . $tableau[$i][0] . '/');

                        $file_type = split_separator($str[0] . '.', '.');

                        $affichage .= '<div class="derniere_annonce"><a href="pages/annonces/view_annonce.php?id_annonce='. $tableau[$i][0] .'" ><img src="img/annonces/' . $tableau[$i][0] . '/0.' . $file_type[1] .'"/></a></div>';

                    }
                    else
                    {
                        $affichage .= '<div class="derniere_annonce"><a href="pages/annonces/view_annonce.php?id_annonce='. $tableau[$i][0] .'" ><img src="img/image_site/No_Image_Available.png" width="100px" height="100px" /></a></div>';
                    }
                    $nb_annonces++;
                }
            }
        }
        
        if($nb_annonces == 0)
        {
            $affichage = '<p class="warning_message">Aucune annonce à afficher</p>';
        }
    }
    else
    {
       $affichage = '<p class="warning_message">Aucune annonce à afficher</p>'; 
    }
    
    
    return $affichage;
}

function afficher_dernieres_annonces_postees($tableau)
{
    $affichage = '';
    $nb_annonces = 0;
    
    if(!empty($tableau))
    {
        for($i=0;$i<4;$i++)
        {
            if(isset($tableau[$i]))
            {
                if(get_days_remaning($tableau[$i][2])[1])
                {
                    $affichage .= '<div class="titre_derniere_annonce">';
                    $affichage .= '<a href="pages/annonces/view_annonce.php?id_annonce='. $tableau[$i][0] .'" >' . $tableau[$i][1] . '</a>';
                    $affichage .= '</div>';
                    $nb_annonces++;
                }
            }
        }
    }
    return $affichage;
}