<?php
/**
 * fonction qui permet de se logger
 * -----------------------------------------------------------------------------
 * @param type $user : pseudo ou mail de l'utilisateur
 * @param type $mdp : mot de passe de l'utilisateur
 * @param type $bdd : liaison a la base de donnée
 * @return type : retourne un tableau avec l'id de l'utilisateur
 */ 
function login($user, $mdp, $bdd)
{
    $sql = 'Select IdUtilisateur from utilisateur where (Email=:user && MDP = :mdp) OR (Pseudo=:user && MDP = :mdp)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array(':user' => $user, ':mdp' => sha1($mdp)));
    
    //if($requete != false)
        return $requete->fetchAll();
}
/**
 * fonction qui vérifie le formulaire d'inscription
 * -----------------------------------------------------------------------------
 * @param type $tableau : tableau avec les données du formulaire
 * @param type $bdd : liaison a la base de donnée
 */
function verifie_formulaire($tableau, $bdd)
{
    if($tableau['tbxpseudo'] != '')
    {
        $sql = 'select idUtilisateur from utilisateur where Pseudo = :pseudo';
        $requete = $bdd->prepare($sql);
        $requete->execute(array(':pseudo' => $tableau['tbxpseudo']));
        $pseudo = $requete->fetchAll();

        if(empty($pseudo))
        {
            if($tableau['tbxmdp'] != '' && $tableau['tbxmdp_2'] != "")
            {
                if($tableau['tbxmdp'] == $tableau['tbxmdp_2'])
                {
                    if($tableau['tbxnom'] != '')
                    {
                        if($tableau['tbxprenom'] != '')
                        {
                            if(inscription($tableau, $bdd) > 1)
                            {
                                header('Location: connexion.php?tbxusers='. $tableau['tbxpseudo'] . '&tbxpassword='. $tableau['tbxmdp'] .'&btnlogin=login');
                            }
                            else 
                            {
                                header('Location: ../connexion/inscription.php?erreur=11');
                            }
                        }
                        else
                        {
                            header('Location: ../connexion/inscription.php?erreur=5');
                        }
                    }
                    else
                    {
                        header('Location: ../connexion/inscription.php?erreur=4');
                    }
                }
                else
                {
                    header('Location: ../connexion/inscription.php?erreur=2');
                }
            }
            else
            {
                header('Location: ../connexion/inscription.php?erreur=3');
            }
        }
        else
        {
            header('Location: ../connexion/inscription.php?erreur=8');
        }
    }
    else
    {
        header('Location: ../connexion/inscription.php?erreur=6');
    }
}
/**
 * inscrit l'utilisateur au site web
 * -----------------------------------------------------------------------------
 * @param type $tableau : tableau des données pour l'inscription
 * @param type $bdd : liaison a l abase de donnée
 * @return type : retourne l'id de la derniere annonce ajoutée
 */
function inscription($tableau, $bdd)
{
    $result = -1;
    $sql = 'insert into Utilisateur(Nom, Prenom, Pseudo, Email, MDP, Statut) values(:nom,:prenom,:pseudo,:email,:mdp,0)';
    $requete = $bdd->prepare($sql);
    $requete = $requete->execute(array(
              ':nom' => $tableau['tbxnom'],
              ':prenom' => $tableau['tbxprenom'],
              ':pseudo' => $tableau['tbxpseudo'],
              ':email' => $tableau['tbxemail'],
              ':mdp' => sha1($tableau['tbxmdp'])
            ));
    $result = $bdd->lastInsertId();
    
    return $result;
}