$(".participant-develop_container").each(function() {
    $("img").each(function() {
        this.addEventListener("click", participantWrapManager)
    });
});

function participantWrapManager(event) {
    element = event.target.parentNode.parentNode.parentNode;
    //Le participant est wrappé.
    if(element.getElementsByClassName("participant-info_container")[0].style.display == "none"){
        event.target.style.transform = "rotate(0deg)";
        element.style.paddingBottom = "20px";
        element.getElementsByClassName("participant-info_container")[0].style.display = "flex";
    }else{
        event.target.style.transform = "rotate(180deg)";
        element.style.paddingBottom = "10px";
        element.getElementsByClassName("participant-info_container")[0].style.display = "none";
    }
}

