function displayPendingContribute(list_pendingContribute) {
    html = "";
    list_pendingContribute.forEach((pendingContribute) => {
        html = html.concat(`                <div class="invitation_container">
                    <div class="invitation_icon">
                        <img src="..\\..\\assets\\icons\\unvalidate.png" alt="">
                    </div>
                    <div class="invitation_content">
                        <div class="invitation_user-info">
                            <p>${pendingContribute.todoOwnerName}</p>
                            <h6>${pendingContribute.todoTitle}</h6>
                        </div>
                        <p>${pendingContribute.joinDate}</p>
                    </div>
                    <div class="invitation_button">
                        <img onclick="cancelContributeRequest(${pendingContribute.todoId})" src="..\\..\\assets\\icons\\cancel.png" alt="">
                    </div>
                </div>`);
    });

    return html;
}