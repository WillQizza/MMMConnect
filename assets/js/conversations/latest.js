$(document).ready(async () => {

    const urlParts = document.location.href.split("/");
    const username = urlParts[urlParts.length - 1];
    let lastId = 0;
    let fetching = false;
    
    const fetchMessages = async () => {
        if (!fetching) {
            fetching = true;
            const newMessages = await conversation.getMessagesSince(lastId);
            for (const message of newMessages) {
                $("#messages").append(message.element);
            }
            if (newMessages.length > 0) {
                lastId = newMessages[newMessages.length - 1].id;
                const messages = document.querySelector("#messages");
                messages.scrollTop = messages.scrollHeight;
            }
            fetching = false;
        }
    };

    const conversations = await Conversations.getConversations();
    $("img[data-field=\"conversations-loading\"]").hide();
    for (const conversation of conversations) {
        $("#conversations").append(conversation.element);
        conversation.element = document.querySelector(`a[data-username="${conversation.recipient.username}"]`);
    }

    const conversation = await Conversations.getConversation(username);
    await fetchMessages();

    $("#conversationForm").submit(function () {
        const textarea = $(this).find("textarea");
        const message = textarea.val();
        textarea.val("");
        if (message.replace(/\s|\t/g, "").length > 0) { // I haven't added server side checks for this.
            conversation.send(message).then(async () => await fetchMessages());
        }

        return false;
    });

    setInterval(fetchMessages, 5000);
});