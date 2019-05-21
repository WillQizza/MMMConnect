$(document).ready(async () => {

    const ONE_MINUTE = 60000;
    const ONE_HOUR = ONE_MINUTE * 60;
    const ONE_DAY = ONE_HOUR * 24;
    const ONE_MONTH = ONE_DAY * 31; // Not entirely sure if this is accurate enough.
    const ONE_YEAR = ONE_MONTH * 12;

    const SECONDS_BEFORE_CHANGE = 30;

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
            .comment(message).then(amount => {
                post.find("span[data-field=\"comments\"]").text(amount);

            });
        
        return false;
    });

    // Like
    $(document).on("click", "a[data-action=\"like\"]", function () {
        const postId = $(this).attr("data-post");
        Posts.getPostById(postId)
            .like();
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
        const post = Posts.getPostById(postId);
        if ($(this).find("input[name=\"isPost\"]").val() === "true") {
            post.delete();
            $(`div[data-post="${postId}"]`).remove();
            const postsEl = $("span[data-stat=\"posts\"]");
            postsEl.text(Number(postsEl.text()) - 1);
        } else {
            const commentId = Number($(this).find("input[name=\"commentId\"]").val());
            post.getCommentById(commentId)
                .delete();
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
        $("#editModal textarea").val($(`div[data-post="${id}"] .message-content`).text());
        $("#editModal").show();
    });

    // Edit
    $(document).on("submit", "#editModal form", function () {
        const postId = $(this).find("input[name=\"id\"]").val();
        const post = Posts.getPostById(postId);
        const body = $(this).find("textarea").val();
        post.edit(body);
        $(post.element).find("span[data-field=\"body\"]").text(body);
        $(post.element).find("span[data-field=\"edited\"]").attr("style", "");
        $("#editModal").hide();
        return false;
    });


    // Timestamps

    setInterval(function () {
        const posts = $("div[data-timestamp]");
        posts.each((_,post) => {
            const timestamp = post.getAttribute("data-timestamp");
            const timestampElement = post.querySelector(".faded");
            
            // Convert our time to server's time if not already.

            const now = new Date();
            const utc = now.getTime() + now.getTimezoneOffset() * 60000;
            const serverTime = new Date(utc + (3600000 * -6));
            const diff = serverTime.getTime() - timestamp;
            if (diff > ONE_YEAR) {
                const years = Math.floor(diff / ONE_YEAR);
                timestampElement.textContent = `${years} year${years > 1 ? "s" : ""} ago`;
            } else if (diff > ONE_MONTH) {
                const months = Math.floor(diff / ONE_MONTH);
                const days = Math.floor((diff - months * ONE_MONTH) / ONE_DAY);
                timestampElement.textContent = `${months} month${months > 1 ? "s" : ""} ago ${days !== 0 ? `& ${days} day${days > 1 ? "s" : ""} ago` : ""}`;
            } else if (diff > ONE_DAY) {
                const days = Math.floor(diff / ONE_DAY);
                if (days === 1) {
                    timestampElement.textContent = "Yesterday";
                } else {
                    timestampElement.textContent = `${days} day${days > 1 ? "s" : ""} ago`;
                }
            } else if (diff > ONE_HOUR) {
                const hours = Math.floor(diff / ONE_HOUR);
                timestampElement.textContent = `${hours} hour${hours > 1 ? "s" : ""} ago`;
            } else if (diff > ONE_MINUTE) {
                const minutes = Math.floor(diff / ONE_MINUTE);
                timestampElement.textContent = `${minutes} minute${minutes > 1 ? "s" : ""} ago`;
            } else {
                const seconds = Math.floor(diff / 1000);
                if (seconds > SECONDS_BEFORE_CHANGE) {
                    timestampElement.textContent = `${seconds} seconds ago`;
                } else {
                    timestampElement.textContent = "Just now";
                }
            }
            
        });
    }, 1000);


});