$(document).ready(async () => {

    let fetching = false;


    $("#loading").show();
    const feed = await Posts.fetchFeed();
    let page = feed.nextPage;

    $("#loading").hide();
    for (const post of feed.posts) {
        $("#feed").append(post.element);
        post.element = document.querySelector(`article[data-post="${post.id}"]`);
    }

    $(window).scroll(async () => {
        
        /*
            For some reason the video's code for detecting if the user is at the bottom is not working correctly for me.
            As I'm not familliar with JQuery I used code from stackoverflow.
            https://stackoverflow.com/questions/3898130/check-if-a-user-has-scrolled-to-the-bottom/3898152
        */
        const scrollTop = $(window).scrollTop();
        const height = $(window).height();
        const docHeight = $(document).height();
        if (scrollTop + height >= docHeight - 100 && !fetching && page !== -1) {
            fetching = true;
            $("#loading").show();
            const feed = await Posts.fetchFeed(page);
            for (const post of feed.posts) {
                $("#feed").append(post.element);
                post.element = document.querySelector(`article[data-post="${post.id}"]`);
            }

            page = feed.nextPage;
            fetching = false;
            
            $("#loading").hide();
        }

    });

    // Post message.
    const submitForm = $("form[data-form=\"feed-message\"]");
    submitForm.submit(() => {
        const textarea = submitForm.find("textarea");
        const message = textarea.val();
        textarea.val("");
        Posts.postMessage(message).then(data => {
            $("#feed").prepend(data.post.element);
            $("span[data-stat=\"posts\"]").text(data.postCount);
        });

        return false;
    });

    // Show/hide comments.
    $(document).on("click", "a[data-action=\"comment\"]", function () {
        const postId = $(this).attr("data-post");
        const commentsContainer = $(`article[data-post="${postId}"]`).find(".commentsContainer");

        if (commentsContainer.css("display") === "none") {
            commentsContainer.show();
        } else {
            commentsContainer.hide();
        }
    });

    // Post comment.
    $(document).on("submit", "form[data-form=\"feed-comment\"]", function () {
        const postId = $(this).find("input[data-field=\"formPostId\"]").val();
        const textarea = $(this).find("textarea");
        const message = textarea.val();
        textarea.val("");
        Posts.getPostById(postId)
            .comment(message);

        return false;
    });


});