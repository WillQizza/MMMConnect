<template data-name="post">
    <div class="post" data-timestamp="timestamp in ms" data-post="post id">
        <div class="avatar">
            <img class="image image-64x64" data-field="avatar" src="avatar url" />
        </div>
        <div class="content">
            <span style="display: none;" class="keep-right deleteComment" data-field="delete">
                <a class="link" data-post="post id" data-action="delete">
                    <i class="fa fa-trash"></i>
                </a>
            </span>
            <a class="link" href="profile link" data-field="userFullName">user's name</a> <span data-field="target" style="display: none;"> > <a class="link" href="profile link">target's name</a></span> <i class="faded" data-field="timestamp">timestamp</i> <span style="display: none;" data-field="edited"><i class="faded">(edited)</i></span><br />
            <div data-field="body" class="message-content"></div>
            <div data-field="attachmentContainer" class="center-text" style="display:none;"><img data-field="attachment" /></div>
            <a class="link" data-post="post id" data-action="comment">Comments (<span data-field="comments">Comment count</span>)</a> 
            <a class="link" style="margin-left: 1em;" data-post="post id" data-action="like"><span data-field="likesText">like text</span> (<span data-field="likesCount">Like count</span>)</a> 
            <span data-field="edit" style="display: none;">
                <a class="link" style="margin-left: 1em;" data-action="edit" data-post="post id">Edit</a>
            </span>
            <div class="commentsContainer" style="display: none;">
                <div class="comments"></div>
                <br />
                <form class="commentForm" action="<?php echo $params["BASE"] ?>feed/postcomment" data-form="feed-comment" method="POST">
                    <textarea class="form-textarea" placeholder="What do you want to add?" name="body"></textarea>
                    <input class="input submitButton" type="submit" value="Post" />
                    <input type="hidden" name="postId" data-field="formPostId" value="post id" />
                </form>
            </div><br /><hr />
        </div>
            
    </div><br />
</template>

<template data-name="comment">
    <div class="post" data-timestamp="timestamp in ms" data-comment="comment id">
        <div class="avatar">
            <img class="image image-64x64" data-field="avatar" src="avatar url" />
        </div>
        <div class="content">
            <span style="display: none;" class="keep-right deleteComment" data-field="delete">
                <a class="link" data-comment="comment id" data-action="delete" data-post="post id">
                    <i class="fa fa-trash"></i>
                </a>
            </span>
            <a class="link" href="profile link" data-field="userFullName">user's name</a> <i class="faded" data-field="timestamp">timestamp</i><br />
            <div class="message-content" data-field="body">body of the post</div>
            <br />
        </div>
    </div>
</template>

<template data-name="conversation-preview">
    <a href="conversation link" data-username="username" data-field="conversation-link">
        <div class="post" data-timestamp="timestamp in ms">
            <div class="avatar">
                <img class="image image-64x64" src="avatar" data-field="avatar" />
            </div>
            <div class="content">
                <span class="link" data-field="suggestionName">Name</span> <i class="faded" data-field="timestamp">Timestamp</i><br />
                <span data-field="who">Sender</span> said: <span data-field="body">content</span>
            </div>
        </div>
    </a>
</template>

<template data-name="notification">
    <a href="notification link" data-field="link">
        <div class="post" data-timestamp="timestamp in ms">
            <div class="avatar">
                <img class="image image-64x64" src="avatar" data-field="avatar" />
            </div>
            <div class="content">
                <i class="faded" data-field="timestamp">1 hour ago</i><br />
                <div class="message-content" style="padding-top: 0;"><span class="link" data-field="body">body of the post</span></div>
            </div>
        </div>
    </a>
</template>

<template data-name="our-conversation-message">
    <div class="our-message message" data-field="body">
        Our message
    </div><br /><br />
</template>

<template data-name="their-conversation-message">
    <div class="their-message message" data-field="body">
        Their message
    </div><br /><br />
</template>