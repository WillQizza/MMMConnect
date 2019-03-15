$(document).on("click", "article[data-post]", function () {
    const id = this.getAttribute("data-post");
    const commentsContainer = $(`article[data-post="${id}"] .commentsContainer`);
    const display = commentsContainer.css("display");
    if (display === "none") {
        commentsContainer.show();
    } else {
        commentsContainer.hide();
    }
});