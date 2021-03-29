$(".permission")
    .find("input")
    .each(function() {
        this.addEventListener("click", updatePermission, false);
    });

function updatePermission(event) {
    //event.preventDefault();
    var idPermission = event.currentTarget.id;
    var contributorBox =
        event.currentTarget.parentNode.parentNode.parentNode.parentNode
        .parentNode;
    var idContributor = contributorBox.id;
    var value = event.currentTarget.checked;
    updateContributorPermission(
        idPermission,
        idContributor,
        value,
        contributorBox
    );
}