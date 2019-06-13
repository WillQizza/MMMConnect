$(document).ready(async () => {

    // Show/hide comments.
    $(document).on("click", "a[data-action=\"comment\"]", function () {
        const postId = $(this).attr("data-post");
        const commentsContainer = $(`div[data-post="${postId}"]`).find(".commentsContainer");

        if (commentsContainer.css("display") === "none") {
            commentsContainer.show();
        } else {
            commentsContainer.hide();
        }
    });

    // Post comment.
    $(document).on("submit", "form[data-form=\"feed-comment\"]", function () {
        const postId = $(this).find("input[data-field=\"formPostId\"]").val();
        const post = $(`div[data-post="${postId}"]`);
        const textarea = $(this).find("textarea");
        const message = textarea.val();
        textarea.val("");
        Posts.getPostById(postId)
            .then(post => post.comment(message))
            .then(postCount => post.find("span[data-field=\"comments\"]").text(postCount));
        
        return false;
    });

    // Like
    $(document).on("click", "a[data-action=\"like\"]", function () {
        const postId = $(this).attr("data-post");
        Posts.getPostById(postId).then(post => post.like());
        const text = $(this).find("span[data-field=\"likesText\"]");
        const count = $(this).find("span[data-field=\"likesCount\"]");
        if (text.text().startsWith("Like")) {
            text.text("Unlike");
            count.text(Number(count.text()) + 1);
        } else {
            text.text("Like");
            count.text(Number(count.text()) - 1);
        }
    });


    // Modals.
    $(".modal .content span").click(function (e) {
        if (e.target === this) {
            $(".modal").hide();
        }
    });


    // Delete modal
    $(document).on("click", "a[data-action=\"delete\"]", function() {
        const isPost = !$(this).attr("data-comment");
        $("#deleteModal").show();
        if (isPost) {
            $("#deleteModal input[name=\"postId\"]").val($(this).attr("data-post"));
            $("#deleteModal input[name=\"isPost\"]").val(true);
        } else {
            $("#deleteModal input[name=\"postId\"]").val($(this).attr("data-post"));
            $("#deleteModal input[name=\"commentId\"]").val($(this).attr("data-comment"));
            $("#deleteModal input[name=\"isPost\"]").val(false);
        } 
    });

    // Delete.
    $(document).on("submit", "#deleteModal form", function () {
        const postId = $(this).find("input[name=\"postId\"]").val();
        if ($(this).find("input[name=\"isPost\"]").val() === "true") {
            Posts.getPostById(postId).then(post => post.delete());
            $(`div[data-post="${postId}"]`).remove();
            const postsEl = $("span[data-stat=\"posts\"]");
            postsEl.text(Number(postsEl.text()) - 1);
        } else {
            const commentId = Number($(this).find("input[name=\"commentId\"]").val());
            Posts.getPostById(postId).then(post => post.getCommentById(commentId).delete());
            const commentsEl = $(`div[data-post="${postId}"] span[data-field="comments"]`);
            commentsEl.text(Number(commentsEl.text()) - 1);
            $(`.comments div[data-comment="${commentId}"]`).remove();
        }
        $("#deleteModal").hide();

        return false;
    });

    // Edit modal
    $(document).on("click", "a[data-action=\"edit\"]", function () {
        const id = $(this).attr("data-post");
        $("#editModal input[name=\"id\"]").val(id);
        Posts.getPostById(id).then(post => {
            $("#editModal textarea").val(post.body);
            $("#editModal").show();
        });
    });

    // Edit
    $(document).on("submit", "#editModal form", function () {
        const postId = $(this).find("input[name=\"id\"]").val();
        const body = $(this).find("textarea").val();
        Posts.getPostById(postId).then(post => {
            post.edit(body);
            const bodyEl = $(post.element).find("div[data-field=\"body\"]:first")[0];
            $(post.element).find("span[data-field=\"edited\"]").attr("style", "");

            // YT videos.
            $(post.element).find("iframe").remove();
            const videos = [];
            let noVideoBody = body.slice(0);
            let match = noVideoBody.match(/(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+/);
            while (match) {
                
                const unparsedUrl = match[0].split(" ")[0];
                const url = match[0].toLocaleLowerCase().split(" ")[0];

                if (url.includes("watch?v=")) {
                    const getParams = unparsedUrl.substring(unparsedUrl.indexOf("?") + 1).split("&");
                    const found = getParams.find(param => param.startsWith("v"));
                    if (found) {
                        videos.push(found.substring(2));
                    }
                } else {
                    videos.push(unparsedUrl.split("/")[unparsedUrl.split("/").length - 1]);
                }


                noVideoBody = noVideoBody.substring(0, noVideoBody.toLocaleLowerCase().indexOf(url)) + noVideoBody.substring(noVideoBody.toLocaleLowerCase().indexOf(url) + url.length);
                match = noVideoBody.match(/(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+/);
            }

            bodyEl.textContent = noVideoBody;
            bodyEl.innerHTML = markdownify(bodyEl.textContent);

            for (const id of videos) {
                $(post.element).find("div[data-field=\"attachmentContainer\"]").append(`<iframe src="https://www.youtube.com/embed/${encodeURIComponent(id)}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`);
            }

        });
        $("#editModal").hide();
        return false;
    });



});