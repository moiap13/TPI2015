<?php
include '../../../fonctions/fonction_site.php';
include '../../../fonctions/fonction_bdd.php';
include '../../../fonctions/fonction_lecture_donnee.php';
include '../../../fonctions/fonction_affichage_donnee.php';
include '../../../fonctions/fonction_connexion.php';
include '../../../parametres/parametres.php';

function get_personne_from_database($query)
{
    //on connecte a la BDD
    $db_name = "annoligne";
    $host="localhost";
    $user="root";
    $pwd="root";

    $bdd = connexion($db_name, $host, $user, $pwd);

    //on lance la requete
    $tableau = $bdd->query($query);
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

function str_array($str, $delimiter)
{
    $a = array();
    $str_2 = "";
   
    for($i = 0;$i < strlen($str); $i++)
    {
        if($str[$i] == $delimiter)
        {
            $i_compt = count($a);
            $a[$i_compt] = $str_2;
            $str_2 = "";
        }
        else
        {
            $str_2 .= $str[$i];
        }
    } 
    
    
    return $a;
}

function return_personnes() 
{
    $csv_directory = fopen('reponse.csv', 'r');
    $affichage = "";
    
    
    $a_files = array();
    $a_items = array();
    $i_compt = 0;
    $i_index = 0;
    
    while($data = fgetcsv($csv_directory, 1000, ';'))
    {
        if($data != '.' && $data != '..')
        {
            for($i =0;$i<2;$i++)
            {
                echo $data[$i] . ';';
            }
            
            echo '#';
        }
    }
    
    fclose($csv_directory);
}



if(isset($_REQUEST['query']))
{
    //sleep(1);
    get_personne_from_database($_REQUEST['query']);
}
?>
