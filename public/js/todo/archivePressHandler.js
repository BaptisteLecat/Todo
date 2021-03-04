var onlongtouch;
    var timer;
    var touchduration = 500; //length of time we want the user to touch before we do something

    function archivePressTouchStart() {
        timer = setTimeout(onlongtouch, touchduration);
    }

    function archivePressTouchEnd() {
      //stops short touches from firing the event
      if (timer) {
        clearTimeout(timer); // clearTimeout, not cleartimeout..
      }
    }

    onlongtouch = function() {
        $(".task_container").each(function() {
            var isFinded = false;
            var findedIndex;
            archiveTaskId.forEach(idTask => {
                console.log(idTask);
                if(idTask == this.getAttribute("name")){
                    findedIndex = idTask.indexOf();
                    isFinded = true;
                }
            });

            if(isFinded){
                //On le déselectionne
                this.style.border = "none";
                archiveTaskId.splice(0, findedIndex);
            }else{
                this.style.border = "2px solid #f25f5c";
                archiveTaskId.push(this.getAttribute("name"));
            }
        });
    }