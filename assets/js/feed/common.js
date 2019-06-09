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
        $("#editModal textarea").val($(`div[data-post="${id}"] > .content > .message-content`).text());
        $("#editModal").show();
    });

    // Edit
    $(document).on("submit", "#editModal form", function () {
        const postId = $(this).find("input[name=\"id\"]").val();
        const body = $(this).find("textarea").val();
        Posts.getPostById(postId).then(post => post.edit(body));
        $(post.element).find("div[data-field=\"body\"]:first").text(body);
        $(post.element).find("span[data-field=\"edited\"]").attr("style", "");
        $("#editModal").hide();
        return false;
    });



});