$(".permission")
    .find("input")
    .each(function() {
        this.addEventListener("click", updatePermission, false);
    });

function updatePermission(event) {
    //event.preventDefault();
    var idPermission = event.target.id;
    var contributorBox =
        event.target.parentNode.parentNode.parentNode.parentNode.parentNode;
    var idContributor = contributorBox.id;
    var value = event.target.checked;
    updateContributorPermission(
        idPermission,
        idContributor,
        value,
        contributorBox
    );
}