$(document).ready(() => {

    const show = () => $(".nav-dropdown").show();
    const hide = () => $(".nav-dropdown").hide();

    let fetchedMessages = {
        status: false,
        data: [],
        page: 1,
        fetching: false
    };

    let fetchedNotifications = {
        status: false,
        data: [],
        page: 1,
        fetching: false
    };

    let activeDropdown = "";

    $(".dropdown[data-notification=\"messages\"]").mouseenter(async () => {
        activeDropdown = "messages";
        show();
        $(".nav-dropdown").empty();
        if (!fetchedMessages.status) {
            fetchedMessages.status = true;
            const data = await Notifications.getMessages();
            fetchedMessages.data = data.convos;
            $("div[data-notification=\"messages\"]").text(data.unread > 0 ? data.unread : "");
        }
        if (activeDropdown === "messages") {
            for (const c of fetchedMessages.data) {
                c.element = $($(".nav-dropdown").append(c.element)[0]).children().last(); // Wackity hack hack.
                if (!c.viewed && !c.lastMessage.weSentThis) {
                    $(`.nav-dropdown a[data-username="${c.recipient.username}"] .post`).addClass("tint-blue");
                }
            }
        }
    });

    $(".dropdown[data-notification=\"notifications\"]").mouseenter(async () => {
        activeDropdown = "notifications";
        show();
        $(".nav-dropdown").empty();
        if (!fetchedNotifications.status) {
            fetchedNotifications.status = true;
            const data = await Notifications.getNotifications();
            fetchedNotifications.data = data.notifications;
            $("div[data-notification=\"notifications\"]").text(data.unread > 0 ? data.unread : "");
        }
        if (activeDropdown === "notifications") {
            for (const n of fetchedNotifications.data) {
                n.element = $($(".nav-dropdown").append(n.element)[0]).children().last(); // Wackity hack hack.
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
        if (height + scrollTop >= scrollHeight - 100) {
            if (activeDropdown === "messages" && !fetchedMessages.fetching) {
                fetchedMessages.fetching = true;
                const data = await Notifications.getMessages(fetchedMessages.page);
                fetchedMessages.data = fetchedMessages.data.concat(data.convos);
                $("div[data-notification=\"messages\"]").text(data.unread > 0 ? data.unread : "");
                fetchedMessages.page++;
                if (activeDropdown === "messages") {
                    for (const c of data.convos) {
                        c.element = $($(".nav-dropdown").append(c.element)[0]).children().last(); // Wackity hack hack.     
                        if (!c.viewed && !c.lastMessage.weSentThis) {
                            $(`.nav-dropdown a[data-username="${c.recipient.username}"] .post`).addClass("tint-blue");
                        }         
                    }
                    if (data.convos.length > 0) fetchedMessages.fetching = false;
                }
                fetchedMessages.fetching = false;
            } else if (activeDropdown === "notifications" && !fetchedNotifications.fetching) {
                fetchedNotifications.fetching = true;
                const data = await Notifications.getNotifications(fetchedNotifications.page);
                fetchedNotifications.data = fetchedNotifications.data.concat(data.notifications);
                $("div[data-notification=\"notifications\"]").text(data.unread > 0 ? data.unread : "");
                fetchedNotifications.page++;
                if (activeDropdown === "notifications") {
                    for (const n of data.notifications) {
                        n.element = $($(".nav-dropdown").append(n.element)[0]).children().last(); // Wackity hack hack.
                    }
                }
                fetchedNotifications.fetching = false;
            }
        }

    });






    // Search
    $(".search input").focus(function () {
        if (window.matchMedia("(min-width: 800px)").matches) {
            $(this).animate({ width: "300px", "height": "40%" }, 500);
        }
        $(".search-dropdown").show();
        $(".search-dropdown .results").empty();
        const query = $(".search input").val();
        $.ajax({
            method: "POST",
            url: `${ROOT}search`,
            dataType: "json",
            data: {
                query
            },
            success: results => {
                $(".search-dropdown .results").html(results.content);
            }
        });
    });

    $(".search input").focusout(function () {
        if (!$(".search-dropdown a:focus")[0]) {
            if (window.matchMedia("(min-width: 800px)").matches) {
                $(this).animate({ width: "250px" }, 500);
                $(".search-dropdown").animate({ width: "93%" }, 500);
            }
            setTimeout(() => $(".search-dropdown").hide(), 100)
        }
    });

    $(".search input").keyup(function () {
        const query = $(this).val();
        $.ajax({
            method: "POST",
            url: `${ROOT}search`,
            dataType: "json",
            data: {
                query
            },
            success: results => {
                $(".search-dropdown .results").html(results.content);
            }
        });
    });

    $(".search .fas, .search .moreResults").click(() => $(".search").submit());


});