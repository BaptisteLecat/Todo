function showMessageBox() {
    messageBox = document.getElementById('box_container');
    if (messageBox != null) {
        messageBox.style.height = "8%";
        messageBox.style.opacity = "1";
        document.getElementsByTagName('main')[0].style.height = "calc(100% - (60px + 50px + 8%))";
        setTimeout(() => {
            for (var i = 0; i < messageBox.children.length; i++) {
                messageBox.children[i].style.display = "flex";
            }
        }, 300);

        setTimeout(() => {
            hideMessageBox();
        }, 6000);
    }
}

function hideMessageBox(){
    messageBox = document.getElementById('box_container');
    if(messageBox != null){
        messageBox.style.height = "0px";
        messageBox.style.opacity = "0";
        document.getElementsByTagName('main')[0].style.height = "calc(100% - (60px + 50px))";
        setTimeout(() => {
            for (var i = 0; i < messageBox.children.length; i++) {
                messageBox.children[i].style.display = "none";
            }
        }, 200);
    }
}