<?php

/*******************************************************************************
*********************** FONCTIONS AFFICHAGE POUR LE SITE ***********************
*******************************************************************************/

/**
 * 
 * @param type $tableau
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
    $max_annonce = 4;
    
    if(!empty($tableau))
    {
        for($i=0;$i<$max_annonce;$i++)
        {
            if(isset($tableau[$i]))
            {
                $jours = savoir_les_jours_restants($tableau[$i][2])[0];
                $jours = $jours[0] . $jours[1];
                
                if(savoir_les_jours_restants($tableau[$i][2])[1] && $jours <= 15)
                {
                    if(dossier_existe('img/annonces/' . $tableau[$i][0])  && $tableau[$i][3] == 1)
                    {
                        $str = mettre_fichier_dossier_dans_tableau('img/annonces/' . $tableau[$i][0] . '/');

                        $file_type = couper_avec_separateur($str[0] . '.', '.');

                        $affichage .= '<div class="derniere_annonce"><a href="pages/annonces/afficher_annonce.php?id_annonce='. $tableau[$i][0] .'" ><img src="img/annonces/' . $tableau[$i][0] . '/0.' . $file_type[1] .'"/></a></div>';

                    }
                    else
                    {
                        $affichage .= '<div class="derniere_annonce"><a href="pages/annonces/afficher_annonce.php?id_annonce='. $tableau[$i][0] .'" ><img src="img/image_site/No_Image_Available.png" width="100px" height="100px" /></a></div>';
                    }
                    $nb_annonces++;
                }
                else
                {
                    $max_annonce++;
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
    $max_annonce = 4;
    
    if(!empty($tableau))
    {
        for($i=0;$i<$max_annonce;$i++)
        {
            if(isset($tableau[$i]))
            {
                $jours = savoir_les_jours_restants($tableau[$i][2])[0];
                $jours = $jours[0] . $jours[1];
                
                if(savoir_les_jours_restants($tableau[$i][2])[1] && $jours <= 15)
                {
                    $affichage .= '<div class="titre_derniere_annonce">';
                    $affichage .= '<a href="pages/annonces/afficher_annonce.php?id_annonce='. $tableau[$i][0] .'" >' . $tableau[$i][1] . ' - ' .  $tableau[$i][4] . '</a>';
                    $affichage .= '</div>';
                    $nb_annonces++;
                }
                else
                {
                    $max_annonce++;
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
         
    $affichage = '<select name="categorie" id="cb_categorie" onchange="test(this.value); copy_input_value(4);">';

    for ($i=0;$i < count($tableau);$i++)
    {
        $affichage .= '<option value="' . $tableau[$i][0] . '">'. $tableau[$i][1] .'</option>';
    }
    
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
            if($i%2==0)
                $pair = "";
            else
                $pair = 1;
                
            $affichage .=   '<div class="user_annonces_table' . $pair . '">' . 
                                '<div class="photo_user_annonce">';
            
            if($tableau[$i][4] == 1)
            {
                $str = mettre_fichier_dossier_dans_tableau('../../img/annonces/' . $tableau[$i][0] . '/');
                $file_type = couper_avec_separateur($str[0] . '.', '.');

                $affichage .= '<a href="./afficher_annonce.php?id_annonce='. $tableau[$i][0] .'&droit=proprietaire" ><img src="'. '../../img/annonces/' . $tableau[$i][0] . '/0.' . $file_type[1] .'" width="100px" height="100px" /></a>';
            }
            else
            {
                $affichage .= '<a href="./afficher_annonce.php?id_annonce='. $tableau[$i][0] .'&droit=proprietaire" ><img src="../../img/image_site/No_Image_Available.png" width="100px" height="100px" /></a>';
            }

            $affichage .= '</div>'.
                     '<div class="menu_rapide">' .
                      '<div><a href="confirmer_suppression.php?id='.$tableau[$i][0].'&droit=proprietaire">x</a></div>' .
                        '<div><a href="modifier_annonce.php?id_annonce='. $tableau[$i][0] .'">✍</a></div>' .
                      '</div>' .
                        '<div class="titre_user_annonce"><a href="./afficher_annonce.php?id_annonce='. $tableau[$i][0] .'&droit=proprietaire" >'. $tableau[$i][1] .'</a></div>'.
                     
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
/*******************************************************************************
************* FONCTIONS AFFICHAGE POUR LA PAGE AFFICHER ANNONCES ***************
*******************************************************************************/
function afficher_annonce($tableau, $id, $bdd)
{         
    $affichage = "";
            
    if(!empty($tableau))
    {
        
        if(savoir_les_jours_restants($tableau[0][3])[1] == false)
        {
            $titre = '<span class="warning_message">Cette annonce n\'est plus disponible...</span>';
            $description = "";
            $photos[0] = "";
        }
        else
        {
            $titre = $tableau[0][0];
            $description = $tableau[0][1];
            $photo = $tableau[0][2];
            $date = $tableau[0][3];
            $prix = $tableau[0][5];
            $categorie = recupere_categories_par_id($tableau[0][7], $bdd)[0][0];
            
            if($photo == 1)
            {
                $photos = afficher_photo_annonce($id);
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
        $titre = '<span class="warning_message">Cette annonce est indisponible...</span>';
        $description = "";
        $photos[0] = "";
        $pseudo_annonceur = 'Indisponible';
        $mail = "";
        $date = "Indisponible";
        $prix = '<span class="warning_message">Indisponible</span>';
        $categorie = '';
    }
    
    $affichage .= '<div id="afficher_annonce"><div id="titre_prix"><div id="titre">';
    $affichage .= $titre;
    $affichage .= '</div><div id="prix">Prix :';
    $affichage .= $prix;
    $affichage .= '</div></div><div id="categorie_annonce">';
    $affichage .= $categorie;
    $affichage .= '</div><div id="photos"> <div id="photo_principale">';
    $affichage .= $photos[0];
    $affichage .= '</div><div id="photos_miniatures">';
    
    if($photos[count($photos)-1] == 'multi')
    {
        $affichage .= afficher_photo_miniatures($photos);
    }
    
    $affichage .= '</div></div><div id="enveloppe_description"><div id="description">';
    $affichage .= $description;
    $affichage .= '</div></div><div id="infos"><div class="info">Pseudo de l\'annonceur : <span class="red">';
    $affichage .= $pseudo_annonceur;
    $affichage .= '</span></div><div class="info">';
    $affichage .= '<a href="mailto:' . $mail . '">Contacter l\'anonceur par mail</a>';
    $affichage .= '</div><div class="info">'; 
    $affichage .= 'annonce parrue le : <span class="red">' . $date . '</span>';
    $affichage .= '</div></div></div>';
    
    return $affichage;
}

function afficher_photo_annonce($id_annonce)
{
    if(dossier_existe('../../img/annonces/' . $id_annonce))
    {
        $a_images = mettre_fichier_dossier_dans_tableau('../../img/annonces/' . $id_annonce . '/');

        for($i=0;$i<count($a_images);$i++)
        {
            $photos[$i] = '<img src="../../img/annonces/' . $id_annonce . '/' . $a_images[$i] .'"/>';
        }
    }
    
    if(count($photos) > 1)
    {
        $photos[count($photos)] = 'multi';
    }
    else
    {
        $photos[count($photos)] = 'single';
    }
    
    return $photos;
}

function afficher_photo_miniatures($tableau)
{
    $affichage = '';
    
    for($i=1;$i<count($tableau)-1;$i++)
    {
        $affichage .= '<div class="img_miniature" name="miniature_' . $i . '" onclick="change_photo(this)">';
            $affichage .= $tableau[$i];
        $affichage .= '</div>';
    }
    
    return $affichage;
}
/*******************************************************************************
************* FONCTIONS AFFICHAGE POUR LA PAGE MODIFIER ANNONCES ***************
*******************************************************************************/
function afficher_photo_miniature_modifier($tableau, $id_annonce)
{
    $affichage = '';
    if(dossier_existe('../../img/annonces/' . $id_annonce))
    {
        $a_images = mettre_fichier_dossier_dans_tableau('../../img/annonces/' . $id_annonce . '/');
    
        for($i=1;$i<count($tableau)-1;$i++)
        {
            $affichage .= '<div class="gp_miniature"><div class="modifier_img_miniature">';
                $affichage .= $tableau[$i];
            $affichage .= '</div>';
            $affichage .= '<div class="supprimer_photo_miniature"><a href="modifier_annonce.php?id_annonce='.$id_annonce.'&photo_supprimer='. $a_images[$i] . '">x</a></div></div>';
        }
    }
    $affichage .=   '<div class="gp_miniature">' .
                        '<form action="modifier_annonce.php?id_annonce='.$id_annonce.'" method="post" enctype="multipart/form-data">' .
                            '<input type="file" name="photos[]" multiple onchange="this.form.submit();"/><br/>' .
                        '</form>' .
                    '</div>';
    return $affichage;
}
function afficher_annonces_gestion_annonce($tableau)
{
    $affichage = "";
    $i_index = 0;
    
    $nb_annonces = count($tableau);
    
    $nb_ligne = $nb_annonces / 3;
    
    
    if(!empty($tableau))
    {
        for($i=0;$i<$nb_ligne;$i++)
        {
            $affichage .= '<div class="ligne_gestion">';

            for($y=0;$y<3;$y++)
            {
                if(isset($tableau[$i_index]))
                {
                    if($y==0)
                        $affichage .= '<div class="gestion_table">';
                    else
                        $affichage .= '<div class="gestion_table1">';

                    $affichage .= '<div class="photo_gestion">';

                    if($tableau[$i_index][3] == 1)
                    {
                        $str = mettre_fichier_dossier_dans_tableau('../../img/annonces/' . $tableau[$i_index][0] . '/');
                        $file_type = couper_avec_separateur($str[0] . '.', '.');

                        $affichage .= '<a href="../annonces/afficher_annonce.php?id_annonce='. $tableau[$i_index][0] .'&droit=admin" ><img src="'. '../../img/annonces/' . $tableau[$i_index][0] . '/0.' . $file_type[1] .'" width="100px" height="100px" /></a>';
                    }
                    else
                    {
                        $affichage .= '<a href="../annonces/afficher_annonce.php?id_annonce='. $tableau[$i_index][0] .'&droit=admin" ><img src="../../img/image_site/No_Image_Available.png" width="100px" height="100px" /></a>';
                    }
                    $affichage .= '</div>'.

                    '<div class="titre_gestion"><a href="../annonces/afficher_annonce.php?id_annonce='. $tableau[$i_index][0] .'&droit=admin" >'. $tableau[$i_index][1] .'</a></div>'.

                    '<div class="description_gestion">'. $tableau[$i_index][2] .'</div>' .
                    '<div class="form_gestion">'
                            . '<form action="../annonces/confirmer_suppression.php?id='. $tableau[$i_index][0].'&droit=admin" method="post"><input type="submit" name="btn_supprimer" value="Suprimer" /></form>'
                            . '<form action="gestion_annonces.php?id_annonce='. $tableau[$i_index][0].'" method="post"><input type="submit" name="btn_activer" value="Rendre active" /></form>'
                    . '</div></div>';


                    $i_index++;
                }

            }

            $affichage .= "</div>";
        }
    }
    else
    {
        $affichage = '<p class="warning_message">Aucune Annonces à afficher</p>';
    }
    
    return $affichage;
}

function afficher_categories_gestion_categorie($tableau, $bdd)
{
    $affichage = "";
    $i_index = 0;
    
    $nb_categories = count($tableau);
    
    $nb_ligne = $nb_categories / 3;
    
    if(!empty($tableau))
    {
        for($i=0;$i<$nb_ligne;$i++)
        {
            $affichage .= '<div class="ligne_gestion">';

            for($y=0;$y<4;$y++)
            {
                if(isset($tableau[$i_index]))
                {
                    if($y==0)
                        $affichage .= '<div class="gestion_table_categorie">';
                    else
                        $affichage .= '<div class="gestion_table1_categorie">';

                    $affichage .= '<div class="titre_gestion_categorie"><a href="../recherche/recherche.php?categorie='. $tableau[$i_index][0] .'" >'. $tableau[$i_index][1] .' - ' . recupere_nb_annonce_par_categorie($tableau[$i_index][0], $bdd) . '</a></div>'.

                    '<div class="description_gestion_categorie">'. $tableau[$i_index][2] .'</div>' .
                    '<div class="form_gestion_categorie">'
                            . '<form action="../categorie/confirmer_suppression_categorie.php?id='. $tableau[$i_index][0].'" method="post"><input type="submit" name="btn_supprimer" value="Suprimer" /></form>'
                            . '<form action="../categorie/modifier_categorie.php?id='. $tableau[$i_index][0].'" method="post"><input type="submit" name="btn_modifier" value="modifier" /></form>'
                    . '</div></div>';


                    $i_index++;
                }

            }

            $affichage .= "</div>";
        }
    }
    else
    {
        $affichage = '<p class="warning_message">Aucune Annonces à afficher</p>';
    }
    
    return $affichage;
}

function afficher_utilisateur_gestion($tableau)
{
    $affichage = "";
    $i_index = 0;
    
    $nb_utilisateurs = count($tableau);
    
    $nb_ligne = $nb_utilisateurs / 3;
    
    
    if(!empty($tableau))
    {
        for($i=0;$i<$nb_ligne;$i++)
        {
            $affichage .= '<div class="ligne_gestion">';
            for($y=0;$y<3;$y++)
            {
                if(isset($tableau[$i_index]))
                {
                    if($y==0)
                        $affichage .= '<div class="gestion_table">';
                    else
                        $affichage .= '<div class="gestion_table1">';

                    $affichage .= '<div class="photo_gestion">';

                    if($tableau[$i_index][3] == 1)
                    {
                        $str = mettre_fichier_dossier_dans_tableau('../../img/avatar/' . $tableau[$i_index][0] . '/');

                        $affichage .= '<a href="" ><img src="'. '../../img/avatar/' . $tableau[$i_index][0] . '/' . $str[0] . '" width="100px" height="100px" /></a>';
                    }
                    else
                    {
                        $affichage .= '<a href="" ><img src="../../img/image_site/avatar.jpeg" width="100px" height="100px" /></a>';
                    }
                    $affichage .= '</div>'.

                    '<div class="titre_gestion"><a href="" >'. $tableau[$i_index][1] . ' - ' . convertir_statut($tableau[$i_index][2]) . '</a></div>'.

                    '<div class="description_gestion">Nombre d\'annonnces : <label class="nom_categorie">' . $tableau[$i_index][4] .'</label></div>' .
                    '<div class="form_gestion">'
                            . '<form action="../connexion/confirmer_suppression_utilisateur.php?id='. $tableau[$i_index][0].'" method="post"><input type="submit" name="btn_supprimer" value="Suprimer" /></form>';
                    if($tableau[$i_index][2] == 0)
                    {
                        $affichage .= '<form action="gestion_utilisateur.php?id='. $tableau[$i_index][0].'" method="post"><input type="submit" name="btn_rendre_admin" value="Rendre Admin" /></form>';
                    }
                    else
                    {
                        $affichage .= '<form action="gestion_utilisateur.php?id='. $tableau[$i_index][0].'" method="post"><input type="submit" name="btn_enlever_admin" value="Enlever Admin" /></form>';
                    }
                    $affichage .= '</div></div>';


                    $i_index++;
                }

            }

            $affichage .= "</div>";
        }
    }
    else
    {
        $affichage = '<p class="warning_message">Aucune Annonces à afficher</p>';
    }
    
    return $affichage;
}