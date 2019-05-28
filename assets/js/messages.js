$(document).ready(async () => {

    const show = () => $(".nav-dropdown").show();
    const hide = () => $(".nav-dropdown").hide();

    let fetched = false;
    let fetching = false;
    let page = 1;

    const convos = await Notifications.getMessages("all");
    let notifications = convos.filter(c => !c.viewed).length;
    if (notifications > 0) {
        document.querySelector("span[data-field=\"messages-unread\"]").textContent = notifications;
    }

    $(".dropdown, .nav-dropdown").mouseenter(async () => {
        show();
        if (!fetched) {
            fetched = true;
            const convos = await Notifications.getMessages();
            $(".nav-dropdown").empty();
            for (const c of convos) {
                $(".nav-dropdown").append(c.element);       
                if (!c.viewed && !c.lastMessage.weSentThis) {
                    $(`.nav-dropdown a[data-username="${c.recipient.username}"] .post`).addClass("tint-blue");
                }         
            }
        }
    });

    $(".dropdown, .nav-dropdown").mouseleave(hide);


    $(".nav-dropdown").scroll(async function () {
        const scrollTop = $(this).scrollTop();
        const height = $(this).height();
        const scrollHeight = $(this)[0].scrollHeight;
        if (height + scrollTop >= scrollHeight - 100 && !fetching) {
            fetching = true;
            const convos = await Notifications.getMessages(page);
            page++;
            for (const c of convos) {
                $(".nav-dropdown").append(c.element);       
                if (!c.viewed && !c.lastMessage.weSentThis) {
                    $(`.nav-dropdown a[data-username="${c.recipient.username}"] .post`).addClass("tint-blue");
                }         
            }
            if (convos.length > 0) fetching = false;
        }

    });


});