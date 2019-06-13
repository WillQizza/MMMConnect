//@ts-check

/**
 * Ok, our plan is to support **bold**, __underscores__, and ~~strikethrough~~.
 */

/** @type {{tag: string, pair: string, style?: string}[]} */
const markdownData = [
    { tag: "b", pair: "**" },
    { tag: "span", pair: "__", style: "text-decoration: underline;" },
    { tag: "span", pair: "~~", style: "text-decoration: line-through;" }
];

// Yes, you can inject html with this. asnduadghbsd0djwefgtfbdsefwrtgyhg

/**
 * Markdownify text.
 * @param {string} text 
 */
const markdownify = text => {
    let soFar = "";
    for (let i = 0; i < text.length; i++) {
        const data = markdownData.find(data => text[i] + text[i + 1] === data.pair);
        if (data) {
            // Where's the next closing tag?
            const closingTag = text.substring(i + 2).indexOf(data.pair);
            if (closingTag !== -1) {
                const message = text.substring(i + 2, closingTag + i + 2);
                soFar += `<${data.tag}${data.style ? ` style="${data.style}"` : ""}>${message}</${data.tag}>`;
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