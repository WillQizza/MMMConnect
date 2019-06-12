//@ts-check

/**
 * Ok, our plan is to support **bold**, __underscores__, and ~~strikethrough~~.
 */

/**
 * Markdownify text.
 * @param {string} text 
 */
const markdownify = text => {
    let soFar = "";
    for (let i = 0; i < text.length; i++) {
        if (text[i] === "*" && text[i + 1] === "*") {
            // Where's the next closing tag?
            const closingTag = text.substring(i + 2).indexOf("**");
            if (closingTag !== -1) {
                const message = text.substring(i + 2, closingTag + i + 2);
                soFar += `<b>${message}</b>`;
                text = text.substring(0, i) + message + text.substring(closingTag + i + 4);
                i += message.length - 1;
            } else {
                soFar += text.substring(i, i + 2);
                i++;
            }
        } else {
            soFar += text[i];
        }
    }
    return soFar;
};