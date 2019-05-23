$(document).ready(function () {
    $("#friendRequestForm").submit(function () {
        
        const element = $("#friendRequestButton");
        const container = element.parent();

        const friendValue = element.val();
        
        $.ajax({
            url: `${document.location.href}/friend`,
            type: "POST",
            cache: false,
            data: {
                friend: friendValue
            }
        });

        switch (friendValue) {
            case "Cancel Friend Request":
                element.val("Add As Friend");
                container.removeClass("is-red");
                container.addClass("is-green");
            break;
            case "Add As Friend":
                element.val("Cancel Friend Request");
                container.removeClass("is-green");
                container.addClass("is-red");
            break;
            case "Remove Friend":
                element.val("Add As Friend");
            break;
        }

        return false;
    });

    $("#postMessage").click(function () {
        $("#postModal").show();
    });

    $("#postModal .modal-background, .is-pulled-right").click(function (e) {
        if (e.target === this) {
            $("#postModal").hide();
        }
    });

    $("a[data-tab]").click(function () {
        const tab = $(this).attr("data-tab");
        
        const currentActiveTabLi = $(document).find("a > li[class~=\"is-active\"]")
        const currentActiveTab = currentActiveTabLi.parent().attr("data-tab");

        currentActiveTabLi.removeClass("is-active");
        $(this).find("li").addClass("is-active");

        $(`div[data-tab="${currentActiveTab}"]`).hide();
        $(`div[data-tab="${tab}"]`).show();
        if (tab === "messages") {
            const el = document.querySelector("#messages");
            el.scrollTop = el.scrollHeight;
        }
    });

});