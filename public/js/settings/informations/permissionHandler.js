$(".permission")
    .find("input")
    .each(function() {
        this.addEventListener("click", updatePermission, false);
    });

function updatePermission(event) {
    var idPermission = event.target.id;
    var idContributor = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.id;
    var value = event.target.checked;
    updateContributorPermission(idPermission, idContributor, value);
}