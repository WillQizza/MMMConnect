//@ts-check

/**
 * Create a template.
 * @param {string} name 
 * @param {{selector: string, attributes?: {[attr : string]: any}, value?: any, text?: any}[]} data 
 */
const createTemplate = (name, data) => {
    /** @type {HTMLTemplateElement} */
    const template = document.querySelector(`template[data-name="${name}"]`);
    const clone = document.importNode(template.content, true);
    for (const query of data) {
        const qs = Array.from(clone.querySelectorAll(query.selector));
        for (const q of qs) {
            for (const attr in query.attributes) {
                q.setAttribute(attr, query.attributes[attr]);
            } 
            if (query.value != null) {
                q.setAttribute("value", query.value);
            }
            if (query.text != null) {
                q.textContent = query.text;
                q.innerHTML = markdownify(q.textContent);
            }
        }
    }
    return clone;
};