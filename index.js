jQuery(function($) {
    $(".btn-echipa").click(function () {
        $(this).parent().parent().siblings().find(".collapse").removeClass("in");
        $(this).parent().parent().siblings().find(".btn-echipa").text("Vezi echipa");

        if($(this).next().hasClass("in")) {
            $(this).text("Vezi echipa");
        } else {
            $(this).text("Ascunde");
        }
    });

    $(".modificaJucator").click(function(e) {
        e.preventDefault();
        var tabel = $(this).parents().eq(2).prev();
        console.log($(tabel));
        $(tabel).find("tbody tr").addClass("selectPlayer");

        $(".selectPlayer td").click(function() {
            var playerInfo = $(this).parent();
            $(".input_idJucator").val($(playerInfo).data("id"));
            $(".input_prenume").val($(playerInfo).find(".td_prenume span").text());
            $(".input_nume").val($(playerInfo).find(".td_nume span").text());
            $(".input_nationalitate").val($(playerInfo).find(".td_nationalitate span").text());
            $(".input_imgURL").val($(playerInfo).find(".td_imgPath img").attr("src"));

            $("#modificaJucator").modal("show");
        });
    });

    $(".adaugaJucator").click(function(e) {
        e.preventDefault();
        var idEchipa = $(this).parents().eq(2).attr("id").split("echipa")[1];
        $(".input_idEchipa").val(idEchipa);
        $("#adaugaJucator").modal("show");
    });

    $(".stergeJucator").click(function(e) {
        e.preventDefault();
        var tabel = $(this).parents().eq(2).prev();
        console.log($(tabel));
        $(tabel).find("tbody tr").addClass("selectPlayer");

        $(".selectPlayer td").click(function() {
            var playerInfo = $(this).parent();
            $(".input_idJucator").val($(playerInfo).data("id"));

            $("#stergeJucator .check").append($(playerInfo).find(".td_nume span").text() + "?");

            $("#stergeJucator").modal("show");
        });
    });

    $("#stergeJucator, #modificaJucator").on('hide.bs.modal', function() {
        $("tbody tr").removeClass("selectPlayer");
    });
});