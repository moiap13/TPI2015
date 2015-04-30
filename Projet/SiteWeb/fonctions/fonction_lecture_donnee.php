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
    $requete = $bdd->query("select id_annonce, titre, date_debut, photos from annonces order by date_debut desc");
    if($requete != false)
        $requete = $requete->fetchAll();
    
    return $requete;
}