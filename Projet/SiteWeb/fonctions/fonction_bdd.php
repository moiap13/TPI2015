<?php
/**
 * Permet de se connecter a une base de donnée et de generer un objet PDO
 * -------------------------------------------------------------------
 * @param type $db_name : le nom de la base de donnée a se connecter
 * @param type $host : le serveur ou est stoquée la base de donnée
 * @param type $user : l'utilisateur pour se connecter a la base
 * @param type $pwd : son mot de passe
 * @return type : retourne un objet PDO
 */
function connexion($db_name, $host, $user, $pwd)
{
    try {
        $bdd = new PDO('mysql:dbname=' . $db_name . ';host=' . $host, $user, $pwd);
        $bdd ->exec("SET CHARACTER SET utf8");
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        $bdd = $e->getMessage();
    }
    
    return $bdd;
}

/**
 * utilise un id pour aller chercher les utilisateur dans la base
 * -------------------------------------------------------------------
 * @param type $id : id de l'utilisateur
 * @param type $bdd : liaison a la base de donnée
 * @return un tableau avec l'utilisateur
 */
function recupere_users_par_id($id, $bdd)
{
    $sql = 'SELECT Prenom, Nom, Statut FROM utilisateur WHERE IdUtilisateur=:id';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    
    
    if(!empty($requete))
    {
        $requete->fetchAll();
    }
    
    return $requete;
}

/**
 * Change la valeur booléenne avatar dans la table utilisateur 
 * afin de savoir si un utilisateur a un avatar ou pas
 * -------------------------------------------------------------------
 * @param type $id : id de l'utilisateur
 * @param type $avatar : valeureu booléenne pour l'avatar
 * @param type $bdd : liaison a la base de donnée
 */
function modification_avatar($id, $avatar, $bdd)
{
    $sql = 'UPDATE utilisateur SET avatar=:avatar WHERE idUtilisateur=:id';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('avatar' => $avatar, 'id' => $id));
}


/**
 * Ajoute une annonce dans la base
 * -------------------------------------------------------------------
 * @param type $titre : titre de l'annonce
 * @param type $description : description de l'annonce
 * @param type $date : date d'ajoute de l'annonce
 * @param type $prix : prix de l'annonce
 * @param type $idUtilisateur : id utilisateur de l'annonce
 * @param type $idCategorie : id catégorie de l'annonce
 * @param type $photos : valeur booléenne pour savoir s'il y a des photos
 * @param type $bdd : liaison a la base de donnée
 * @return id de la'nnonce 
 */
function ajout_annonce($titre, $description, $date,$prix,$idUtilisateur,$idCategorie, $photos, $bdd)
{
    $titre = strtolower($titre);
    $description = strtolower($description);
    
    $sql = 'insert into annonces(titre, description, date_debut, prix, idUtilisateur, idCategorie, active, photo) values(:titre,:description,:date,:prix,:id,:categorie,"1",:photo)';
    
    $requete = $bdd->prepare($sql);
    $requete->execute(array(
        'titre' => $titre,
        'description' => $description,
        'date' => $date,
        'prix' => $prix,
        'id' => $idUtilisateur,
        'categorie' => $idCategorie,
        'photo' => $photos
    ));
    
    return $bdd->lastInsertId();
}

/**
 * mise a jour de l'annonce
 * -------------------------------------------------------------------
 * @param type $id : id de l'annonce
 * @param type $titre : titre de l'annonce
 * @param type $prix :  prix de l'annonce
 * @param type $description : description de l'annonce
 * @param type $date : date de l'annonce
 * @param type $categorie : idCategorie de l'annonce
 * @param type $bdd : liaison a la base de donnée
 */
function maj_annonce($id, $titre, $prix, $description, $date, $categorie, $bdd)
{
    $modifie = $bdd->prepare('UPDATE annonces SET titre=:titre, prix=:prix, description=:description, date_debut=:date, idCategorie=:categorie, valide=0 WHERE idAnnonce=:id');
    $modifie->execute(array(
        'titre' => $titre,
        'prix' => $prix,
        'description' => $description,
        'date' => $date,
        'categorie' => $categorie,
        'id' => $id
    ));
}

/**
 * supprime une annonce
 * -------------------------------------------------------------------
 * @param type $id : id de l'annonce
 * @param type $bdd : liaison a la base de donnée
 */
function supprimer_annonce($id, $bdd)
{
    $requete = $bdd->prepare('DELETE FROM annonces WHERE idAnnonce = :id');
    $requete->execute(array('id' => $id));
}

/**
 * met a jour la valeur booléenne qui permet de savoir s'il y a une photo ou pas
 * -------------------------------------------------------------------
 * @param type $id : id de l'annonce
 * @param type $valeur_photo : valeur de la variable booléenne
 * @param type $bdd : liaison a la base de donnée
 */
function maj_photo($id, $valeur_photo, $bdd)
{
    $modifie = $bdd->prepare('UPDATE annonces SET photo=:photo WHERE idAnnonce=:id');
    $modifie->execute(array(
        'photo' => $valeur_photo,
        'id' => $id
    ));
}

/**
 * met a jour la valeur booléenne qui permet de savoir si une annonce est active ou pas
 * -------------------------------------------------------------------
 * @param type $id : id de l'annonce
 * @param type $valeur_active : valeure booléenne
 * @param type $bdd : liaison a la base de donnée
 */
function maj_active($id, $valeur_active, $bdd)
{
    $modifie = $bdd->prepare('UPDATE annonces SET active=:active WHERE idAnnonce=:id');
    $modifie->execute(array(
        'active' => $valeur_active,
        'id' => $id
    ));
}

/**
 * met a jour la valeur booléenne qui permet de savoir si une annonce est valide ou pas
 * -------------------------------------------------------------------
 * @param type $id : id de l'annonce
 * @param type $valeur_valide : valeure booléenne
 * @param type $bdd : liaison a la base de donnée
 */
function maj_valide($id, $valeur_valide, $bdd)
{
    $modifie = $bdd->prepare('UPDATE annonces SET valide=:valide WHERE idAnnonce=:id');
    $modifie->execute(array(
        'valide' => $valeur_valide,
        'id' => $id
    ));
}

/**
 * Supprimer la catégorie
 * -------------------------------------------------------------------
 * @param type $id : id de l'annonce
 * @param type $bdd :  liaison a la base de donnée
 */
function supprimer_categorie($id, $bdd)
{
    $sql = "UPDATE annonces set idCategorie=1 where idCategorie=:id";
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    
    $sql = "";
    $requete = "";
    
    $sql = "DELETE FROM categories WHERE idCategorie = :id";
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
}
/**
 * mise a jour de la atégorie
 * -------------------------------------------------------------------
 * @param type $id : id de l'annonce
 * @param type $nom_categorie : nom de la categorie
 * @param type $descritpion : descripiton de la catégorie
 * @param type $bdd : liaison a la base de donnée
 */
function maj_categorie($id, $nom_categorie, $descritpion, $bdd)
{
    $sql = "UPDATE categories set categorie=:nom_categorie, descriptif=:description where idCategorie=:id";
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id, 'nom_categorie' => $nom_categorie, 'description' => $descritpion));
}

/**
 * ajouter la catégorie dans la base
 * -------------------------------------------------------------------
 * @param type $nom_categorie : ajouter le nom de la catégorie 
 * @param type $descriptif  : ajouter la description de la catégorie 
 * @param type $bdd : liaison a la base de donnée
 * @return le numero de l'ajout
 */
function ajouter_categorie($nom_categorie, $descriptif, $bdd)
{
    $sql = 'insert into categories(categorie, descriptif) values(:categorie, :descriptif)';
    
    $request = $bdd->prepare($sql);
    $request->execute(array('categorie' => $nom_categorie, 'descriptif' => $descriptif));
    
    return $bdd->lastInsertId();
}

/**
 * supprimer utilisateur
 * -------------------------------------------------------------------
 * @param type $id : id de l'utilisateur    
 * @param type $bdd : liaison a la base de donnée
 */
function supprimer_utilisateur($id, $bdd)
{
    $sql = "DELETE FROM utilisateur WHERE idUtilisateur = :id";
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
}

/**
 * change la valeure booléennepour savoir si l'utilisateur est admin ou pas
 * -------------------------------------------------------------------
 * @param type $id : id de l'utilisateur
 * @param type $valeur : valeur booléenne
 * @param type $bdd : liaison a la base de donnée
 */
function maj_admin($id, $valeur, $bdd)
{
    $sql = "UPDATE utilisateur set statut=:statut where idUtilisateur=:id";
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id, 'statut' => $valeur));
}
/*******************************************************************************
*********************** FONCTIONS  POUR LA PAGE RECHERCHE **********************
*******************************************************************************/

/**
 * fonction de recherche
 * rappatrie toutes les annonces qui corresponde avce les termes du tableau
 * -------------------------------------------------------------------
 * @param type $tableau : tableua de termes pour la recherche
 * @param type $bdd : liaison a la base de donnée
 * @return type : tableau avec de la mise en page
 */
function search($tableau, $bdd)
{
    $id_annonces = array();
    $titre = array();
    $text = array();
    $photo = array();
    $date_debut = array();
    $tableau_text_gras = array();
    
    for($i=0;$i<count($tableau);$i++)
    {
        $sql = 'select idAnnonce from annonces where (titre RegExp :mot_recherche OR description regexp :mot_recherche OR prix RegExp :mot_recherche) AND (active = 1 AND valide=1)';
        $requete = $bdd->prepare($sql);
        $requete->execute(array('mot_recherche' => $tableau[$i]));
        $requete = $requete->fetchAll();
        
        for($y=0;$y<count($requete);$y++)
        {
            $id_annonces[] = $requete[$y][0];
        } 
    }
    
    
    if(isset($id_annonces) && !empty($id_annonces))
    {
        $annonces = copie_donnee_unique($id_annonces);
    }
    
    if(!empty($annonces) && $annonces != null)
    {
        $id_annonces = array();
        
        for($y=0;$y<count($annonces);$y++)
        {
            if($annonces[$y] != null)
            {
                
                $sql = 'select idAnnonce,titre,description,prix,photo,date_debut from annonces where idAnnonce = :id';
                $requete = $bdd->prepare($sql);
                $requete->execute(array('id' => $annonces[$y]));
                $requete = $requete->fetchAll();
                
                for($c=0;$c<count($requete);$c++)
                {   
                    $id_annonces[] = $requete[$c][0];
                    $titre[] = $requete[$c][1];
                    $text[] = $requete[$c][2];
                    $prix[] = $requete[$c][3];
                    $photo[] = $requete[$c][4]; 
                    $date_debut[] = $requete[$c][5]; 
                }
            }
            else
            {
                echo 'null';
            }
        }
    }
    
    for($i=0;$i<count($titre);$i++)
    {
        $tableau_text_gras[$i] = array();
        $tableau_text_gras[$i][0] = $id_annonces[$i];
        $tableau_text_gras[$i][1] = $titre[$i];
        $tableau_text_gras[$i][2] = $text[$i];
        $tableau_text_gras[$i][3] = $prix[$i];
        $tableau_text_gras[$i][4] = $photo[$i];
        $tableau_text_gras[$i][5] = $date_debut[$i];
    }
            
    for($i=0;$i<count($tableau);$i++)
    {
        for($y=0;$y<count($tableau_text_gras);$y++)
        {
            for($z=0;$z<count($tableau_text_gras[$y]);$z++)
            {
                $tableau_text_gras[$y][$z] = mettre_text_en_gras(trim($tableau[$i]), $tableau_text_gras[$y][$z]);
            }
        }  
    }
    
    return $tableau_text_gras;
}