$(".participant_container").click(participantWrapManager);

function participantWrapManager(event) {
    //Le participant est wrappé.
    if (event.target.type != "checkbox") {
        element = event.currentTarget;
        if (
            element.getElementsByClassName("participant-info_container")[0].style
            .display != "flex"
        ) {
            element
                .getElementsByClassName("participant-develop_container")[0]
                .getElementsByTagName("img")[0].style.transform = "rotate(180deg)";
            element.style.paddingBottom = "20px";
            element.getElementsByClassName(
                "participant-info_container"
            )[0].style.maxHeight = "600px";
            element.getElementsByClassName(
                "participant-info_container"
            )[0].style.display = "flex";
        } else {
            element
                .getElementsByClassName("participant-develop_container")[0]
                .getElementsByTagName("img")[0].style.transform = "rotate(0deg)";
            element.style.paddingBottom = "10px";
            element.getElementsByClassName(
                "participant-info_container"
            )[0].style.maxHeight = "0px";
            element.getElementsByClassName(
                "participant-info_container"
            )[0].style.display = "none";
        }
    }
}