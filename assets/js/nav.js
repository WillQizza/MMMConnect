$(document).ready(() => {

    const show = () => $(".nav-dropdown").show();
    const hide = () => $(".nav-dropdown").hide();

    let fetchedMessages = {
        status: false,
        data: []
    };

    let fetching = false;
    let page = 0;

    let activeDropdown = "";

    $(".dropdown[data-notification=\"messages\"]").mouseenter(async () => {
        activeDropdown = "messages";
        show();
        if (!fetchedMessages.status) {
            fetchedMessages.status = true;
            const data = await Notifications.getMessages();
            fetchedMessages.data = data.convos;
            $("div[data-notification=\"messages\"]").text(data.unread > 0 ? data.unread : "");
        }
        $(".nav-dropdown").empty();
        for (const c of fetchedMessages.data) {
            c.element = $($(".nav-dropdown").append(c.element)[0]).children().last(); // Wackity hack hack.
            if (!c.viewed && !c.lastMessage.weSentThis) {
                $(`.nav-dropdown a[data-username="${c.recipient.username}"] .post`).addClass("tint-blue");
            }         
        }
    });

    $(".nav, .nav-dropdown").mouseleave(() => {
        if ($(".nav-dropdown:hover").length === 0) {
            hide();
        }
    });

    $(".nav-dropdown").scroll(async function () {
        const scrollTop = $(this).scrollTop();
        const height = $(this).height();
        const scrollHeight = $(this)[0].scrollHeight;
        if (height + scrollTop >= scrollHeight - 100 && !fetching) {
            if (activeDropdown === "messages") {
                fetching = true;
                const data = await Notifications.getMessages(page);
                fetchedMessages.data = fetchedMessages.data.concat(data.convos);
                $("div[data-notification=\"messages\"]").text(data.unread > 0 ? data.unread : "");
                page++;
                for (const c of data.convos) {
                    c.element = $($(".nav-dropdown").append(c.element)[0]).children().last(); // Wackity hack hack.     
                    if (!c.viewed && !c.lastMessage.weSentThis) {
                        $(`.nav-dropdown a[data-username="${c.recipient.username}"] .post`).addClass("tint-blue");
                    }         
                }
                if (data.convos.length > 0) fetching = false;
            }
        }

    });


});