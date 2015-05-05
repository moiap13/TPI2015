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
                $affichage .= '<div class="affichage_categorie">';
                $affichage .= '<p><a href="pages/recherche.php?index_categorie=' . $tableau[$i][1] . '">' . $tableau[$i][1] . '</a></p>';
                $affichage .= '</div>';
            }
        }
        else if($mode == 1)
        {
            for($i=0;$i<count($tableau);$i++)
            {
                $affichage .= '<div class="affichage_categorie">';
                $affichage .= '<p><a href="../recherche.php?index_categorie=' . $tableau[$i][1] . '">' . $tableau[$i][1] . '</a></p>';
                $affichage .= '</div>';
            }
        }
        else if($mode == 2)
        {
            for($i=0;$i<count($tableau);$i++)
            {
                $affichage .= '<div class="affichage_categorie">';
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

/*******************************************************************************
*************** FONCTIONS AFFICHAGE POUR LA PAGE MENU ANNONCES *****************
*******************************************************************************/
function afficher_combobox_categories($tableau)
{
    $affichage = '';
         
    $affichage = '<select name="categorie" id="cb_categorie" onchange="test(this.value)">';

    for ($i=0;$i < count($tableau);$i++)
    {
        $affichage .= '<option value="' . $tableau[$i][0] . '">'. $tableau[$i][1] .'</option>';
    }
     
    $affichage .= '<option value="new">Autre</option>';
    $affichage .= '</select>';
    
    return $affichage;
}

function affichage_annonces_utilisateur($tableau)
{     
    $affichage = '';
    
    if(!empty($tableau))
    {
        for($i=0;$i<count($tableau);$i++)
        {
            $affichage .=   '<div class="user_annonces_table">' . 
                                '<div class="photo_user_annonce">';
            if($tableau[$i][4] == 1)
            {
                $str = put_dirfile_array('../../img/annonces/' . $tableau[$i][0] . '/');
                $file_type = split_separator($str[0] . '.', '.');

                $affichage .= '<a href="./afficher_annonce.php?id_annonce='. $tableau[$i][0] .'" ><img src="'. '../../img/annonces/' . $tableau[$i][0] . '/0.' . $file_type[1] .'" width="100px" height="100px" /></a>';
            }
            else
            {
                $affichage .= '<a href="./afficher_annonce.php?id_annonce='. $tableau[$i][0] .'" ><img src="../../img/image_site/No_Image_Available.png" width="100px" height="100px" /></a>';
            }

             $affichage .= '</div>'.
                     '<div class="menu_rapide">' .
                      '<div><a href="confirm_delete.php?id_ads='.$tableau[$i][0].'">x</a></div>' .
                        '<div><a href="modifier_annonce.php?id_annonce='. $tableau[$i][0] .'">✍</a></div>' .
                      '</div>' .
                        '<div class="titre_user_annonce"><a href="./view_annonce.php?id_annonce='. $tableau[$i][0] .'" >'. $tableau[$i][1] .'</a></div>'.
                     
                        '<div class="date_user_annonces">'. $tableau[$i][2] .'</div>' .
                        '<div class="date_user_annonces">'. savoir_les_jours_restants($tableau[$i][2] . '-')[0] .'</div>' .
                        
                    '</div>';
        }
    }
    else
    {
        $affichage = '<p class="warning_message">Vous n\'avez aucune annonces postée</p>';
    }
    
    return $affichage;
}

function afficher_annonce($tableau, $id, $input_favoris, $bdd)
{         
    $affichage = "";
            
    if(!empty($tableau))
    {
        if(savoir_les_jours_restants($tableau[0][3])[1] == false)
        {
            $titre = '<p class="warning_message">Cette annonce n\'est plus disponible...</p>';
            $description = "";
            $photos[0] = "";
        }
        else
        {
            $titre = $tableau[0][0];
            $description = $tableau[0][1];
            $photo = $tableau[0][2];
            $date = $tableau[0][3];
            $prix = $tableau[0][4];

            if($photo == 1)
            {
                $photos = display_photo_afficher_annonce($id);
            }
            else
            {
                $photos[0] = '<img src="../../img/image_site/No_Image_Available.png" alt="no_image" />';
            }
        }

        $user = recupere_utilisateur_par_id($tableau[0][4], $bdd) ;
        $pseudo_annonceur = $user[0][0];
        $mail = $user[0][1];
    }
    else
    {
        $titre = '<p class="warning_message">Cette annonce est indisponible...</p>';
        $description = "";
        $photos[0] = "";
        $pseudo_annonceur = 'Indisponible';
        $mail = "";
        $date = "Indisponible";
    }
    
    $affichage .= '<div id="afficher_annonce"><div id="titre_prix"><div id="titre">';
    $affichage .= $titre;
    $affichage .= '</div><div id="prix">Prix :';
    $affichage .= $prix;
    $affichage .= '</div></div><div id="photos"> <div id="photo_principale">';
    $affichage .= $photos[0];
    $affichage .= '</div><div id="photos_miniatures">';
    
    if($photos[count($photos)-1] == 'multi')
    {
        $affichage .= display_photo_miniatures($photos);
    }
    
    $affichage .= '</div></div><div id="enveloppe_description"><div id="description">';
    $affichage .= $description;
    $affichage .= '</div></div><div id="va_menu"><fieldset><legend>Menu</legend><div><form action="#" method="post">';
    $affichage .= $input_favoris;
    $affichage .= '</form></div></fieldset></div><div id="infos"><div class="info">Pseudo de l\'annonceur : <span class="red">';
    $affichage .= $pseudo_annonceur;
    $affichage .= '</span></div><div class="info">';
    $affichage .= '<a href="mailto:' . $mail . '">Contacter l\'anonceur par mail</a>';
    $affichage .= '</div><div class="info">'; 
    $affichage .= 'annonce parrue le : <span class="red">' . $date . '</span>';
    $affichage .= '</div></div></div>';
    
    return $affichage;
}