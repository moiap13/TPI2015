<?php
/**
 * recupere toutes les catégoriesde la base
 * -----------------------------------------------------------------------------
 * @param type $bdd : liaison a la base de donnée
 * @return type : tableau contenant les donnée
 */
function recupere_categories($bdd)
{
    $requete = $bdd->query('select * from categories group by(categorie)');
    
    if($requete != false)
        $requete = $requete->fetchAll();
    
    return $requete;
}
/**
 * recupere les dernieres annonces postee
 * -----------------------------------------------------------------------------
 * @param type $bdd : liaison a la base de donnée
 * @return type : tableau contenant les donnée
 */
function recupere_dernieres_annonces_postee($bdd)
{
    $requete = $bdd->query("select idAnnonce, titre, date_debut, photo, prix from annonces where active = 1 && valide = 1 order by date_debut desc, idAnnonce desc");
    if($requete != false)
        $requete = $requete->fetchAll();
    
    return $requete;
}

/*******************************************************************************************************************************/
/********************************************** Page gestion Compte ************************************************************/
/*******************************************************************************************************************************/
/**
 * recupere toutes les utilisateur
 * -----------------------------------------------------------------------------
 * @param type $bdd : liaison a la base de donnée
 * @return type : tableau contenant les donnée
 */
function recupere_utilisateur_par_id($id, $bdd)
{
    $sql ="select  email, pseudo, mdp, avatar, statut from utilisateur where idUtilisateur=:id";
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    
    if($requete != false)
        $requete = $requete->fetchAll();
    
    return $requete;
}
/**
 * recupere les annonces d'un utilisateur
 * -----------------------------------------------------------------------------
 * @param type $bdd : liaison a la base de donnée
 * @return type : tableau contenant les donnée
 */
function recupere_annonces_utilisateur($id, $bdd)
{
    $sql = 'select idAnnonce, titre, date_debut, active, photo, valide FROM annonces where idUtilisateur=:id';
    
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    
    if(!empty($requete))
        $requete = $requete->fetchAll();
    
    return $requete;
}
/**
 * recupere toutes les annonces d'une catégorie
 * -----------------------------------------------------------------------------
 * @param type $nom_categorie 
 * @param type $bdd : liaison a la base de donnée
 * @return type : tableau contenant les donnée
 */
function recupere_annonces_par_categorie($nom_categorie, $bdd)
{
    $sql='select idAnnonce,titre,description,prix,photo,date_debut from annonces natural join categories where (categorie = :categorie OR idCategorie = :categorie) AND active = 1 AND valide=1';
    
    $requete = $bdd->prepare($sql);
    $requete->execute(array('categorie' => $nom_categorie));
    
    if(!empty($requete))
        $requete = $requete->fetchAll();
    
    return $requete;
}
/**
 * recupere toutes les catégories de la base
 * -----------------------------------------------------------------------------
 * @param type $id : id de la catégorie
 * @param type $bdd : liaison a la base de donnée
 * @return type : tableau contenant les donnée
 */
function recupere_annonces_par_id($id, $bdd)
{
    $sql='select titre, description, photo, date_debut, idUtilisateur, prix, active, idCategorie, valide from annonces where idAnnonce =:id';
    
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    
    if(!empty($requete))
        $requete = $requete->fetchAll();
    
    return $requete;
}
/**
 * recupere une catégorie
 * -----------------------------------------------------------------------------
 * @param type $id : id de la catégorie
 * @param type $bdd : liaison a la base de donnée
 * @return type : tableau contenant les donnée
 */
function recupere_categories_par_id($id, $bdd)
{
    $sql = 'select Categorie from categories where idCategorie = :id';
    
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    
    if($requete != false)
        $requete = $requete->fetchAll();
    
    return $requete;
}
/*******************************************************************************************************************************/
/********************************************* Page gestion ANNONCES ***********************************************************/
/*******************************************************************************************************************************/

/**
 * recupere les annonces non validée pour les affichées dans gestion annonce
 * 
 * @param type $bdd : liaison a l abase de donnée
 * @return type : tableau contenant les donnée recuperée
 */
function recupere_annonces_non_valide($bdd)
{
    $sql='select idAnnonce, titre, description, photo, prix from annonces where valide = 0 && active = 1';
    
    $requete = $bdd->prepare($sql);
    $requete->execute();
    
    if(!empty($requete))
        $requete = $requete->fetchAll();
    
    return $requete;
}
/*******************************************************************************************************************************/
/******************************************** Page gestion categories **********************************************************/
/*******************************************************************************************************************************/
/**
 * recupere les catégories pour la gestion des catégories
 * 
 * @param type $bdd : liaison base de donnée
 * @return type : tableau contenant les données recupérées
 */
function recupere_categories_gestion_categorie($bdd)
{
    $sql = "select * from categories";
    
    $requete = $bdd->prepare($sql);
    $requete->execute();
    
    if(!empty($requete))
        $requete = $requete->fetchAll();
    
    return $requete;
}
/**
 * recupere le nombre d'annonce par categorie
 * 
 * @param type $id : id de l'annonce
 * @param type $bdd : liaison a la base de donnée
 * @return type : tableau contenant les données
 */
function recupere_nb_annonce_par_categorie($id, $bdd)
{
    $sql = "select count(idAnnonce) from annonces WHERE idCategorie=:id AND active = 1 AND valide = 1";
    
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    
    if(!empty($requete))
        $requete = $requete->fetchAll();
    
    return $requete[0][0];
}
/**
 * recupere les categories pour la gestion categorie
 * 
 * @param type $id : id de la categorie
 * @param type $bdd : liaison a l abase de donnée
 * @return type : tableau contenant les données
 */
function recupere_categories_par_id_gestion($id, $bdd)
{
    $sql = "select * from categories where idCategorie=:id";
    
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    
    if(!empty($requete))
        $requete = $requete->fetchAll();
    
    return $requete;
}

function recupere_utilisateur_gestion($bdd)
{
    $sql ="select idUtilisateur, pseudo, statut, avatar, COUNT(idAnnonce) FROM utilisateur natural left join annonces GROUP BY idUtilisateur";
    $requete = $bdd->prepare($sql);
    $requete->execute();
    
    if($requete != false)
        $requete = $requete->fetchAll();
    
    return $requete;
}
/**
 * recupere annonces pour les afficher en ajax
 *
 * @param type $requete : requete de recherche
 * @param type $bdd : liaison base de donnée
 */
function recupere_annonces_ajax($requete, $bdd)
{
    //on lance la requete
    $tableau = $bdd->query($requete);
    $tableau = $tableau->fetchAll();
    
    //On boucle sur le resultat
    for($i=0;$i<count($tableau);$i++)
    {
        $jours = savoir_les_jours_restants($tableau[$i][4])[0];
                $jours = $jours[0] . $jours[1];
                
                if(savoir_les_jours_restants($tableau[$i][4])[1] && $jours <= 15)
                {
        for($y=0;$y<count($tableau[$i]);$y++)
        {
            if(isset($tableau[$i][$y]))
            {
                
                
                    if($y == 3 && $tableau[$i][$y] == 1) 
                    {
                        $str = mettre_fichier_dossier_dans_tableau('../../../img/annonces/' . $tableau[$i][0] . '/');
                        $file_type = couper_avec_separateur($str[0] . '.', '.');
                        $tableau[$i][count($tableau[$i])] = '0.' . $file_type[1];
                    }
                echo  $tableau[$i][$y] . ";";
                    
            }
        }  
        echo "#";
    }
    }
}