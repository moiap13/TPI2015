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
    $sql = 'SELECT Prenom, Nom, Statut FROM utilisateur WHERE IdUtilisateur=' . $id;
    $requete = $bdd->query($sql);
    return $requete->fetchAll();
}