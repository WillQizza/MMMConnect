$(document).ready(function () {
    const ONE_MINUTE = 60000;
    const ONE_HOUR = ONE_MINUTE * 60;
    const ONE_DAY = ONE_HOUR * 24;
    const ONE_MONTH = ONE_DAY * 31; // Not entirely sure if this is accurate enough.
    const ONE_YEAR = ONE_DAY * 12;

    const SECONDS_BEFORE_CHANGE = 5;


    setInterval(function () {
        const posts = $("article[data-timestamp]");
        posts.each((_,post) => {
            const timestamp = post.getAttribute("data-timestamp");
            const timestampElement = post.querySelector(".faded");
            
            // Convert our time to server's time if not already.

            const now = new Date();
            const utc = now.getTime() + now.getTimezoneOffset() * 60000;
            const serverTime = new Date(utc + (3600000 * -6));
            const diff = serverTime.getTime() - timestamp;
            if (diff > ONE_YEAR) {
                const years = Math.floor(diff / ONE_YEAR);
                timestampElement.textContent = `${years} year${years > 1 ? "s" : ""} ago`;
            } else if (diff > ONE_MONTH) {
                const months = Math.floor(diff / ONE_MONTH);
                const days = Math.floor((diff - months * ONE_MONTH) / ONE_DAY);
                timestampElement.textContent = `${months} month${months > 1 ? "s" : ""} ago ${days !== 0 ? `& ${days} day${days > 1 ? "s" : ""} ago` : ""}`;
            } else if (diff > ONE_DAY) {
                const days = Math.floor(diff / ONE_DAY);
                if (days === 1) {
                    timestampElement.textContent = "Yesterday";
                } else {
                    timestampElement.textContent = `${days} day${days > 1 ? "s" : ""} ago`;
                }
            } else if (diff > ONE_HOUR) {
                const hours = Math.floor(diff / ONE_HOUR);
                timestampElement.textContent = `${hours} hour${hours > 1 ? "s" : ""} ago`;
            } else if (diff > ONE_MINUTE) {
                const minutes = Math.floor(diff / ONE_MINUTE);
                timestampElement.textContent = `${minutes} minute${minutes > 1 ? "s" : ""} ago`;
            } else {
                const seconds = Math.floor(diff / 1000);
                if (seconds > SECONDS_BEFORE_CHANGE) {
                    timestampElement.textContent = `${seconds} seconds ago`;
                } else {
                    timestampElement.textContent = "Just now";
                }
            }
            
        });
    }, 1000);
});