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
     * @param {number|"all"} page The page.
     */
    async getMessages (page = 0) {
        /** @type {{convos: {user: RawConversationUser, message: RawConversationMessage, viewed: boolean}[], unread: number}} */
        const response = await (await fetch(`${this.CONSTANTS.MESSAGES}?page=${page}`)).json();
        const convos = [];
        for (const conversation of response.convos) {
            const convo = new Conversation({
                target: conversation.user,
                messages: [conversation.message],
                viewed: conversation.viewed
            });
            convos.push(convo);
        }
        return {
            convos,
            unread: response.unread
        };
    }
}

const Notifications = new NotificationManager();