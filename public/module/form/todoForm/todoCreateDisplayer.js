//Appellée au click d'un des 2 buttons de changement de statut Todo.
function btnStatus_click(object) {
    switch (object.id) {
        case 'private':
            //Affichage des couleurs
            object.style.backgroundColor = "#5C7AFF";
            document.getElementById('public').style.backgroundColor = "#1A2C39";

            //Modification de la valeur de l'input hidden pour passage de la valeur au submit.
            document.getElementById('status_value').value = "private";
            break;

        case 'public':
            //Affichage des couleurs
            object.style.backgroundColor = "#5C7AFF";
            document.getElementById('private').style.backgroundColor = "#1A2C39";

            //Modification de la valeur de l'input hidden pour passage de la valeur au submit.
            document.getElementById('status_value').value = "public";
            break;
    }
}