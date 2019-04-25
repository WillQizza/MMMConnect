
<template data-name="post">
    <div class="post" data-tiemstamp="timestamp in ms" data-post="post id">
        <div class="avatar">
            <img class="image image-64x64" src="<?php echo $params["user"]["avatar"] ?>" />
        </div>
        <div class="content">
            <a class="link" href="profile link" data-field="userFullName">user's name</a> <span data-field="target" style="display: none;"> > <a class="link" href="profile link">target's name</a></span> <i class="faded" data-field="timestamp">timestamp</i> <span style="display: none;" data-field="edited"><i class="faded">(edited)</i></span><br />
            <div class="message-content"><span data-field="body">body of the post</span></div>
            <a class="link" data-post="post id" data-action="comment">Comments (<span data-field="comments">Comment count</span>)</a> 
            <a class="link" style="margin-left: 1em;" data-post="post id" data-action="like"><span data-field="likesText">like text</span> (<span data-field="likesCount">Like count</span>)</a> 
            <span data-field="edit" style="display: none;">
                <a class="link" style="margin-left: 1em;" data-action="edit" data-post="post id">Edit</a>
            </span> 
            <div class="commentsContainer">
                <span class="comments"></span>
            </div>
        </div><br />
        
    </div>
    <hr />
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

<template data-name="conversation-preview">
    <a href="conversation link" data-username="username" data-field="conversation-link">
        <article class="media">
            <figure class="media-left">
                <p class="image is-64x64">
                    <img src="avatar" data-field="avatar" />
                </p>
            </figure>
            <div class="media-content gray-text">
                <span class="suggestion-name" data-field="suggestionName">Name</span> <i data-field="timestamp">Timestamp</i><br />
                <span data-field="who">Sender</span> said: <span data-field="body">content</span>
            </div>
        </article>
        <hr class="conversation-line" />
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