//@ts-check

/**
 * @typedef RawConversationUser
 * @property {string} avatar
 * @property {string} username
 * @property {string} name
 */

/**
 * @typedef RawConversation
 * @property {RawConversationMessage[]} messages
 * @property {RawConversationUser} target
 * @property {boolean} viewed
 */

/**
 * @typedef RawConversationMessage
 * @property {number} id
 * @property {boolean} weSentThis
 * @property {string} body
 * @property {string} timestamp
 */

class ConversationMessage {

    /**
     * @param {RawConversationMessage} data 
     */
    constructor (data) {
        this.id = data.id;
        this.timestamp = data.timestamp;
        this.body = data.body;
        this.weSentThis = data.weSentThis;

        if (this.weSentThis) {
            //@ts-ignore
            this.element = createTemplate("our-conversation-message", [
                { selector: "div[data-field=\"body\"]", text: this.body }
            ]);
        } else {
            //@ts-ignore
            this.element = createTemplate("their-conversation-message", [
                { selector: "div[data-field=\"body\"]", text: this.body }
            ]);
        }

    }
}

class Conversation {

    /**
     * 
     * @param {RawConversation} data
     */
    constructor (data) {
        this.messages = data.messages.map(data => new ConversationMessage(data));
        this.recipient = data.target;
        this.lastMessage = this.messages[this.messages.length - 1];

        this.viewed = data.viewed;

        this.CONSTANTS = {
            //@ts-ignore
            GET_CONVERSATION: `${ROOT}/conversation/latest/`,
            //@ts-ignore
            POST_MESSAGE: `${ROOT}/conversation/post/`
        };

        let content = this.lastMessage.body;
        if (content.length > 10) {
            content = content.slice(0, 10) + "...";
        }

        //@ts-ignore
        this.element = createTemplate("conversation-preview", [
            //@ts-ignore
            { selector: "a[data-field=\"conversation-link\"]", attributes: { href: `${ROOT}conversation/${this.recipient.username}` } },
            { selector: "a[data-username]", attributes: { "data-username": this.recipient.username } },
            { selector: "img[data-field=\"avatar\"]", attributes: { src: this.recipient.avatar } },
            { selector: "span[data-field=\"suggestionName\"]", text: this.recipient.name },
            { selector: "i[data-field=\"timestamp\"]", text: this.lastMessage.timestamp },
            { selector: "span[data-field=\"body\"]", text: content },
            { selector: "span[data-field=\"who\"]", text: this.lastMessage.weSentThis ? "You" : "They" }
        ]);

    }

    /**
     * Send a message in this conversation.
     * @param {string} message 
     */
    async send (message) {

        /** @type {RawConversationMessage} */
        const data = await (await fetch(`${this.CONSTANTS.POST_MESSAGE}${this.recipient.username}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `message=${encodeURIComponent(message)}`
        })).json();
        const postedMessage = new ConversationMessage(data);
        this.messages.push(postedMessage);
        this.lastMessage = postedMessage;

        return postedMessage;
    }

    /**
     * Returns all the messages since the message id.
     * @param {number} id 
     */
    async getMessagesSince (id = this.lastMessage ? this.lastMessage.id : 0) {
        /** @type {RawConversation} */
        const response = await (await fetch(`${this.CONSTANTS.GET_CONVERSATION}${this.recipient.username}?lastId=${id}`)).json();
        const newMessages = [];
        for (const data of response.messages) {
            const message = new ConversationMessage(data);
            this.messages.push(message);
            newMessages.push(message);
        }
        this.lastMessage = this.messages[this.messages.length - 1];
        if (newMessages.length > 0) {
            let content = this.lastMessage.body;
            if (content.length > 10) {
                content = content.slice(0, 10) + "...";
            }
            // Last message updated. Update element.
            //@ts-ignore
            $(this.element).find("span[data-field=\"who\"]").text(this.lastMessage.weSentThis ? "You" : "They");
            //@ts-ignore
            $(this.element).find("span[data-field=\"body\"]").text(content);
            //@ts-ignore
            $(this.element).find("i[data-field=\"timestamp\"]").text(this.lastMessage.timestamp);
        }
        return newMessages;
    }
}

class ConversationsManager {

    constructor () {
        /** @type {{[username : string]: Conversation}} */
        this.conversations = {};

        this.CONSTANTS = {
            //@ts-ignore
            GET_CONVERSATION: `${ROOT}/conversation/latest/`
        };
    }

    /**
     * @property {string} username
     */
    async getConversation (username) {
        if (!this.conversations[username]) {
            /** @type {RawConversation} */
            const response = await (await fetch(`${this.CONSTANTS.GET_CONVERSATION}${username}`)).json();
            this.conversations[username] = new Conversation(response);
        }
        return this.conversations[username];
    }

    async getConversations () {
        /** @type {{user: RawConversationUser, message: RawConversationMessage, viewed: boolean}[]} */
        const response = await (await fetch(`${this.CONSTANTS.GET_CONVERSATION}`)).json();
        const convos = [];
        for (const conversation of response) {
            const convo = new Conversation({
                target: conversation.user,
                messages: [conversation.message],
                viewed: conversation.viewed
            });
            this.conversations[conversation.user.username] = convo;
            convos.push(convo);
        }
        return convos;
    }
}

const Conversations = new ConversationsManager();