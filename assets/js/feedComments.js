$(document).on("click", "article[data-post] a", function () {
    const id = this.getAttribute("data-post");
    const commentsContainer = $(`article[data-post="${id}"] .commentsContainer`);
    const display = commentsContainer.css("display");
    if (display === "none") {
        commentsContainer.show();
    } else {
        commentsContainer.hide();
    }
});

$(document).on("submit", ".commentForm", function () {
    const form = this;
    const body = $(form).find("textarea").val();
    $.ajax({
        url: "./feed/postcomment",
        type: "POST",
        cache: false,
        dataType: "json",
        data: {
            body,
            postId: $(this).find("input[type=\"hidden\"]").val()
        },
        success: function (data) {
            console.log(data);
            form.parentElement.prepend(data.content);
        }
    });
    return false;
});