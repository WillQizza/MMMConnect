$(document).ready(function () {
    $("#signupButton").click(function () {
        $("#login").slideUp("slow", function () {
            $("#register").slideDown("slow");
        });
    });

    $("#loginButton").click(function () {
        $("#register").slideUp("slow", function () {
            $("#login").slideDown("slow");
        });
    });

    $("#register input").on({
        keydown: function (e) {
            return !(e.which === 32);
        },
        change: function () {
            this.value = this.value.replace(/\s/g, "");
        }
    });
});