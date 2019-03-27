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

$(document).on("click", "article[data-post] a[data-action=\"delete\"]", function () {
    const isPost = !!$(this).attr("data-post");
    $.ajax({
        url: isPost ? "./feed/deletepost" : "./feed/deletecomment",
        type: "POST",
        cache: false,
        data: {
            id: isPost ? $(this).attr("data-post") : $(this).attr("data-comment")
        }
    });
    if (isPost) {
        $(this).parentsUntil("#feed").remove();
        $("span[data-stat=\"posts\"]").text(Number($("span[data-stat=\"posts\"]").text()) - 1);
    } else {
        const commentsEl = $(this).parentsUntil("article[data-post]").find("a[data-action=\"comment\"]");
        const comments = Number(commentsEl.text().split(" ")[1].slice(1, -1));
        commentsEl.text(`Comments (${comments - 1})`);

        $(this).parentsUntil(".comments").remove();
    }
    getFeed();
});

$(document).on("submit", ".commentForm", function () {
    const form = this;
    const body = $(form).find("textarea").val();
    const postId = $(this).find("input[type=\"hidden\"]").val();
    $.ajax({
        url: "./feed/postcomment",
        type: "POST",
        cache: false,
        dataType: "json",
        data: {
            body,
            postId
        },
        success: function (data) {
            $(form).find("textarea").val("");
            $(`article[data-post="${postId}"] .comments`).append(data.content);

            const commentsEl = $(`article[data-post="${postId}"] a[data-action=\"comment\"]`);
            const comments = Number(commentsEl.text().split(" ")[1].slice(1, -1));
            commentsEl.text(`Comments (${comments + 1})`);

        }
    });
    return false;
});