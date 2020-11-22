document.getElementById('test').addEventListener("click", function(e) {
    e.preventDefault();
    var taskManager = document.getElementById("taskManager").value;
    var user = document.getElementById("user").value;
  
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
        var res = this.response;
        console.log(res);
  
        if (res.success == 1) {
          alert("ok");
        }
  
      }else if (this.readyState == 4) {
        alert("Une erreur est survenue..");
      }
    };
  
    xhr.open("POST", "view/dayDisplayer.php", true);
    xhr.responseType = "json";
    xhr.send("taskManager=" + encodeURI(taskManager) + "&userObject=" + encodeURI(user));
  
    return false;
  });