$(document).ready(function () {
    $("input[type=\"file\"]").change(function (e) {
        const file = e.target.files[0].name;
        $(".file-name").text(file);
    });
});