var selectedIcon_index = null;

function selectIcon(object){
    if(selectedIcon_index == null){
        selectedIcon_index = object.name; //Name == index.
        object.src = `assets/icons/todo_icon/selected_${object.alt}.png`;
    }else{
        var previousIcon = object.parentNode.getElementsByTagName("img")[selectedIcon_index];
        previousIcon.src = `assets/icons/todo_icon/${previousIcon.alt}.png`;
        selectedIcon_index = object.name; //Name == index.
        object.src = `assets/icons/todo_icon/selected_${object.alt}.png`;
    }

    document.getElementById('icon_id').value = object.id;
}