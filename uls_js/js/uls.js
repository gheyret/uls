const U2L_MAP = {
    '\u0626': "'", '\uFE8B': "'", '\uFE8C': "'",
    '\u0627': "a", '\uFE8D': "a", '\uFE8E': "a",
    '\u06D5': "e", '\uFEE9': "e", '\uFEEA': "e",
    '\u0628': "b", '\uFE8F': "b", '\uFE90': "b", '\uFE91': "b", '\uFE92': "b",
    '\u067E': "p", '\uFB56': "p", '\uFB57': "p", '\uFB58': "p", '\uFB59': "p",
    '\u062A': "t", '\uFE95': "t", '\uFE96': "t", '\uFE97': "t", '\uFE98': "t",
    '\u062C': "j", '\uFE9D': "j", '\uFE9E': "j", '\uFE9F': "j", '\uFEA0': "j",
    '\u0686': "ch", '\uFB7A': "ch", '\uFB7B': "ch", '\uFB7C': "ch", '\uFB7D': "ch",
    '\u062E': "x", '\uFEA5': "x", '\uFEA6': "x", '\uFEA7': "x", '\uFEA8': "x",
    '\u062F': "d", '\uFEA9': "d", '\uFEAA': "d",
    '\u0631': "r", '\uFEAD': "r", '\uFEAE': "r",
    '\u0632': "z", '\uFEAF': "z", '\uFEB0': "z",
    '\u0698': "zh", '\uFB8A': "zh", '\uFB8B': "zh",
    '\u0633': "s", '\uFEB1': "s", '\uFEB2': "s", '\uFEB3': "s", '\uFEB4': "s",
    '\u0634': "sh", '\uFEB5': "sh", '\uFEB6': "sh", '\uFEB7': "sh", '\uFEB8': "sh",
    '\u063A': "gh", '\uFECD': "gh", '\uFECE': "gh", '\uFECF': "gh", '\uFED0': "gh",
    '\u0641': "f", '\uFED1': "f", '\uFED2': "f", '\uFED3': "f", '\uFED4': "f",
    '\u0642': "q", '\uFED5': "q", '\uFED6': "q", '\uFED7': "q", '\uFED8': "q",
    '\u0643': "k", '\uFED9': "k", '\uFEDA': "k", '\uFEDB': "k", '\uFEDC': "k",
    '\u06AF': "g", '\uFB92': "g", '\uFB93': "g", '\uFB94': "g", '\uFB95': "g",
    '\u06AD': "ng", '\uFBD3': "ng", '\uFBD4': "ng", '\uFBD5': "ng", '\uFBD6': "ng",
    '\u0644': "l", '\uFEDD': "l", '\uFEDE': "l", '\uFEDF': "l", '\uFEE0': "l",
    '\u0645': "m", '\uFEE1': "m", '\uFEE2': "m", '\uFEE3': "m", '\uFEE4': "m",
    '\u0646': "n", '\uFEE5': "n", '\uFEE6': "n", '\uFEE7': "n", '\uFEE8': "n",
    '\u06BE': "h", '\uFBAA': "h", '\uFBAB': "h", '\uFBAC': "h", '\uFBAD': "h", '\uFEEB': "h", '\uFEEC': "h",
    '\u0648': "o", '\uFEED': "o", '\uFEEE': "o",
    '\u06C7': "u", '\uFBD7': "u", '\uFBD8': "u",
    '\u06C6': "ö", '\uFBD9': "ö", '\uFBDA': "ö",
    '\u06C8': "ü", '\uFBDB': "ü", '\uFBDC': "ü",
    '\u06CB': "w", '\uFBDE': "w", '\uFBDF': "w",
    '\u06D0': "é", '\uFBE4': "é", '\uFBE5': "é", '\uFBE6': "é", '\uFBE7': "é",
    '\u0649': "i", '\uFEEF': "i", '\uFEF0': "i", '\uFBE8': "i", '\uFBE9': "i",
    '\u064A': "y", '\uFEF1': "y", '\uFEF2': "y", '\uFEF3': "y", '\uFEF4': "y",
    '\uFEFB': "la", '\uFEFC': "la",
    '\uFBEA': "a", '\uFBEB': "a",
    '\uFBEC': "e", '\uFBED': "e",
    '\uFBEE': "o", '\uFBEF': "o",
    '\uFBF0': "u", '\uFBF1': "u",
    '\uFBF2': "ö", '\uFBF3': "ö",
    '\uFBF4': "ü", '\uFBF5': "ü",
    '\uFBF6': "é", '\uFBF7': "é", '\uFBF8': "é",
    '\uFBF9': "i", '\uFBFA': "i", '\uFBFB': "i"};

const U2S_MAP = {
    '\u0626': 'ъ', '\uFE8B': 'ъ', '\uFE8C': 'ъ',
    '\u0627': 'а', '\uFE8D': 'а', '\uFE8E': 'а',
    '\u06D5': 'ә', '\uFEE9': 'ә', '\uFEEA': 'ә',
    '\u0628': 'б', '\uFE8F': 'б', '\uFE90': 'б', '\uFE91': 'б', '\uFE92': 'б',
    '\u067E': 'п', '\uFB56': 'п', '\uFB57': 'п', '\uFB58': 'п', '\uFB59': 'п',
    '\u062A': 'т', '\uFE95': 'т', '\uFE96': 'т', '\uFE97': 'т', '\uFE98': 'т',
    '\u062C': 'җ', '\uFE9D': 'җ', '\uFE9E': 'җ', '\uFE9F': 'җ', '\uFEA0': 'җ',
    '\u0686': 'ч', '\uFB7A': 'ч', '\uFB7B': 'ч', '\uFB7C': 'ч', '\uFB7D': 'ч',
    '\u062E': 'х', '\uFEA5': 'х', '\uFEA6': 'х', '\uFEA7': 'х', '\uFEA8': 'х',
    '\u062F': 'д', '\uFEA9': 'д', '\uFEAA': 'д',
    '\u0631': 'р', '\uFEAD': 'р', '\uFEAE': 'р',
    '\u0632': 'з', '\uFEAF': 'з', '\uFEB0': 'з',
    '\u0698': 'ж', '\uFB8A': 'ж', '\uFB8B': 'ж',
    '\u0633': 'с', '\uFEB1': 'с', '\uFEB2': 'с', '\uFEB3': 'с', '\uFEB4': 'с',
    '\u0634': 'ш', '\uFEB5': 'ш', '\uFEB6': 'ш', '\uFEB7': 'ш', '\uFEB8': 'ш',
    '\u063A': 'ғ', '\uFECD': 'ғ', '\uFECE': 'ғ', '\uFECF': 'ғ', '\uFED0': 'ғ',
    '\u0641': 'ф', '\uFED1': 'ф', '\uFED2': 'ф', '\uFED3': 'ф', '\uFED4': 'ф',
    '\u0642': 'қ', '\uFED5': 'қ', '\uFED6': 'қ', '\uFED7': 'қ', '\uFED8': 'қ',
    '\u0643': 'к', '\uFED9': 'к', '\uFEDA': 'к', '\uFEDB': 'к', '\uFEDC': 'к',
    '\u06AF': 'г', '\uFB92': 'г', '\uFB93': 'г', '\uFB94': 'г', '\uFB95': 'г',
    '\u06AD': 'ң', '\uFBD3': 'ң', '\uFBD4': 'ң', '\uFBD5': 'ң', '\uFBD6': 'ң',
    '\u0644': 'л', '\uFEDD': 'л', '\uFEDE': 'л', '\uFEDF': 'л', '\uFEE0': 'л',
    '\u0645': 'м', '\uFEE1': 'м', '\uFEE2': 'м', '\uFEE3': 'м', '\uFEE4': 'м',
    '\u0646': 'н', '\uFEE5': 'н', '\uFEE6': 'н', '\uFEE7': 'н', '\uFEE8': 'н',
    '\u06BE': 'һ', '\uFBAA': 'һ', '\uFBAB': 'һ', '\uFBAC': 'һ', '\uFBAD': 'һ', '\uFEEB': 'һ', '\uFEEC': 'һ',
    '\u0648': 'о', '\uFEED': 'о', '\uFEEE': 'о',
    '\u06C7': 'у', '\uFBD7': 'у', '\uFBD8': 'у',
    '\u06C6': 'ө', '\uFBD9': 'ө', '\uFBDA': 'ө',
    '\u06C8': 'ү', '\uFBDB': 'ү', '\uFBDC': 'ү',
    '\u06CB': 'в', '\uFBDE': 'в', '\uFBDF': 'в',
    '\u06D0': 'е', '\uFBE4': 'е', '\uFBE5': 'е', '\uFBE6': 'е', '\uFBE7': 'е',
    '\u0649': 'и', '\uFEEF': 'и', '\uFEF0': 'и', '\uFBE8': 'и', '\uFBE9': 'и',
    '\u064A': 'й', '\uFEF1': 'й', '\uFEF2': 'й', '\uFEF3': 'й', '\uFEF4': 'й'};

const BELGE_MAP = {'؟': '?','،': ',','؛': ';','٭': '*','“': '«','„': '«','”': '»','‟': '»',};
function U2Belge(ch) {
    return BELGE_MAP[ch] || ch;
}
function U2L(token) {
    const result = [];
    let aldiN = false;
    let aldiz = false;
    let skip = true;
    for (const herp of token) {
        if (['\u0626', '\uFE8B', '\uFE8C'].includes(herp)) {
            aldiN = false;
            aldiz = false;
            if (!skip) {
                result.push("’");
            }
            continue;
        } else if (['\u0632', '\uFEAF', '\uFEB0'].includes(herp)) {
            aldiN = false;
            aldiz = true;
            skip = false;
            result.push("z");
        } else if (['\u06BE', '\uFBAA', '\uFBAB', '\uFBAC', '\uFBAD', '\uFEEB', '\uFEEC'].includes(herp)) {
            result.push(aldiz ? "’h" : "h");
            aldiN = false;
            aldiz = false;
            skip = false;
        } else if (['\u063A', '\uFECD', '\uFECE', '\uFECF', '\uFED0'].includes(herp)) {
            result.push(aldiN ? "’gh" : "gh");
            aldiN = false;
            aldiz = false;
            skip = false;
        } else if (['\u06AF', '\uFB92', '\uFB93', '\uFB94', '\uFB95'].includes(herp)) {
            result.push(aldiN ? "’g" : "g");
            aldiN = false;
            aldiz = false;
            skip = false;
        } else if (['\u0646', '\uFEE5', '\uFEE6', '\uFEE7', '\uFEE8'].includes(herp)) {
            result.push("n");
            aldiN = true;
            aldiz = false;
            skip = false;
        } else {
            aldiN = false;
            aldiz = false;
            const mapped = U2L_MAP[herp];
            if (mapped !== undefined) {
                result.push(mapped);
                skip = false;
            } else {
                const belge = U2Belge(herp);
                result.push(belge);
                skip = true;
            }
        }
    }
    return result.join("");
}
function U2S(token) {
    const result = [];
    let skip = true;
    for (const herp of token) {
        if (['\u0626', '\uFE8B', '\uFE8C'].includes(herp)) {
            if (!skip) {
                result.push('ъ');
            }
            continue;
        }
        const mapped = U2S_MAP[herp];
        if (mapped !== undefined) {
            result.push(mapped);
            skip = false;
        } else {
            const belge = U2Belge(herp);
            result.push(belge);
            skip = true;
        }
    }
    return result.join("");
}
function convert(text, mode) {
    if (mode === 'ul') {
        return U2L(text);
    } else if (mode === 'us') {
        return U2S(text);
    } else {
        return text;
    }
}
function convertAllTextNodes(node, mode) {
    if (node.nodeType === Node.TEXT_NODE && node.textContent.trim()) {
        node.textContent = convert(node.textContent, mode);
    } else {
        for (const child of node.childNodes) {
            convertAllTextNodes(child, mode);
        }
    }
}
function getUserPreference() {
    const params = new URLSearchParams(location.search);
    if (params.has('uls')) {
        const val = params.get('uls');
        localStorage.setItem('uyghur-uls', val);
        return val;
    }
    return localStorage.getItem('uyghur-uls') || 'uu';
}
document.addEventListener('DOMContentLoaded', () => {
    const mode = getUserPreference();
    if (mode === 'ul') {
        document.documentElement.dir = 'ltr';
    } else if (mode === 'us') {
        document.documentElement.dir = 'ltr';
    } else {
        document.documentElement.dir = 'rtl';
    }
    convertAllTextNodes(document.body, mode);
    if (!document.querySelector('.uls-switcher-notice')) {
        const div = document.createElement('div');
        div.className = 'uls-switcher-notice';
        div.style.cssText = 'background:#f0f8ff;padding:10px;border-radius:4px;margin:10px 0;font-size:18px;text-align:left;direction:ltr';
        div.innerHTML = `
            <a href="?uls=ul">Uyghurche</a>     
            <a href="?uls=us">Уйғурчә</a>     
            <a href="?uls=uu">ئۇيغۇرچە</a>
        `;
        document.body.insertBefore(div, document.body.firstChild);
    }
});
