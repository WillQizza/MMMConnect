<template data-name="post">
    <article class="media" data-timestamp="timestamp in ms" data-post="post id">
        <figure class="media-left">
            <img class="image is-64x64" data-field="avatar" src="avatar url" />
        </figure>
        <div class="media-content">
            <div class="content">
                <span class="is-pulled-right deletePost" data-field="delete" style="display: none;">
                    <a data-post="post id" data-action="delete">
                        <i class="fa fa-trash"></i>
                    </a>
                </span>
                <p>
                    <a href="profile link" data-field="userFullName">user's name</a> <span data-field="target" style="display: none;"> > <a href="profile link">target's name</a></span> <i class="faded" data-field="timestamp">timestamp</i> <span style="display: none;" data-field="edited"><i class="faded">(edited)</i></span><br />
                    <span class="message-content" data-field="body">body of the post</span>
                </p>
                <a data-post="post id" data-action="comment">Comments (<span data-field="comments">Comment count</span>)</a> 
                <a style="margin-left: 1em;" data-post="post id" data-action="like"><span data-field="likesText">like text</span> (<span data-field="likesCount">Like count</span>)</a> 
                <span data-field="edit" style="display: none;">
                    <a style="margin-left: 1em;" data-action="edit" data-post="post id">Edit</a>
                </span> 
            </div>
            <div class="commentsContainer">
                <span class="comments"></span>
                <article class="media">
                    <div class="media-content">
                        <form class="commentForm" action="<?php echo $params["BASE"] ?>feed/postcomment" data-form="feed-comment" method="POST">
                            <textarea placeholder="What do you want to add?" name="body"></textarea>
                            <input class="submitButton" type="submit" value="Post" />
                            <input type="hidden" name="postId" data-field="formPostId" value="post id" />
                        </form>
                    </div>
                </article>
            </div>
        </div>
    </article>
</template>

<template data-name="comment">
    <article class="media" data-comment="comment id" data-timestamp="timestamp in ms">
        <div class="media-left">
            <img class="image is-64x64" data-field="avatar" src="avatar url" />
        </div>
        <div class="media-content">
            <div class="content">
                <span style="display: none;" class="is-pulled-right deleteComment" data-field="delete">
                    <a data-comment="comment id" data-action="delete" data-post="post id">
                        <i class="fa fa-trash"></i>
                    </a>
                </span>
                <p>
                    <a href="profile url" data-field="userFullName">User's name</a> <i class="faded" data-field="timestamp">timestamp</i><br />
                    <span data-field="body"></span>
                </p>
            </div>
        </div>
    </article>
</template>