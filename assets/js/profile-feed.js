const getFeed = () => {
    const scrollTop = $(window).scrollTop();
    const height = $(window).height();
    const docHeight = $(document).height();
    const nextPageElement = $("#feed").find("input[name=\"page\"]");
    const nextPage = nextPageElement.val();
    if (scrollTop + height >= docHeight - 100 && nextPage) {
        $("#loading").show();
        
        nextPageElement.remove();

        $.ajax({
            url: `${document.location.href}/latest?page=${nextPage}`,
            type: "POST",
            cache: false,
            dataType: "json",
            success: function (data) {
                $("#loading").hide();
                $("#feed").append(data.content);
                updateBlueBars();
            }
        });

    }
};

const updateBlueBars = function () {
    $("#profileBlue").css("height", `${$(document).height()}px`);
};

$(document).ready(function () {
    $("#loading").show();

    $.ajax({
        url: `${document.location.href}/latest`,
        type: "POST",
        cache: false,
        dataType: "json",
        success: function (data) {
            $("#loading").hide();
            $("#feed").html(data.content);
            updateBlueBars();
        }
    });

    $(window).scroll(function () {
        /*
            For some reason the video's code for detecting if the user is at the bottom is not working correctly for me.
            As I'm not familliar with JQuery I used code from stackoverflow.
            https://stackoverflow.com/questions/3898130/check-if-a-user-has-scrolled-to-the-bottom/3898152
        */
        getFeed();

        return false;
    });

});