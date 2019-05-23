//@ts-check

class NotificationManager {

    constructor () {
        this.CONSTANTS = {
            //@ts-ignore
            MESSAGES: `${ROOT}notifications/messages`
        };
    }

    /**
     * Get your unread messages.
     * @param {number} page The page.
     */
    async getMessages (page = 0) {
        /** @type {{user: RawConversationUser, message: RawConversationMessage, viewed: boolean}[]} */
        const response = await (await fetch(`${this.CONSTANTS.MESSAGES}?page=${page}`)).json();
        const convos = [];
        for (const conversation of response) {
            const convo = new Conversation({
                target: conversation.user,
                messages: [conversation.message],
                viewed: conversation.viewed
            });
            convos.push(convo);
        }
        return convos;
    }
}

const Notifications = new NotificationManager();