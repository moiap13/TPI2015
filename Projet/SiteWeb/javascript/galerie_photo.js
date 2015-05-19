/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function change_photo(photo)
{
    var div_photo_principale = document.getElementById("photo_principale"); 
    var photo_principale = div_photo_principale.getElementsByTagName("img")[0];
    var photo_miniature = photo.getElementsByTagName("img")[0];
    
    photo.innerHTML = "";
    div_photo_principale.innerHTML = "";
    
    photo.innerHTML = photo_principale.outerHTML;
    div_photo_principale.innerHTML = photo_miniature.outerHTML;
}