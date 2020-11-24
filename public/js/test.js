document.getElementById('test').addEventListener("click", function(e) {
    e.preventDefault();
<<<<<<< Updated upstream:public/js/test.js
    var taskManager = document.getElementById("taskManager").value;
    var user = document.getElementById("user").value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = this.response;
            alert(res);

        } else if (this.readyState == 4) {
            alert("Une erreur est survenue..");
        }
    };

    xhr.open("POST", "function/dayDisplayer.php", true);
    xhr.responseType = "json";
    xhr.send("taskManager=" + encodeURI(taskManager) + "&userObject=" + encodeURI(user));

=======
  
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        var res = this.response;
        console.log(res);
  
      }else if (this.readyState == 4) {
        alert("Une erreur est survenue..");
      }
    };
  
    xhr.open("POST", "function/switch_dayDisplayer.php", true);
    xhr.responseType = "json";
    xhr.send();
  
>>>>>>> Stashed changes:public/function/test.js
    return false;
});