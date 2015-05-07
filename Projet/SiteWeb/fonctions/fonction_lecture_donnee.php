<?php
function recupere_categories($bdd)
{
    $requete = $bdd->query('select * from categories group by(categorie)');
    
    if($requete != false)
        $requete = $requete->fetchAll();
    
    return $requete;
}

function recupere_dernieres_annonces_postee($bdd)
{
    $requete = $bdd->query("select idAnnonce, titre, date_debut, photo, prix from annonces where active = 1 order by date_debut desc, idAnnonce desc");
    if($requete != false)
        $requete = $requete->fetchAll();
    
    return $requete;
}

/*******************************************************************************************************************************/
/********************************************** Page gestion Compte ************************************************************/
/*******************************************************************************************************************************/
function recupere_utilisateur_par_id($id, $bdd)
{
    $sql ="select  email, pseudo, mdp, avatar, statut from utilisateur where idUtilisateur=:id";
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    
    if($requete != false)
        $requete = $requete->fetchAll();
    
    return $requete;
}

function recupere_annonces_utilisateur($id, $bdd)
{
    $sql = 'select idAnnonce, titre, date_debut, active, photo FROM annonces where idUtilisateur=:id';
    
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    
    if(!empty($requete))
        $requete = $requete->fetchAll();
    
    return $requete;
}

function recupere_annonces_par_categorie($nom_categorie, $bdd)
{
    $sql='select idAnnonce, titre, description, photo, date_debut from annonces natural join categorie where categorie = :categorie';
    
    $requete = $bdd->prepare($sql);
    $requete->execute(array('categorie' => $nom_categorie));
    
    if(!empty($requete))
        $requete = $requete->fetchAll();
    
    return $requete;
}

function recupere_annonces_par_id($id, $bdd)
{
    $sql='select titre, description, photo, date_debut, idUtilisateur, prix, active, idCategorie from annonces where idAnnonce =:id';
    
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    
    if(!empty($requete))
        $requete = $requete->fetchAll();
    
    return $requete;
}

function recupere_categories_par_id($id, $bdd)
{
    $sql = 'select Categorie from categories where idCategorie = :id';
    
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    
    if($requete != false)
        $requete = $requete->fetchAll();
    
    return $requete;
}