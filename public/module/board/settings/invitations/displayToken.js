function displayToken(list_token) {
    html = "";
    list_token.forEach((token) => {
        html = html.concat(`<div class="token_container">
                        <div class="token_content">
                            <h6>${token.token}</h6>
                            <p>${token.expirationDate}</p>
                        </div>
                        <div class="token_button">
                            <img onclick="regenerateToken('${token.token}')" src="..\\..\\assets\\icons\\refresh.png" alt="">
                            <img onclick="deleteToken('${token.token}')" src="..\\\..\\assets\\icons\\trash.png" alt="">
                        </div>
                    </div>`);
    });

    return html;
}