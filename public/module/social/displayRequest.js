function displayInvitations(list_request, idTodo) {
    html = "";
    list_request.forEach((request) => {
        html = html.concat(`                <div class="invitation_container">
                    <div class="invitation_icon">
                        <img src="..\\..\\assets\\icons\\unvalidate.png" alt="">
                    </div>
                    <div class="invitation_content">
                        <div class="invitation_user-info">
                            <p>${request.name}</p>
                            <h6>${request.firstName}</h6>
                        </div>
                        <p>19/02/1855</p>
                    </div>
                    <div class="invitation_button">
                        <img src="..\\..\\assets\\icons\\cancel.png" alt="">
                    </div>
                </div>`);
    });

    return html;
}