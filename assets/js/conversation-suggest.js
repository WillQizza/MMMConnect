$(document).ready(function () {
    $("input[type=\"text\"]").keyup(function(e) {
        const query = $(this).val();
        $.ajax({
            url: `${ROOT}/conversation/suggestions`,
            type: "POST",
            cache: false,
            dataType: "json",
            data: {
                query
            },
            success: function (data) {
                $("#suggestions").html(data.content);
            }
        });
    });

});