$(".icon_wrapper img").on("click", function() {
    if (!$(this).hasClass("selected")) {
        var previousIcon = $("img.selected");
        previousIcon.removeClass("selected");
        previousIcon.attr(
            "src",
            `assets/icons/todo_icon/${previousIcon.attr("alt")}.png`
        );
        $(this).attr(
            "src",
            `assets/icons/todo_icon/selected_${$(this).attr("alt")}.png`
        );
        $(this).addClass("selected");

        $("input[name='icon_id']").val($(this).attr("id"));
    }
});