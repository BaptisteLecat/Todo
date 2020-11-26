document.getElementById('test').addEventListener("click", function(e) {
    e.preventDefault();

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = this.response;
            console.log(res);

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        }
    };

    xhr.open("POST", "function/switch_dayDisplayer.php", true);
    xhr.responseType = "json";
    xhr.send();

    return false;
});