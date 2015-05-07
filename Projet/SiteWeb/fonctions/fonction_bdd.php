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

function modification_avatar($id, $avatar, $bdd)
{
    $sql = 'UPDATE utilisateur SET avatar=:avatar WHERE idUtilisateur=:id';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('avatar' => $avatar, 'id' => $id));
}

function inserer_categorie($nom_categorie, $bdd)
{
    $sql = 'insert into categories(categorie) values(:categorie)';
    $request = $bdd->prepare($sql);
    $request->execute(array('categorie' => $nom_categorie));
    
     return $bdd->lastInsertId();
}

function ajout_annonce($titre, $texte, $date,$prix,$id_user,$id_categorie, $photos, $bdd)
{
    $titre = strtolower($titre);
    $texte = strtolower($texte);
    
    $sql = 'insert into annonces(titre, description, date_debut, prix, idUtilisateur, idCategorie, active, photo) values(:titre,:texte,:date,:prix,:id,:categorie,"0",:photo)';
    
    $requete = $bdd->prepare($sql);
    $requete->execute(array(
        'titre' => $titre,
        'texte' => $texte,
        'date' => $date,
        'prix' => $prix,
        'id' => $id_user,
        'categorie' => $id_categorie,
        'photo' => $photos
    ));
    
    return $bdd->lastInsertId();
}
function maj_annonce($id, $titre, $prix, $description, $date, $categorie, $bdd)
{
    $modifie = $bdd->prepare('UPDATE annonces SET titre=:titre, prix=:prix, description=:description, date_debut=:date, idCategorie=:categorie WHERE idAnnonce=:id');
    $modifie->execute(array(
        'titre' => $titre,
        'prix' => $prix,
        'description' => $description,
        'date' => $date,
        'categorie' => $categorie,
        'id' => $id
    ));
}
function supprimer_annonce($id, $bdd)
{
    $ajout = $bdd->prepare('DELETE FROM annonces WHERE idAnnonce = :id');
    $ajout->execute(array('id' => $id));
}

function maj_photo($id, $valeur_photo, $bdd)
{
    $modifie = $bdd->prepare('UPDATE annonces SET photo=:photo WHERE idAnnonce=:id');
    $modifie->execute(array(
        'photo' => $valeur_photo,
        'id' => $id
    ));
}