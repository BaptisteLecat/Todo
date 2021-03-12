function archiveButtonManager() {
    console.log(archiveTaskId.length);
    if (archiveTaskId.length > 0) {
        document.getElementsByClassName("archive_container")[0].style.height = "30px";
    } else {
        document.getElementsByClassName("archive_container")[0].style.height = "0px";
    }
}