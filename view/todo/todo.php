<?php ob_start(); ?>
<main>
    <header>
        <div class="header_side">
            <img id="left-side_icon" src="assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='index?view=home'">
        </div>

        <div class="header_middle">
            <h1>Travail</h1>
            <h2>Janvier 15 2021</h2>
        </div>

        <div class="header_side">
            <img id="right-side_icon" src="assets\icons\left-arrow.png" class="previousPage" onclick="document.location.href='index?view=home'">
        </div>
    </header>

    <div class='log_container'>
        <div class="log_background">

        </div>
        <div class="log_box">
            <div class="log_wrapper">
                <div class="log_content">
                    <div class="content_left">
                        <h5>1h</h5>
                    </div>
                    <div class="content_right">
                        <h6>Baptiste Lecat</h6>
                        <p>Modification des informations de la tâche : <span>Rangement</span></p>
                    </div>
                </div>

                <div class="log_content">
                    <div class="content_left">
                        <h5>4h</h5>
                    </div>
                    <div class="content_right">
                        <h6>Baptiste Lecat</h6>
                        <p>Archivage de la tâche : Cahier des charges</p>
                    </div>
                </div>

                <div class="log_content">
                    <div class="content_left">
                        <h5>1h</h5>
                    </div>
                    <div class="content_right">
                        <h6>Baptiste Lecat</h6>
                        <p>Réalisation de la tâche : Diagramme de classe</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class='task_wrapper'>

        <?php foreach ($todo->getList_Task() as $task) { ?>
            <div class="parent_container">
                <div class="back_card">
                    <img src="assets\icons\writing.png">
                </div>
                <div class='task_container'>
                    <h6>URGENT</h6>
                    <hr>
                    <div class='task_body'>
                        <div class='task_content'>
                            <h3>Travail</h3>
                            <p><?= $task->getContent(); ?></p>
                        </div>
                    </div>
                    <div class='task_footer'>
                        <div class='task_info'>
                            <img src="assets\icons\todo_task\calendar.png" alt="">
                            <p><?= $task->getEndDate(); ?></p>
                        </div>
                        <div class='task_info'>
                            <img src="assets\icons\todo_task\user.png" alt="">
                            <p>2 personnes</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</main>

<script>
    $(".task_container").each(function() {
        this.addEventListener('touchstart', handleTouchStart, false);
        this.addEventListener('touchmove', handleTouchMove, false);
    });

    var xDown = null;
    var yDown = null;

    function getTouches(evt) {
        return evt.touches || // browser API
            evt.originalEvent.touches; // jQuery
    }

    function handleTouchStart(evt) {
        const firstTouch = getTouches(evt)[0];
        xDown = firstTouch.clientX;
        yDown = firstTouch.clientY;
    };

    function handleTouchMove(evt) {
        if (!xDown || !yDown) {
            return;
        }

        var xUp = evt.touches[0].clientX;
        var yUp = evt.touches[0].clientY;

        var xDiff = xDown - xUp;
        var yDiff = yDown - yUp;

        if (Math.abs(xDiff) > Math.abs(yDiff)) {
            /*most significant*/
            if (xDiff > 0) {
                /* left swipe */
                $(".task_container").each(function() {
                    $(this).removeClass("retract");
                });
                $(this).toggleClass("retract");
            } else {
                /* right swipe */
                $(this).removeClass("retract");
            }
        } else {
            if (yDiff > 0) {
                /* up swipe */
            } else {
                /* down swipe */
            }
        }
        /* reset values */
        xDown = null;
        yDown = null;
    };

    var pressTimer;

    // The item (or items) to press and hold on
    let item = document.querySelector(".task_container");

    let timerID;
    let counter = 0;

    let pressHoldEvent = new CustomEvent("pressHold");

    // Increase or decreae value to adjust how long
    // one should keep pressing down before the pressHold
    // event fires
    let pressHoldDuration = 10;

    // Listening for the mouse and touch events    
    item.addEventListener("mousedown", pressingDown, false);
    item.addEventListener("mouseup", notPressingDown, false);
    item.addEventListener("mouseleave", notPressingDown, false);

    item.addEventListener("touchstart", pressingDown, false);
    item.addEventListener("touchend", notPressingDown, false);

    // Listening for our custom pressHold event
    item.addEventListener("pressHold", doSomething, false);

    function pressingDown(e) {
        // Start the timer
        requestAnimationFrame(timer);

        e.preventDefault();

        console.log("Pressing!");
    }

    function notPressingDown(e) {
        // Stop the timer
        cancelAnimationFrame(timerID);
        counter = 0;

        console.log("Not pressing!");
    }

    //
    // Runs at 60fps when you are pressing down
    //
    function timer() {
        console.log("Timer tick!");

        if (counter < pressHoldDuration) {
            counter++;
            console.log("coucou");
        } else {
            alert("Press threshold reached!");
            item.dispatchEvent(pressHoldEvent);
        }
    }

    function doSomething(e) {
        console.log("pressHold event fired!");
    }
</script>

<?php $this->content = ob_get_clean(); ?>