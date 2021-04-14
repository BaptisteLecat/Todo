function displayInvitations(list_invitation, idTodo) {
    html = "";
    list_invitation.forEach((contributor) => {
        if (!contributor.accepted) {
            html = html.concat(`<div class="invitation_container">
                            <div class="invitation_icon">
                                <img src="..\\..\\assets\\icons\\unvalidate.png" alt="">
                            </div>
                            <div class="invitation_content">
                                <div class="invitation_user-info">
                                    <p>${contributor.name}</p>
                                    <h6>${contributor.firstName}</h6>
                                </div>
                                <p>${contributor.joinDate}</p>
                            </div>
                            <div class="invitation_button">
                                <img onclick="acceptContributor(${contributor.id}, ${idTodo})" src="..\\..\\assets\\icons\\accept.png" alt="">
                                <img onclick="refuseContributor(${contributor.id}, ${idTodo})" src="..\\..\\assets\\icons\\cancel.png" alt="">
                            </div>
                        </div>`);
        }
    });

    return html;
}