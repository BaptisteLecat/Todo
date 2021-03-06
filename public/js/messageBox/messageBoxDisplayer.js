var timeout = null; //permet de remettre à 0 les timeout lancés.

function createMessageBox(content) {
    deleteMessageBox();
    var messageBox_wrapper = document.createElement("div");
    messageBox_wrapper.id = "messageBox_wrapper";
    messageBox_wrapper.innerHTML = content;
    document.getElementsByTagName("body")[0].appendChild(messageBox_wrapper);
    showMessageBox();
}

function showMessageBox() {
    messageBox = document.getElementById("messageBox_container");
    if (messageBox != null) {
        for (var i = 0; i < messageBox.children.length; i++) {
            messageBox.children[i].style.display = "flex";
        }

        timeout = setTimeout(() => {
            messageBox.style.top = "35px";
        }, 5);
        timeout = setTimeout(() => {
            hideMessageBox();
        }, 4000);
    }
}

function hideMessageBox() {
    messageBox = document.getElementById("messageBox_container");
    if (messageBox != null) {
        messageBox.style.top = "-450px";
        timeout = setTimeout(() => {
            deleteMessageBox();
        }, 600);
    }
}

//Appeller lors d'un nouvel affichage de messageBox.
function deleteMessageBox() {
    messageBox = document.getElementById("messageBox_wrapper");
    if (messageBox != null) {
        if (timeout != null) {
            clearTimeout(timeout);
        }
        document.getElementsByTagName("body")[0].removeChild(messageBox);
    }
}