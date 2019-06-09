//@ts-check

/**
 * @typedef NotificationRawData
 * @property {string} link
 * @property {string} message
 * @property {{ avatar: string, name: string, username: string }} user
 * @property {string} timestamp
 * @property {number} timestampMs
 * @property {boolean} opened
 */

class MMMConnectNotification {
    /**
     * @param {NotificationRawData} data 
     */
    constructor (data) {

        const specialOptions = [];
        if (!data.opened) {
            specialOptions.push({ selector: "div[class=\"post\"]", attributes: { class: "post tint-blue" } });
        }

        //@ts-ignore
        this.element = createTemplate("notification", [
            ...specialOptions,
            { selector: "a[data-field=\"link\"]", attributes: { href: data.link } },
            { selector: "img[data-field=\"avatar\"]", attributes: { src: data.user.avatar } },
            { selector: "span[data-field=\"userFullName\"]", text: data.user.name },
            { selector: "span[data-field=\"body\"]", text: data.message },
            { selector: "i[data-field=\"timestamp\"]", text: data.timestamp },
            { selector: ".post", attributes: { "data-timestamp": data.timestampMs } }
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
        /** @type {{convos: {user: RawConversationUser, message: RawConversationMessage, viewed: boolean, timestampMs: number}[], unread: number}} */
        const response = await (await fetch(`${this.CONSTANTS.MESSAGES}?page=${page}`)).json();
        const convos = [];
        for (const conversation of response.convos) {
            const convo = new Conversation({
                target: conversation.user,
                messages: [conversation.message],
                viewed: conversation.viewed,
                timestampMs: conversation.timestampMs
            });
            convos.push(convo);
        }
        return {
            convos,
            unread: response.unread
        };
    }

    async getNotifications (page = 0) {
        /** @type {{notifications: NotificationRawData[], unread: number}} */
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