$(document).ready(function () {
    $("#loading").show();

    $.ajax({
        url: "./feed/latest",
        type: "POST",
        cache: false,
        dataType: "json",
        success: function (data) {
            $("#loading").hide();
            $("#feed").html(data.content);
        }
    });

    $(window).scroll(function () {
        /*
            For some reason the video's code for detecting if the user is at the bottom is not working correctly for me.
            As I'm not familliar with JQuery I used code from stackoverflow.
            https://stackoverflow.com/questions/3898130/check-if-a-user-has-scrolled-to-the-bottom/3898152
        */
        const scrollTop = $(window).scrollTop();
        const height = $(window).height();
        const docHeight = $(document).height();
        const nextPageElement = $("#feed").find("input[name=\"page\"]");
        const nextPage = nextPageElement.val();
        if (scrollTop + height >= docHeight - 100 && nextPage) {
            $("#loading").show();
            
            nextPageElement.remove();

            $.ajax({
                url: `./feed/latest?page=${nextPage}`,
                type: "POST",
                cache: false,
                dataType: "json",
                success: function (data) {
                    $("#loading").hide();
                    $("#feed").append(data.content);
                }
            });

        }

        return false;
    });

    $("#postForm").submit(function () {
        const textarea = $("#postForm > textarea");
        const body = textarea.val();
        textarea.val("");
        
        $.ajax({
            url: `./feed/post?json=true`,
            type: "POST",
            cache: false,
            dataType: "json",
            data: {
                body
            },
            success: function (data) {
                $("#feed").prepend(data.content);
                $("span[data-stat=\"posts\"]").text(data.postCount);
            }
        });
        return false;
    });
});