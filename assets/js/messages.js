$(document).ready(() => {

    const show = () => $(".nav-dropdown").show();
    const hide = () => $(".nav-dropdown").hide();

    let fetched = false;
    let fetching = false;
    let page = 1;

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
        const innerHeight = $(this).innerHeight();
        if (height - 430 <= scrollTop && !fetching) {
            console.log(scrollTop, height);
            fetching = !true;
            const convos = await Notifications.getMessages(page);
            page++;
            for (const c of convos) {
                $(".nav-dropdown").append(c.element);       
                if (!c.viewed && !c.lastMessage.weSentThis) {
                    $(`.nav-dropdown a[data-username="${c.recipient.username}"] .post`).addClass("tint-blue");
                }         
            }
            fetching = false;
        }

    });


});