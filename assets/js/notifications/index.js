//@ts-check

/**
 * @typedef NotificationRawData
 * @property {string} link
 * @property {string} message
 */

class MMMConnectNotification {
    /**
     * @param {NotificationRawData} data 
     */
    constructor (data) {
        //@ts-ignore
        this.element = createTemplate("post", [
            { selector: "", text: data. }
        ]);
    }
}

class NotificationManager {

    constructor () {
        this.CONSTANTS = {
            //@ts-ignore
            MESSAGES: `${ROOT}notifications/messages`,
            //@ts-ignore
            NOTIFICATIONS: `${ROOT}notifications`
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

    async getNotifications (page = 0) {
        /** @type {{notifications: {}[], unread: number}} */
        const response = await (await fetch(`${this.CONSTANTS.NOTIFICATIONS}?page=${page}`)).json();
        const notifications = [];
        for (const nData of response.notifications) {
            notifications.push(new MMMConnectNotification(nData));
        }
        return {
            notifications,
            unread: response.unread
        };
    }
}

const Notifications = new NotificationManager();