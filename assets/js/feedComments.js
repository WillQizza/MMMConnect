$(document).ready(function () {

    $(".modal-background, .modal-content a, .modal-content span").click(function (e) {
        if (e.target === this) {
            $(".modal").removeClass("is-active");
        } else {
            console.log(e.target, this);
        }
    });

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
            url: `${ROOT}/feed/likecomment`,
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
        const id = isPost ? $(this).attr("data-post") : $(this).attr("data-comment");
        $("#deleteModal").addClass("is-active");
        $("#deleteModal input[name=\"id\"]").val(id);
        if (isPost) {
            $("#deleteModal form").attr("action", `${ROOT}/feed/deletepost`);
        } else {
            $("#deleteModal form").attr("action", `${ROOT}/feed/deletecomment`);
        }
    });

    $(document).on("submit", ".commentForm", function () {
        const form = this;
        const body = $(form).find("textarea").val();
        const postId = $(this).find("input[type=\"hidden\"]").val();
        $.ajax({
            url: `${ROOT}/feed/postcomment`,
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

});