$(document).ready(function() {
    $("li[data-tab]").click(function () {
        const tab = $(this).attr("data-tab");
        
        const currentActiveTabLi = $(document).find("li[class~=\"is-active\"]")
        const currentActiveTab = currentActiveTabLi.attr("data-tab");

        currentActiveTabLi.removeClass("is-active");
        $(this).addClass("is-active");

        $(`div[data-tab="${currentActiveTab}"]`).hide();
        $(`div[data-tab="${tab}"]`).show();
        
    });
}); 