//création de 3 éléments HTMLElement
var $addButtonimage = $('<button type="button" class="add_collection_link">Ajouter une image</button>');
var $delButton = $('<button type="button" class="del_collection_link">Supprimer l\'image</button>');
//le premier élément li de la liste (celui qui contient le bouton 'ajouter')
var $newLinkLiimage = $('<li></li>').append($addButtonimage);

function generateDeleteButton($collection){
    var $btn = $delButton.clone();
    $btn.on("click", function(){//événement clic du bouton supprimer
        $(this).parent("li").remove();
        $collection.data('index', $collection.data('index')-1)

    })

    return $btn;
}

//fonction qui ajoute un nouveau champ li (en fonction de l'entry_type du collectionType) dans la collection
function addimageForm($image, $newLinkLiimage) {
    
    //contenu du data attribute prototype qui contient le HTML d'un champ
    var newFormimage = $image.data('prototype');
    //le nombre de champs déjà présents dans la collection
    var index = $image.data('index');
    //on remplace l'emplacement prévu pour l'id d'un champ par son index dans la collection
    newFormimage = newFormimage.replace(/__name__/g, index);
    //on modifie le data index de la collection par le nouveau nombre d'éléments
    $image.data('index', index+1);

    //on construit l'élément li avec le champ et le bouton supprimer
    var $newFormLiimage = $('<li></li>').append(newFormimage).append(generateDeleteButton($image));
    //on ajoute la nouvelle li au dessus de celle qui contient le bouton "ajouter"
    $newLinkLiimage.before($newFormLiimage);
}


//rendu de la collection au chargement de la page
$(document).ready(function() {

    //on pointe la liste complete (le conteneur de la collection)
    var $images = $("ul#images")
    var $stagli = $("ul#images li")

     //pour chaque li déjà présente dans la collection (dans le cas d'une modification)
    $stagli.each(function(){
        //on génère et ajoute un bouton "supprimer"
        $(this).append(generateDeleteButton($images));
    })
    //on y ajoute le bouton ajouter (à la fin du contenu)
    $images.append($newLinkLiimage);
    //le data index de la collection est égal au nombre de input à l'intérieur
    $images.data('index', $stagli.length);

    $addButtonimage.on('click', function() { // au clic sur le bouton ajouter

        //on appelle la fonction qui ajoute un nouveau champ
        addimageForm($images, $newLinkLiimage);
    });

});


