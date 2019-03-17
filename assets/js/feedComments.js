$(document).on("click", "article[data-post] a[data-action=\"comment\"]", function () {
    const id = this.getAttribute("data-post");
    const commentsContainer = $(`article[data-post="${id}"] .commentsContainer`);
    const display = commentsContainer.css("display");
    if (display === "none") {
        commentsContainer.show();
    } else {
        commentsContainer.hide();
    }
});

$(document).on("click", "article[data-post] a[data-action=\"like\"]", function () {
    const likesEl = this;
    const postId = likesEl.getAttribute("data-post");
    const likes = Number(likesEl.textContent.split(" ")[1].slice(1, -1));
    if (likesEl.textContent.includes("Like")) {
        likesEl.textContent = `Unlike (${likes + 1})`;
    } else {
        likesEl.textContent = `Like (${likes - 1})`;
    }
    $.ajax({
        url: "./feed/likecomment",
        type: "POST",
        cache: false,
        dataType: "json",
        data: {
            postId
        },
        success: function (data) {
            likesEl.textContent = likesEl.textContent.substring(0, likesEl.textContent.indexOf("(")) + `(${data.likes})`;
        }
    });
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
            $(form).find("textarea").val("");
            $(form.parentElement.parentElement.parentElement).find("span").append(data.content);
        }
    });
    return false;
});