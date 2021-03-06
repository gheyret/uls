<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
mb_internal_encoding("UTF-8");
$has = file('hasisim.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$hasisimL = array();
$hasisimS = array();
$hasisim = array();

foreach ($has as $isim) {
    $isim = rtrim($isim);
    array_push($hasisim, $isim);
    array_push($hasisimL, ChongYaz(U2LToken($isim)));
    array_push($hasisimS, ChongYaz(U2SToken($isim)));
}

function baghla() {
    if (isset($_GET['uls']) == true) {
        if ($_GET['uls'] == 'ul') {
            $_SESSION['uls'] = "ul";
        } else if ($_GET['uls'] == 'us') {
            $_SESSION['uls'] = "us";
        } else if ($_GET['uls'] == 'lu') {
            $_SESSION['uls'] = "lu";
        } else if ($_GET['uls'] == 'ls') {
            $_SESSION['uls'] = "ls";
        } else if ($_GET['uls'] == 'uu') {
            $_SESSION['uls'] = "uu";
        } else if ($_GET['uls'] == 'ut') {
            $_SESSION['uls'] = "ut";
        } else if ($_GET['uls'] == 'tu') {
            $_SESSION['uls'] = "tu";
        } else if ($_GET['uls'] == 'sl') {
            $_SESSION['uls'] = "sl";
        }
        else {
            $_SESSION['uls'] = "ee";  /* Esli Yeziiq*/
        }        
    } 
}

function ayladur($out) {
    if ($_SESSION['uls'] == "ul") {
        $out = U2L($out);
        $out = str_replace("style.css", "style-ltr.css", $out);
    } else if ($_SESSION['uls'] == "us") {
        $out = U2S($out);
        $out = str_replace("style.css", "style-ltr.css", $out);
    } else if ($_SESSION['uls'] == "ut") {
        $out = U2T($out);
        $out = str_replace("style.css", "style-ltr.css", $out);
    } else if ($_SESSION['uls'] == "sl") {
        $out = S2L($out);
    }
    return $out;
}

function ChongYaz($str) {
    $up = true;
    $upper = '';
    $size = mb_strlen($str);
    $pos = 0;
    while ($pos < $size) {
        $Herp = mb_substr($str, $pos, 1);
        $pos++;
        if ($up == true) {
            $Herp = mb_strtoupper($Herp);
            $up = false;
        }
        $upper = $upper . $Herp;
        if ($Herp == ' ') {
            $up = true;
        }
    }
    return $upper;
}

function Hasisimlar($kona, $latin) {
    $index = 0;
    global $hasisim, $hasisimL, $hasisimS;
    for ($index = 0; $index < sizeof($hasisim); $index++) {
        if ($latin == true) {
            $kona = mb_str_replace($hasisim[$index], $hasisimL[$index], $kona);
        } else {
            $kona = mb_str_replace($hasisim[$index], $hasisimS[$index], $kona);
        }
    }
    return $kona;
}

function mb_str_replace($needle, $replacement, $haystack) {
    $needle_len = mb_strlen($needle);
    $replacement_len = mb_strlen($replacement);
    $pos = mb_strpos($haystack, $needle);
    while ($pos !== false) {
        $haystack = mb_substr($haystack, 0, $pos) . $replacement . mb_substr($haystack, $pos + $needle_len);
        $pos = mb_strpos($haystack, $needle, $pos + $replacement_len);
    }
    return $haystack;
}

function startsWith(&$cont, $str, $pp) {
    $ret = false;
    if (mb_strpos($cont, $str, $pp) == $pp) {
        $ret = true;
    }
    return $ret;
}

function U2L(&$contents) {
    global $hasisim, $hasisimL;
    $stopChange = 0;
    $token = '';
    $unicode = '';
    $len = 0;
    $pos = 0;
    $endPos = 0;
    $contents = HasIsimlar($contents, true);
    $size = mb_strlen($contents);
    $Herp = mb_substr($contents, $pos, 1);
    while ($pos < $size) {
        if ($Herp == '<') {
            if (startsWith($contents, '<script', $pos) == true) {
                $endPos = mb_strpos($contents, '/script>', $pos + 7);
                if ($endPos !== FALSE) {
                    $endPos+=8;
                    $len = $endPos - $pos;
                    $token = mb_substr($contents, $pos, $len);
                    $unicode = $unicode . $token;
                    $pos = $endPos;
                    $Herp = mb_substr($contents, $pos, 1);
                    continue;
                }
            }
            $stopChange++;
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
            continue;
        } else if ($Herp == '>') {
            $stopChange--;
            if ($stopChange < 0)
                $stopChange = 0;
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
            $stopChange = 0;
            continue;
        }

        if ($stopChange !== 0) {
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
            continue;
        }
        if (IsU($Herp) == true || $Herp == '&') {
            $token = '';
            if (IsU($Herp) == true) {
                while (IsU($Herp) == true) {
                    $token = $token . $Herp;
                    $pos++;
                    $Herp = mb_substr($contents, $pos, 1);
                }
            } else {
                while ($Herp != ';' && $Herp != '<' && $Herp != '>' && $Herp != ' ' && $Herp != '\n' && $Herp != '\r') {
                    if ($Herp >= ' ' && $Herp <= '~') {
                        $token = $token . $Herp;
                        $pos++;
                        $Herp = mb_substr($contents, $pos, 1);
                    } else {
                        break;
                    }
                }
                if ($Herp == ';') {
                    $token.=$Herp;
                    $pos++;
                }
            }
            $len = mb_strlen($token);
            if ($len > 0) {
                if (IsConstanToken($token) == true) {
                    $token = U2LSBelge($token);
                    $unicode = $unicode . $token;
                } else {
                    $unicode = $unicode . U2LToken($token);
                }
                $Herp = mb_substr($contents, $pos, 1);
            }
        } else {
            $Herp = U2LSBelge($Herp);
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
        }
    }
    return $unicode;
}

function IsU($Herp) {
    $ret = false;
    switch ($Herp) {
        case 'ئ':
        case 'ا':
        case 'ە':
        case 'ب':
        case 'پ':
        case 'ت':
        case 'ج':
        case 'چ':
        case 'خ':
        case 'د':
        case 'ر':
        case 'ز':
        case 'ژ':
        case 'س':
        case 'ش':
        case 'غ':
        case 'ف':
        case 'ق':
        case 'ك':
        case 'گ':
        case 'ڭ':
        case 'ل':
        case 'لا':
        case 'م':
        case 'ن':
        case 'ھ':
        case 'و':
        case 'ۇ':
        case 'ۆ':
        case 'ۈ':
        case 'ۋ':
        case 'ې':
        case 'ى':
        case 'ي':
            $ret = true;
            break;
        default:
            $ret = false;
            break;
    }
    return $ret;
}

function IsConstanToken(&$token) {
    $ret = false;
    $size = mb_strlen($token);
    if ($token[0] == '&' && $token[$size - 1] == ';') {
        $ret = true;
    }
    return $ret;
}

function U2LToken(&$token) {
    $aldiN = false;
    $skip = true;
    $uly = '';
    $pos = 0;
    $size = mb_strlen($token);
    $Herp = mb_substr($token, $pos, 1);
    while ($pos <= $size) {
        $Herp = mb_substr($token, $pos, 1);
        $pos++;
        switch ($Herp) {
            case 'ئ':
                $aldiN = false;
                if ($skip == true) {
                    $Herp = '';
                } else {
                    $Herp = '’';
                }
                break;
            case 'ا':
                $aldiN = false;
                $skip = false;
                $Herp = 'a';
                break;
            case 'ە':
                $aldiN = false;
                $skip = false;
                $Herp = 'e';
                break;
            case 'ب':
                $aldiN = false;
                $skip = false;
                $Herp = 'b';
                break;
            case 'پ':
                $aldiN = false;
                $skip = false;
                $Herp = 'p';
                break;
            case 'ت':
                $aldiN = false;
                $skip = false;
                $Herp = 't';
                break;
            case 'ج':
                $aldiN = false;
                $skip = false;
                $Herp = 'j';
                break;
            case 'چ':
                $aldiN = false;
                $skip = false;
                $Herp = 'ch';
                break;
            case 'خ':
                $aldiN = false;
                $skip = false;
                $Herp = 'x';
                break;
            case 'د':
                $aldiN = false;
                $skip = false;
                $Herp = 'd';
                break;
            case 'ر':
                $aldiN = false;
                $skip = false;
                $Herp = 'r';
                break;
            case 'ز':
                $aldiN = false;
                $skip = false;
                $Herp = 'z';
                break;
            case 'ژ':
                $aldiN = false;
                $skip = false;
                $Herp = 'zh';
                break;
            case 'س':
                $aldiN = false;
                $skip = false;
                $Herp = 's';
                break;
            case 'ش':
                $aldiN = false;
                $skip = false;
                $Herp = 'sh';
                break;
            case 'غ':
                $skip = false;
                if ($aldiN == true) {
                    $Herp = '’gh';
                } else {
                    $Herp = 'gh';
                }
                $aldiN = false;
                break;
            case 'ف':
                $Herp = 'f';
                $skip = false;
                $aldiN = false;
                break;
            case 'ق':
                $Herp = 'q';
                $skip = false;
                break;
            case 'ك':
                $Herp = 'k';
                $skip = false;
                break;
            case 'گ':
                if ($aldiN == true) {
                    $Herp = '’g';
                } else {
                    $Herp = 'g';
                }
                $skip = false;
                $aldiN = false;
                break;
            case 'ڭ':
                $Herp = 'ng';
                $skip = false;
                $aldiN = false;
                break;
            case 'ل':
                $Herp = 'l';
                $skip = false;
                $aldiN = false;
                break;
            case 'لا':
                $Herp = 'la';
                $skip = false;
                $aldiN = false;
                break;
            case 'م':
                $Herp = 'm';
                $skip = false;
                $aldiN = false;
                break;
            case 'ن':
                $Herp = 'n';
                $skip = false;
                $aldiN = true;
                break;
            case 'ھ':
                $Herp = 'h';
                $skip = false;
                $aldiN = false;
                break;
            case 'و':
                $Herp = 'o';
                $skip = false;
                $aldiN = false;
                break;
            case 'ۇ':
                $Herp = 'u';
                $skip = false;
                $aldiN = false;
                break;
            case 'ۆ':
                $Herp = 'ö';
                $skip = false;
                $aldiN = false;
                break;
            case 'ۈ':
                $Herp = 'ü';
                $skip = false;
                $aldiN = false;
                break;
            case 'ۋ':
                $Herp = 'w';
                $skip = false;
                $aldiN = false;
                break;
            case 'ې':
                $Herp = 'é';
                $skip = false;
                $aldiN = false;
                break;
            case 'ى':
                $Herp = 'i';
                $skip = false;
                $aldiN = false;
                break;
            case 'ي':
                $Herp = 'y';
                $skip = false;
                $aldiN = false;
                break;
            default:
                $skip = true;
                $Herp = U2LSBelge($Herp);
                $aldiN = false;
                break;
        }
        $uly = $uly . $Herp;
    }
    return $uly;
}

function U2LSBelge($Herp) {
    $ret = $Herp;
    switch ($Herp) {
        case '؟':
            $ret = '?';
            break;
        case '،':
            $ret = ',';
            break;
        case '؛':
            $ret = ';';
            break;
        case '٭':
            $ret = '*';
            break;
        case '“':
        case '„':
        case '&#8220;':
        case '&#8222;':
            $ret = '«';
            break;
        case '”':
        case '‟':
        case '&#8221;':
        case '&#8223;':
            $ret = '»';
            break;
        default:
            $ret = $Herp;
            break;
    }
    return $ret;
}

function U2S(&$contents) {
    $stopChange = 0;
    $token = 0;
    $unicode = '';
    $len = 0;
    $pos = 0;
    $endPos = 0;
    $contents = HasIsimlar($contents, false);
    $size = mb_strlen($contents);
    $Herp = mb_substr($contents, $pos, 1);
    while ($pos < $size) {
        if ($Herp == '<') {
            if (startsWith($contents, '<script', $pos) == true) {
                $endPos = mb_strpos($contents, '/script>', $pos + 7);
                if ($endPos !== FALSE) {
                    $endPos+=8;
                    $len = $endPos - $pos;
                    $token = mb_substr($contents, $pos, $len);
                    $unicode = $unicode . $token;
                    $pos = $endPos;
                    $Herp = mb_substr($contents, $pos, 1);
                    continue;
                }
            }
            $stopChange++;
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
            continue;
        } else if ($Herp == '>') {
            $stopChange--;
            if ($stopChange < 0)
                $stopChange = 0;
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
            $stopChange = 0;
            continue;
        }

        if ($stopChange !== 0) {
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
            continue;
        }

        if (IsU($Herp) == true || $Herp == '&') {
            $token = '';
            if (IsU($Herp) == true) {
                while (IsU($Herp) == true) {
                    $token = $token . $Herp;
                    $pos++;
                    $Herp = mb_substr($contents, $pos, 1);
                }
            } else {
                while ($Herp != ';' && $Herp != '<' && $Herp != '>' && $Herp != ' ' && $Herp != '\n' && $Herp != '\r') {
                    if ($Herp >= ' ' && $Herp <= '~') {
                        $token = $token . $Herp;
                        $pos++;
                        $Herp = mb_substr($contents, $pos, 1);
                    } else {
                        break;
                    }
                }
                if ($Herp == ';') {
                    $token.=$Herp;
                    $pos++;
                }
            }
            $len = mb_strlen($token);
            if ($len > 0) {
                if (IsConstanToken($token) == true) {
                    $token = U2LSBelge($token);
                    $unicode = $unicode . $token;
                } else {
                    $unicode = $unicode . U2SToken($token);
                }
                $Herp = mb_substr($contents, $pos, 1);
            }
        } else {
            $Herp = U2LSBelge($Herp);
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
        }
    }
    return $unicode;
}

function U2SToken(&$token) {
    $usy = '';
    $pos = 0;
    $size = mb_strlen($token);
    $Herp = mb_substr($token, $pos, 1);
    if ($Herp == 'ئ') {
        $pos++;
    }
    while ($pos <= $size) {
        $Herp = mb_substr($token, $pos, 1);
        $pos++;
        switch ($Herp) {
            case 'ئ':
                $Herp = 'ъ';
                break;
            case 'ا':
                $Herp = 'а';
                break;
            case 'ە':
                $Herp = 'ә';
                break;
            case 'ب':
                $Herp = 'б';
                break;
            case 'پ':
                $Herp = 'п';
                break;
            case 'ت':
                $Herp = 'т';
                break;
            case 'ج':
                $Herp = 'җ';
                break;
            case 'چ':
                $Herp = 'ч';
                break;
            case 'خ':
                $Herp = 'х';
                break;
            case 'د':
                $Herp = 'д';
                break;
            case 'ر':
                $Herp = 'р';
                break;
            case 'ز':
                $Herp = 'з';
                break;
            case 'ژ':
                $Herp = 'ж';
                break;
            case 'س':
                $Herp = 'с';
                break;
            case 'ش':
                $Herp = 'ш';
                break;
            case 'غ':
                $Herp = 'ғ';
                break;
            case 'ف':
                $Herp = 'ф';
                break;
            case 'ق':
                $Herp = 'қ';
                break;
            case 'ك':
                $Herp = 'к';
                break;
            case 'گ':
                $Herp = 'г';
                break;
            case 'ڭ':
                $Herp = 'ң';
                break;
            case 'ل':
                $Herp = 'л';
                break;
            case 'لا':
                $Herp = 'ла';
                break;
            case 'م':
                $Herp = 'м';
                break;
            case 'ن':
                $Herp = 'н';
                break;
            case 'ھ':
                $Herp = 'һ';
                break;
            case 'و':
                $Herp = 'о';
                break;
            case 'ۇ':
                $Herp = 'у';
                break;
            case 'ۆ':
                $Herp = 'ө';
                break;
            case 'ۈ':
                $Herp = 'ү';
                break;
            case 'ۋ':
                $Herp = 'в';
                break;
            case 'ې':
                $Herp = 'е';
                break;
            case 'ى':
                $Herp = 'и';
                break;
            case 'ي':
                $Herp = 'й';
/*                if ($pos <= $size) {
                    $Herp = mb_substr($token, $pos, 1);
                    if ($Herp == 'ا') {
                        $Herp = 'я';
                        $pos++;
                    } else if ($Herp == 'ۇ') {
                        $Herp = 'ю';
                        $pos++;
                    } else {
                        $Herp = 'й';
                    }
                }*/
                break;
            default:
                $Herp = U2LSBelge($Herp);
                $aldiN = false;
                break;
        }
        $usy = $usy . $Herp;
    }
    return $usy;
}

function U2T(&$contents) {
    global $hasisim, $hasisimL;
    $stopChange = 0;
    $token = '';
    $unicode = '';
    $len = 0;
    $pos = 0;
    $endPos = 0;
    $contents = HasIsimlar($contents, true);
    $size = mb_strlen($contents);
    $Herp = mb_substr($contents, $pos, 1);
    while ($pos < $size) {
        if ($Herp == '<') {
            if (startsWith($contents, '<script', $pos) == true) {
                $endPos = mb_strpos($contents, '/script>', $pos + 7);
                if ($endPos !== FALSE) {
                    $endPos+=8;
                    $len = $endPos - $pos;
                    $token = mb_substr($contents, $pos, $len);
                    $unicode = $unicode . $token;
                    $pos = $endPos;
                    $Herp = mb_substr($contents, $pos, 1);
                    continue;
                }
            }
            $stopChange++;
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
            continue;
        } else if ($Herp == '>') {
            $stopChange--;
            if ($stopChange < 0)
                $stopChange = 0;
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
            $stopChange = 0;
            continue;
        }

        if ($stopChange !== 0) {
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
            continue;
        }
        if (IsU($Herp) == true || $Herp == '&') {
            $token = '';
            if (IsU($Herp) == true) {
                while (IsU($Herp) == true) {
                    $token = $token . $Herp;
                    $pos++;
                    $Herp = mb_substr($contents, $pos, 1);
                }
            } else {
                while ($Herp != ';' && $Herp != '<' && $Herp != '>' && $Herp != ' ' && $Herp != '\n' && $Herp != '\r') {
                    if ($Herp >= ' ' && $Herp <= '~') {
                        $token = $token . $Herp;
                        $pos++;
                        $Herp = mb_substr($contents, $pos, 1);
                    } else {
                        break;
                    }
                }
                if ($Herp == ';') {
                    $token.=$Herp;
                    $pos++;
                }
            }
            $len = mb_strlen($token);
            if ($len > 0) {
                if (IsConstanToken($token) == true) {
                    $token = U2LSBelge($token);
                    $unicode = $unicode . $token;
                } else {
                    $unicode = $unicode . U2OTToken($token);
                }
                $Herp = mb_substr($contents, $pos, 1);
            }
        } else {
            $Herp = U2LSBelge($Herp);
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
        }
    }
    return $unicode;
}

function U2OTToken(&$token) {
    $aldiN = false;
    $skip = true;
    $uly = '';
    $pos = 0;
    $size = mb_strlen($token);
    $Herp = mb_substr($token, $pos, 1);
    while ($pos <= $size) {
        $Herp = mb_substr($token, $pos, 1);
        $pos++;
        switch ($Herp) {
            case 'ئ':
                $aldiN = false;
                if ($skip == true) {
                    $Herp = '';
                } else {
                    $Herp = '’';
                }
                break;
            case 'ا':
                $aldiN = false;
                $skip = false;
                $Herp = 'a';
                break;
            case 'ە':
                $aldiN = false;
                $skip = false;
                $Herp = 'e';
                break;
            case 'ب':
                $aldiN = false;
                $skip = false;
                $Herp = 'b';
                break;
            case 'پ':
                $aldiN = false;
                $skip = false;
                $Herp = 'p';
                break;
            case 'ت':
                $aldiN = false;
                $skip = false;
                $Herp = 't';
                break;
            case 'ج':
                $aldiN = false;
                $skip = false;
                $Herp = 'c';
                break;
            case 'چ':
                $aldiN = false;
                $skip = false;
                $Herp = 'ç';
                break;
            case 'خ':
                $aldiN = false;
                $skip = false;
                $Herp = 'x';
                break;
            case 'د':
                $aldiN = false;
                $skip = false;
                $Herp = 'd';
                break;
            case 'ر':
                $aldiN = false;
                $skip = false;
                $Herp = 'r';
                break;
            case 'ز':
                $aldiN = false;
                $skip = false;
                $Herp = 'z';
                break;
            case 'ژ':
                $aldiN = false;
                $skip = false;
                $Herp = 'j';
                break;
            case 'س':
                $aldiN = false;
                $skip = false;
                $Herp = 's';
                break;
            case 'ش':
                $aldiN = false;
                $skip = false;
                $Herp = 'ş';
                break;
            case 'غ':
                $skip = false;
                if ($aldiN == true) {
                    $Herp = '’ğ';
                } else {
                    $Herp = 'ğ';
                }
                $aldiN = false;
                break;
            case 'ف':
                $Herp = 'f';
                $skip = false;
                $aldiN = false;
                break;
            case 'ق':
                $Herp = 'q';
                $skip = false;
                break;
            case 'ك':
                $Herp = 'k';
                $skip = false;
                break;
            case 'گ':
                if ($aldiN == true) {
                    $Herp = '’g';
                } else {
                    $Herp = 'g';
                }
                $skip = false;
                $aldiN = false;
                break;
            case 'ڭ':
                $Herp = 'ñ';
                $skip = false;
                $aldiN = false;
                break;
            case 'ل':
                $Herp = 'l';
                $skip = false;
                $aldiN = false;
                break;
            case 'لا':
                $Herp = 'la';
                $skip = false;
                $aldiN = false;
                break;
            case 'م':
                $Herp = 'm';
                $skip = false;
                $aldiN = false;
                break;
            case 'ن':
                $Herp = 'n';
                $skip = false;
                $aldiN = true;
                break;
            case 'ھ':
                $Herp = 'h';
                $skip = false;
                $aldiN = false;
                break;
            case 'و':
                $Herp = 'o';
                $skip = false;
                $aldiN = false;
                break;
            case 'ۇ':
                $Herp = 'u';
                $skip = false;
                $aldiN = false;
                break;
            case 'ۆ':
                $Herp = 'ö';
                $skip = false;
                $aldiN = false;
                break;
            case 'ۈ':
                $Herp = 'ü';
                $skip = false;
                $aldiN = false;
                break;
            case 'ۋ':
                $Herp = 'v';
                $skip = false;
                $aldiN = false;
                break;
            case 'ې':
                $Herp = 'é';
                $skip = false;
                $aldiN = false;
                break;
            case 'ى':
                $Herp = 'i';
                $skip = false;
                $aldiN = false;
                break;
            case 'ي':
                $Herp = 'y';
                $skip = false;
                $aldiN = false;
                break;
            default:
                $skip = true;
                $Herp = U2LSBelge($Herp);
                $aldiN = false;
                break;
        }
        $uly = $uly . $Herp;
    }
    return $uly;
}

function S2L(&$contents) {
    $stopChange = 0;
    $token = '';
    $unicode = '';
    $len = 0;
    $pos = 0;
    $endPos = 0;
    $size = mb_strlen($contents);
    $Herp = mb_substr($contents, $pos, 1);
    while ($pos < $size) {
        if ($Herp == '<') {
            if (startsWith($contents, '<script', $pos) == true) {
                $endPos = mb_strpos($contents, '/script>', $pos + 7);
                if ($endPos !== FALSE) {
                    $endPos+=8;
                    $len = $endPos - $pos;
                    $token = mb_substr($contents, $pos, $len);
                    $unicode = $unicode . $token;
                    $pos = $endPos;
                    $Herp = mb_substr($contents, $pos, 1);
                    continue;
                }
            } else if (startsWith($contents, '<style', $pos) == true) {
                $endPos = mb_strpos($contents, '/style>', $pos + 6);
                if ($endPos !== FALSE) {
                    $endPos+=7;
                    $len = $endPos - $pos;
                    $token = mb_substr($contents, $pos, $len);
                    $unicode = $unicode . $token;
                    $pos = $endPos;
                    $Herp = mb_substr($contents, $pos, 1);
                    continue;
                }
            }
            $stopChange++;
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
            continue;
        } else if ($Herp == '>') {
            $stopChange--;
            if ($stopChange < 0)
                $stopChange = 0;
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
            $stopChange = 0;
            continue;
        }

        if ($stopChange !== 0) {
            $unicode = $unicode . $Herp;
            $pos++;
            $Herp = mb_substr($contents, $pos, 1);
            continue;
        }

        switch ($Herp) {
            case 'а': /* а */
                $Herp = 'a';
                break;
            case 'А': /* А */
                $Herp = 'A';
                break;
            case 'ә': /* ә */
            case 'ə': /* ə */
                $Herp = 'e';
                break;
            case 'Ә': /* Ә */
            case 'Ə': /* Ə */
                $Herp = 'E';
                break;
            case 'е': /* е */
            case 'э': /* э */
                $Herp = 'é';
                break;
            case 'Е': /* Е */
            case 'Э': /* Э */
                $Herp = 'É';
                break;
            case 'і':
            case 'и': /* и */
                $Herp = 'i';
                break;
            case 'І':
            case 'И': /* И */
                $Herp = 'I';
                break;
            case 'о': /* о */
                $Herp = 'o';
                break;
            case 'О': /* О */
                $Herp = 'O';
                break;
            case 'у': /* у */
                $Herp = 'u';
                break;
            case 'У': /* У */
                $Herp = 'U';
                break;
            case 'ө': /* ө */
            case 'ў': /* ў */
                $Herp = 'ö';
                break;
            case 'Ө': /* Ө */
            case 'Ў': /* Ў */
                $Herp = 'Ö';
                break;
            case 'ү': /* ү */
                $Herp = 'ü';
                break;
            case 'Ү': /* Ү */
                $Herp = 'Ü';
                break;
            case 'б': /* б */
                $Herp = 'b';
                break;
            case 'Б': /* Б */
                $Herp = 'B';
                break;
            case 'п': /* п */
                $Herp = 'p';
                break;
            case 'П': /* П */
                $Herp = 'P';
                break;
            case 'т': /* т */
                $Herp = 't';
                break;
            case 'Т': /* Т */
                $Herp = 'T';
                break;
            case 'җ': /* җ */
                $Herp = 'j';
                break;
            case 'Җ': /* Җ */
                $Herp = 'J';
                break;
            case 'ч': /* ч */
                $unicode = $unicode . 'c';
                $Herp = 'h';
                break;
            case 'Ч': /* Ч */
                $unicode = $unicode . 'C';
                $Herp = 'h';
                break;
            case 'х': /* х */
                $Herp = 'x';
                break;
            case 'Х': /* Х */
                $Herp = 'X';
                break;
            case 'д': /* д */
                $Herp = 'd';
                break;
            case 'Д': /* Д */
                $Herp = 'D';
                break;
            case 'р': /* р */
                $Herp = 'r';
                break;
            case 'Р': /* Р */
                $Herp = 'R';
                break;
            case 'з': /* з */
                $Herp = 'z';
                break;
            case 'З': /* З */
                $Herp = 'Z';
                break;
            case 'ж': /* ж */
                $unicode = $unicode . 'z';
                $Herp = 'h';
                break;
            case 'Ж': /* Ж */
                $unicode = $unicode . 'Z';
                $Herp = 'h';
                break;
            case 'с': /* с */
            case 'Ц': /* Ц */
                $Herp = 's';
                break;
            case 'С': /* С */
            case 'ц': /* ц */
                $Herp = 'S';
                break;
            case 'ш': /* ш */
                $unicode = $unicode . 's';
                $Herp = 'h';
                break;
            case 'Ш': /* Ш */
                $unicode = $unicode . 'S';
                $Herp = 'h';
                break;
            case 'ғ': /* ғ */
                $unicode = $unicode . 'g';
                $Herp = 'h';
                break;
            case 'Ғ': /* Ғ */
                $unicode = $unicode . 'G';
                $Herp = 'h';
                break;
            case 'ф': /* ф */
                $Herp = 'f';
                break;
            case 'Ф': /* Ф */
                $Herp = 'F';
                break;
            case 'қ': /* қ */
                $Herp = 'q';
                break;
            case 'Қ': /* Қ */
                $Herp = 'Q';
                break;
            case 'к': /* к */
                $Herp = 'k';
                break;
            case 'К': /* К */
                $Herp = 'K';
                break;
            case 'г': /* г */
                $Herp = 'g';
                break;
            case 'Г': /* Г */
                $Herp = 'G';
                break;
            case 'ң': /* ң */
                $unicode = $unicode . 'n';
                $Herp = 'g';
                break;
            case 'Ң': /* Ң */
                $unicode = $unicode . 'N';
                $Herp = 'G';
                break;
            case 'л': /* л */
                $Herp = 'l';
                break;
            case 'Л': /* Л */
                $Herp = 'L';
                break;
            case 'м': /* м */
                $Herp = 'm';
                break;
            case 'М': /* М */
                $Herp = 'M';
                break;
            case 'н': /* н */
                $Herp = 'n';
                break;
            case 'Н': /* Н */
                $Herp = 'N';
                break;
            case 'һ': /* һ */
            case 'ҳ': /* ҳ */
                $Herp = 'h';
                break;
            case 'Һ': /* Һ */
            case 'Ҳ': /* ҳ */
                $Herp = 'H';
                break;
            case 'в': /* в */
                $Herp = 'w';
                break;
            case 'В': /* В */
                $Herp = 'W';
                break;
            case 'й': /* й */
                $Herp = 'y';
                break;
            case 'Й': /* Й */
                $Herp = 'Y';
                break;
            case 'я': /* я */
                $unicode = $unicode . 'y';
                $Herp = 'a';
                break;
            case 'Я': /* Я */
                $unicode = $unicode . 'Y';
                $Herp = 'a';
                break;
            case 'ю': /* ю */
                $unicode = $unicode . 'y';
                $Herp = 'u';
                break;
            case 'Ю': /* Ю */
                $unicode = $unicode . 'Y';
                $Herp = 'u';
                break;
            case 'ё': /* ё */
                $unicode = $unicode . 'y';
                $Herp = 'o';
                break;
            case 'Ё': /**/
                $unicode = $unicode . 'Y';
                $Herp = 'o';
                break;
            case 'ұ': /* ұ */
                $Herp = 'u';
                break;
            case 'Ұ': /* Ұ */
                $Herp = 'U';
                break;
            case 'Ы': /* Ы */
            case 'ы': /* ы */
                $Herp = 'i';
                break;
            case 'ъ':
                $Herp = '’';
                break;
            case 'ь':
            case 'Ь':
                $Herp = '';
                break;
        }
        $unicode = $unicode . $Herp;
        $pos++;
        $Herp = mb_substr($contents, $pos, 1);
    }
    return $unicode;
}

?>
