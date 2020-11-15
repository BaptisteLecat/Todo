var connexionLoaded = false;
var connexion = "";

document.onload("load", function(){
  LoadConnexion();
});
testConnexion();

function LoadConnexion(){
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var res = this.response;
      console.log(res);

      if (res.connexion != null) {
        connexion = res.connexion;
        connexionLoaded = true;
        alert("Connexion BDD réussie.");
      }else {
        alert("Connexion BDD échouée.");
      }

    } else if (this.readyState == 4) {
      alert("Une erreur est survenue...");
    }
  };

  xhr.open("POST", "../function/loadConnexion.php", true);
  xhr.responseType = "json";
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send();
}

function testConnexion(){
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var res = this.response;
      console.log(res);

      if (res != null) {
        alert(" réussie.");
      }else {
        alert(" échouée.");
      }

    } else if (this.readyState == 4) {
      alert("Une erreur est survenue...");
    }
  };

  xhr.open("POST", "../function/testConnexion.php", true);
  xhr.responseType = "json";
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("connexion=" + encodeURI(connexion));
}
