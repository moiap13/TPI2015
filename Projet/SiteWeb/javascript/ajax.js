function str_array(str, delimiter)
{
    var a = new Array();
    var str_2 = "";
   
    for(i = 0;i < str.length; i++)
    {
        if(str[i] == delimiter)
        {
            a.push(str_2);
            str_2 = "";
        }
        else
        {
            str_2 += str[i];
        }
    } 
    
    return a;
    
    console.log(a);
}

function ajax(query)
{
    var xhr=null;
    console.log(query);
    if (window.XMLHttpRequest) { 
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    //on définit l'appel de la fonction au retour serveur
    xhr.onreadystatechange = function() { alert_ajax(xhr); };
 
    document.getElementById("div_result").className="tumevois";
    //on appelle le fichier reponse.txt
    xhr.open("GET", "./pages/recherche/recherche_ajax/get_personnes.php?query=" + query, true);
    xhr.send(null);
}

function alert_ajax(xhr)
{
    var a = new Array();
    var b = new Array();
    var affichage = "";
    
    
    if (xhr.readyState==4) 
    {
        a = str_array(xhr.responseText, '#');
        
        if(a.length > 0)
        {
            for(var i=0;i<a.length;i++)
            {
                b[i] = str_array(a[i], ';');
            }
            
            affichage = '';
            console.log(b);
            
            for(var i=0;i<b.length;i++)
            {
                affichage += '<div class="ajax_annonce"><div class="ajax_photo"><a href="pages/annonces/afficher_annonce.php?id_annonce=' + b[i][0] + '">';
                
                if(b[i][3] == 1)
                {
                    affichage += '<img src="img/annonces/' + b[i][0] + '/' +b[i][5] +'" />';
                }
                else
                {
                    affichage += '<img src="img/image_site/No_Image_Available.png" />';
                }
                
                affichage += '</a></div><div class="ajax_titre_prix">';
                affichage += '<a href="pages/annonces/afficher_annonce.php?id_annonce=' + b[i][0] + '">' + b[i][1] + ' - ' + b[i][2] + '</a>';
                affichage += '</div><div class="ajax_date">';
                affichage += '<a href="pages/annonces/afficher_annonce.php?id_annonce=' + b[i][0] + '">' + b[i][4] + '</a>';
                affichage += '</div></div>'
            }

            document.getElementById("div_result").innerHTML = affichage;
        }
        else
        {
            document.getElementById("div_result").innerHTML = "<div class='ajax_annonce'>Aucunes annonces trouvée</div>";
        }
        
        document.getElementById("div_result").className="tumevois";
    }
    
}

function submit()
{
    document.form.submit();
}

function change_width(event)
{
    if(event.target.size == 35)
    {
        for(var i=35;i>=20;i--)
        {
            event.target.size = i;

            document.getElementById("div_result").className="tumevoispas";
        }
    }
    else
    {
        for(var i=20;i<=35;i++)
        {
            event.target.size = i;
        }

        if(event.target.value != "")
        {
            ajax('select idUtilisateur, Nom, Prenom, Pseudo from utilisateur where Nom RegExp "' + event.target.value + '" OR Prenom RegExp "' + event.target.value + '" OR uid RegExp "' + event.target.value + '"');
        }
    }
}

function keypressed(event)
{
    if(event.target.value != "")
    {
        ajax('select idAnnonce,titre,prix,photo,date_debut from annonces where (titre RegExp "' + event.target.value + '" OR description RegExp "' + event.target.value + '" OR prix RegExp "' + event.target.value + '") AND (active = 1) order by date_debut desc, idAnnonce desc');
    }
    else
    {
        document.getElementById("div_result").innerHTML = "";
        document.getElementById("div_result").className="tumevoispas";
    }
}

function initialize()
{
    document.getElementById("input_search").size = 35;
}