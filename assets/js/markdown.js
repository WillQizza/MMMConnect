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
    let pair = "";
    for (let i = 0; i < text.length; i++) {
        pair += text[i];
    }
    return soFar;
};