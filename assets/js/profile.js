$(document).ready(function () {
    $("#friendRequestForm").submit(function () {
        
        const element = $("#friendRequestButton");

        const friendValue = element.val();
        
        $.ajax({
            url: `${document.location.href}/friend`,
            type: "POST",
            cache: false,
            dataType: "json",
            data: {
                friend: friendValue
            }
        });

        switch (friendValue) {
            case "Cancel Friend Request":
                element.val("Add As Friend");
                element.removeClass("is-danger");
                element.addClass("is-success");
            break;
            case "Add As Friend":
                element.val("Cancel Friend Request");
                element.removeClass("is-success");
                element.addClass("is-danger");
            break;
            case "Remove Friend":
                element.val("Add As Friend");
            break;
            case "Accept":
                element.val("Remove Friend");
                $("")
            break;
            case "Decline":

            break;
        }

        return false;
    });
});