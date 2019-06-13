//@ts-check

/**
 * @typedef RawCommentData
 * @property {number} id
 * @property {boolean} userSentThis
 * @property {number} timestampMs
 * @property {string} timestamp
 * @property {string} avatar
 * @property {{name : string, profile: string}} user
 * @property {string} body
 */

/**
 * @typedef RawPostData
 * @property {string} avatar
 * @property {string} body
 * @property {number} id
 * @property {{name: string, profile: string}} target
 * @property {boolean} targetedMessage
 * @property {string} timestamp
 * @property {number} timestampMs
 * @property {number} likes
 * @property {{name: string, profile: string}} user
 * @property {boolean} userSentThis
 * @property {boolean} likedPost
 * @property {boolean} edited
 * @property {boolean} userSentThis
 * @property {string} attachment
 * @property {RawCommentData[]} comments
 */

class PostComment {

    /**
     * 
     * @param {RawCommentData} data 
     * @param {Post} post
     */
    constructor (data, post) {

        this.id = data.id;
        this.body = data.body
            .replace(/&amp;/g, "&")
            .replace(/lt;/g, "<")
            .replace(/&quot;/g, "\"");

        const specialSelectors = [];
        if (data.userSentThis) {
            specialSelectors.push({ selector: "span[data-field=\"delete\"]", attributes: { style: ""} });
            specialSelectors.push({ selector: "a[data-action=\"delete\"]", attributes: { "data-post": post.id, "data-comment": this.id  } });
        }

        //@ts-ignore
        this.element = createTemplate("comment", [
            ...specialSelectors,
            { selector: "div[data-timestamp]", attributes: { "data-timestamp": data.timestampMs, "data-comment": this.id } },
            { selector: "img[data-field=\"avatar\"]", attributes: { src: data.avatar } },
            { selector: "a[data-field=\"userFullName\"]", attributes: { href: data.user.profile }, text: data.user.name },
            { selector: "i[data-field=\"timestamp\"]", text: data.timestamp },
            { selector: "div[data-field=\"body\"]", text: data.body }
        ]);

        this.CONSTANTS = {
            //@ts-ignore
            DELETE_COMMENT: `${ROOT}feed/deletecomment`
        };
    }

    /**
     * Delete this post.
     */
    async delete () {
        await fetch(this.CONSTANTS.DELETE_COMMENT, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `commentId=${this.id}`
        });
    }

}

class Post {

    /**
     * @param {RawPostData} data 
     */
    constructor (data) {

        this.id = data.id;
        this.body = data.body
            //.replace(/&amp;/g, "&")
            .replace(/&lt;/g, "<")
            .replace(/&gt;/g, ">")
            .replace(/&quot;/g, "\"");

        this.attachment = data.attachment;

        this.CONSTANTS = {
            //@ts-ignore
            POST_COMMENT: `${ROOT}feed/postcomment`,
            //@ts-ignore
            LIKE_POST: `${ROOT}feed/likecomment`,
            //@ts-ignore
            DELETE_POST: `${ROOT}feed/deletepost`,
            //@ts-ignore
            EDIT_POST: `${ROOT}feed/editpost`,
        };

        const specialSelectors = [];
        if (data.edited) {
            specialSelectors.push({ selector: "span[data-field=\"edited\"]", attributes: { style: "" } });
        }
        if (data.userSentThis) {
            specialSelectors.push({ selector: "span[data-field=\"delete\"]", attributes: { style: "" } });
            specialSelectors.push({ selector: "span[data-field=\"edit\"]", attributes: { style: "" } });
        }
        if (data.targetedMessage) {
            specialSelectors.push({ selector: "span[data-field=\"target\"]", attributes: { style: "" } });
            specialSelectors.push({ selector: "span[data-field=\"target\"] a", attributes: { href: data.target.profile }, text: data.target.name });
        }
        if (data.attachment) {
            specialSelectors.push({ selector: "div[data-field=\"attachmentContainer\"]", attributes: { style: "" } });
        }

        //@ts-ignore
        this.element = createTemplate("post", [
            ...specialSelectors,
            { selector: "a[data-field=\"userFullName\"]", attributes: { href: data.user.profile },  text: data.user.name },
            { selector: "img[data-field=\"avatar\"]", attributes: { src: data.avatar } },
            { selector: "i[data-field=\"timestamp\"]", text: data.timestamp },
            { selector: "div[data-field=\"body\"]", text: data.body },
            { selector: "span[data-field=\"likesCount\"]", text: data.likes },
            { selector: "div[data-timestamp]", attributes: { "data-timestamp": data.timestampMs } },
            { selector: "*[data-post]", attributes: { "data-post": data.id } },
            { selector: "span[data-field=\"likesText\"]", text: data.likedPost ? "Unlike" : "Like" },
            { selector: "span[data-field=\"comments\"]", text: data.comments.length },
            { selector: "input[data-field=\"formPostId\"]", value: data.id },
            { selector: "img[data-field=\"attachment\"]", attributes: { src: data.attachment } },
        ]);

        this.comments = data.comments.map(data => new PostComment(data, this));
        for (const comment of this.comments) {
            this.element.querySelector(".comments").appendChild(comment.element);
        }
    }

    /**
     * Id of the comment.
     * @param {number} id 
     */
    getCommentById (id) {
        return this.comments.find(comment => comment.id === id);
    }

    /**
     * Like/unlike this post
     */
    async like () {
        await fetch(this.CONSTANTS.LIKE_POST, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `postId=${this.id}`
        });
    }

    /**
     * Delete this post.
     */
    async delete () {
        await fetch(this.CONSTANTS.DELETE_POST, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `postId=${this.id}`
        });
    }

    /**
     * Edit this message.
     * @param {string} content 
     */
    async edit (content) {
        this.body = content;
        await fetch(this.CONSTANTS.EDIT_POST, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `postId=${this.id}&body=${encodeURIComponent(content)}`
        });
    }

    /**
     * Post a comment on this post.
     * @param {string} message 
     */
    async comment (message) {
        const response = await (await fetch(this.CONSTANTS.POST_COMMENT, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `message=${encodeURIComponent(message)}&id=${this.id}`
        })).json();
        const comment = new PostComment(response, this);
        this.comments.push(comment);
        this.element.querySelector(".comments").appendChild(comment.element);
        return this.comments.length;
    }
}

class PostsManager {
    constructor () {
        this.CONSTANTS = {
            //@ts-ignore - ROOT is defined in the caller file.
            FEED_URL: `${ROOT}feed/latest`,
            //@ts-ignore
            POST_MESSAGE: `${ROOT}feed/post`,
            //@ts-ignore
            PROFILE_FEED_URL: `${ROOT}feed/profile`,
            //@ts-ignore
            POST_PROFILE_MESSAGE: `${ROOT}profile`,
            //@ts-ignore
            GET_POST: `${ROOT}feed/getpost`
        };

        this.posts = {};
    }

    /**
     * Fetch the user's feed.
     * @param {number} page Page.
     */
    async fetchFeed (page = 0) {
        /** @type {{posts: RawPostData[], nextPage: number}} */
        const rawPostsData = await (await fetch(`${this.CONSTANTS.FEED_URL}?page=${page}`)).json();
        const posts = rawPostsData.posts.map(data => new Post(data));
        for (const post of posts) {
            this.posts[post.id] = post;
        }
        return {
            posts,
            nextPage: rawPostsData.nextPage
        };
    }

    /**
     * Fetch the user's feed for a profile.
     * @param {string} username 
     * @param {number} page 
     */
    async fetchFeedForProfile (username, page = 0) {
        /** @type {{posts: RawPostData[], nextPage: number}} */
        const rawPostsData = await (await fetch(`${this.CONSTANTS.PROFILE_FEED_URL}?page=${page}&profile=${username}`)).json();
        const posts = rawPostsData.posts.map(data => new Post(data));
        for (const post of posts) {
            this.posts[post.id] = post;
        }
        return {
            posts,
            nextPage: rawPostsData.nextPage
        };
    }

    /**
     * Post a message.
     * @param {string} message 
     */
    async postMessage (message, attachment) {
        const data = new FormData();
        data.append("message", message);
        if (attachment) data.append("image", attachment);
        const response = await (await fetch(this.CONSTANTS.POST_MESSAGE, {
            method: "POST",
            body: data
        })).json();
        const post = new Post(response.post);
        this.posts[post.id] = post;
        return {
            post,
            postCount: response.postCount
        };
    }

    async postProfileMessage (username, message) {
        const response = await (await fetch(`${this.CONSTANTS.POST_PROFILE_MESSAGE}/${username}/post`, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `message=${encodeURIComponent(message)}&submit`
        })).json();
        const post = new Post(response.post);
        this.posts[post.id] = post;
        return {
            post,
            postCount: response.postCount
        };
    }

    /**
     * Get a post by it's id.
     * @param {number} id 
     */
    async getPostById (id) {
        if (this.posts[id]) {
            return this.posts[id];
        }
        const response = await (await fetch(`${this.CONSTANTS.GET_POST}?id=${id}`)).json();
        const post = new Post(response.post);
        this.posts[id] = post;
        return post;
    }
}


const Posts = new PostsManager();