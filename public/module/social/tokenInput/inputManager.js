$(".container_inputs_code input").click(function() {
    if (!$.trim($("#1").val()) != "") {
        $("#1").focus();
    }

    for (var i = 5; i >= 1; i--) {
        if ($.trim($("#" + i).val()) != "") {
            $("#" + (i + 1)).focus();
            break;
        } else if (!$.trim($("#1").val()) != "") {
            $("#1").focus();
        }
    }
});

$(".container_dropdown select").change(function() {
    $(this).addClass("select-entered");
});

$(".tokenInput_container input").click(function() {
    if (!$.trim($("#1").val()) != "") {
        $("#1").focus();
    }

    for (var i = 5; i >= 1; i--) {
        if ($.trim($("#" + i).val()) != "") {
            $("#" + (i + 1)).focus();
            break;
        } else if (!$.trim($("#1").val()) != "") {
            $("#1").focus();
        }
    }
});
$(".tokenInput_container input").on("paste keyup", function() {
    if (this.value.length > 1) {
        var newnb = this.value.slice(-1);
        this.value = this.value.slice(0, 1);
        var newid = +this.id + +1;
        $("#" + newid).val(newnb);
        $("#" + (+this.id + +1)).focus();
    }

    if (!$.trim($(this).val()) != "") {
        $("#" + (this.id - 1)).focus();
    } else {
        var input_complet = 0;
        var array_input = {};

        $(".tokenInput_container input").each(function() {
            if ($.trim($(this).val()) != "") {
                input_complet++;
                array_input[this.id] = $(this).val();
            }
        });

        if (input_complet == 5) {
            code =
                array_input[1] +
                array_input[2] +
                array_input[3] +
                array_input[4] +
                array_input[5];
            //Appel de la fonction de verification de la token.
            submitToken(code);
        }

        for (var i = 5; i >= 1; i--) {
            if ($.trim($("#" + i).val()) != "") {
                $("#" + (i + 1)).focus();
                break;
            }
        }
    }
});