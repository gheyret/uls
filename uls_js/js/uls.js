// uls.js
// Uyghur Latin (ul), Arabic (uu), Cyrillic (us) auto transliteration

const map = {
  UL: {
    'ا': 'a', 'ە': 'e', 'ب': 'b', 'پ': 'p', 'ت': 't', 'ج': 'j', 'چ': 'ch', 'خ': 'x', 'د': 'd', 'ر': 'r',
    'ز': 'z', 'ژ': 'zh', 'س': 's', 'ش': 'sh', 'غ': 'gh', 'ف': 'f', 'ق': 'q', 'ك': 'k', 'گ': 'g',
    'ڭ': 'ng', 'ل': 'l', 'م': 'm', 'ن': 'n', 'ھ': 'h', 'و': 'o', 'ۇ': 'u', 'ۆ': 'ö', 'ۈ': 'ü',
    'ۋ': 'w', 'ې': 'é', 'ى': 'i', 'ي': 'y',
  },
  US: {
    'ا': 'а', 'ە': 'ә', 'ب': 'б', 'پ': 'п', 'ت': 'т', 'ج': 'җ', 'چ': 'ч', 'خ': 'х', 'د': 'д', 'ر': 'р',
    'ز': 'з', 'ژ': 'ж', 'س': 'с', 'ش': 'ш', 'غ': 'ғ', 'ف': 'ф', 'ق': 'қ', 'ك': 'к', 'گ': 'г',
    'ڭ': 'ң', 'ل': 'л', 'م': 'м', 'ن': 'н', 'ھ': 'һ', 'و': 'о', 'ۇ': 'у', 'ۆ': 'ө', 'ۈ': 'ү',
    'ۋ': 'в', 'ې': 'е', 'ى': 'и', 'ي': 'й',
  }
};

function convert(text, mapping) {
  let result = '';
  let i = 0;

  while (i < text.length) {
    const ch = text[i];
    const next = i + 1 < text.length ? text[i + 1] : '';
    if (ch === 'ئ') {
      const isNextVowel = 'اەېىوۇۆۈ'.includes(next);
      if (isNextVowel) {
        const isWordStart = result === '' || /[ \n\r\t.,;!?\\/()]/.test(result.slice(-1));
        if (isWordStart) {
          i++;
          continue;
        } else {
          if(mapping === map.UL)
          {
            result += 'ʼ';
          }
          else
          {
            result += 'ъ';
          }
        }
      } else {
          if(mapping === map.UL)
          {
            result += 'ʼ';
          }
          else
          {
            result += 'ъ';
          }
      }
      i++;
      continue;
    }
    if (i + 1 < text.length) {
      const two = text.substr(i, 2);
      if (mapping[two]) {
        result += mapping[two];
        i += 2;
        continue;
      }
    }
    result += mapping[ch] || ch;
    i++;
  }
  return result;
}

function convertAllTextNodes(node, mapping) {
  if (node.nodeType === Node.TEXT_NODE && node.textContent.trim()) {
    node.textContent = convert(node.textContent, mapping);
  } else {
    for (const child of node.childNodes) {
      convertAllTextNodes(child, mapping);
    }
  }
}

function getUserPreference() {
  const params = new URLSearchParams(location.search);
  if (params.has('uls')) {
    const val = params.get('uls');  // ul, uu, us
    localStorage.setItem('uyghur-uls', val);
    return val;
  }
  return localStorage.getItem('uyghur-uls') || 'uu';
}

document.addEventListener('DOMContentLoaded', () => {
  const mode = getUserPreference();  // 'ul', 'uu', 'us'
  if (mode === 'ul') {
    convertAllTextNodes(document.body, map.UL);
    document.documentElement.dir = 'ltr';
    // document.body.style.textAlign = 'left';
    // document.body.style.fontFamily = 'Arial, "Noto Sans", sans-serif';
  } else if (mode === 'us') {
    convertAllTextNodes(document.body, map.US);
    document.documentElement.dir = 'ltr';
    // document.body.style.textAlign = 'left';
    // document.body.style.fontFamily = '"Noto Sans", Arial, sans-serif';
  } else {  // uu (デフォルト)
    document.documentElement.dir = 'rtl';
    // document.body.style.textAlign = 'right';
  }

  // 切り替え案内メッセージ（重複しないように1回だけ表示）
  if (!document.querySelector('.uls-switcher-notice')) {
    const div = document.createElement('div');
    div.className = 'uls-switcher-notice';
    // div.style.cssText = 'background:#f0f8ff;padding:15px;border-radius:8px;margin:20px 0;font-size:18px;text-align:center;';
    div.style.cssText = 'background:#f0f8ff;padding:10px;border-radius:4px;margin:10px 0;font-size:18px;text-align:left;direction:ltr';

    div.innerHTML = `
      <a href="?uls=ul">Uyghurche</a> &nbsp; 
      <a href="?uls=us">Уйғурчә</a>&nbsp; 
      <a href="?uls=uu">ئۇيغۇرچە</a>
    `;
    document.body.insertBefore(div, document.body.firstChild);
  }
});
