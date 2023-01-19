<?php

// hata var mı?
function error()
{
    global $error;
    return $error ?? false;
}

// işlem başarılı mı?
function success()
{
    global $success;
    return $success ?? false;
}

// menü gösterme işlemi
function menu($id)
{
    global $db;
    // menü verilerini oku
    $row = $db->from('menus')->where('menu_id', $id)->first();
    // eğer veri varsa
    if ($row) {
        // gelen JSON formatındaki değerleri diziye çevir ve geriye döndür
        $data = json_decode($row['menu_content'], true);
        return $data;
    }
    return false;
}

/*function menuUrl($url)
{
    if (!strstr($url, 'http')) {
        return siteUrl($url);
    }
    return $url;
}*/

function cutText($str, $limit = 220)
{
    $str = strip_tags(htmlspecialchars_decode($str));
    $lenght = strlen($str);
    if ($lenght > $limit) {
        $str = mb_substr($str, 0, $limit, 'UTF-8') . '...';
    }
    return $str;
}

function textType($text, $type = null)
{
    switch ($type) {
        case 'upper':
            return Transliterator::create('tr-upper')->transliterate($text);
        case 'lower':
            return Transliterator::create('tr-lower')->transliterate($text);
        case 'title':
            return Transliterator::create('tr-title')->transliterate($text);
        case 'user':
            $data = explode(' ', $text);
            if (count($data) == 2) {
                $firstName = Transliterator::create('tr-title')->transliterate($data[0]);
                $lastName = Transliterator::create('tr-upper')->transliterate($data[1]);
                return "$firstName $lastName";
            } elseif (count($data) == 3) {
                $firstName = Transliterator::create('tr-title')->transliterate($data[0]);
                $secondName = Transliterator::create('tr-title')->transliterate($data[1]);
                $lastName = Transliterator::create('tr-upper')->transliterate($data[2]);
                return "$firstName $secondName $lastName";
            } else {
                return $text;
            }
        default:
            return $text;
    }
}

function trDateConvert($date)
{
    $entered = date($date);
    $formated = date_create($entered);
    $day = $formated->format("d");
    $month = $formated->format("m");
    $year = $formated->format("Y");
    $months = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
    $monthName = $months[$month - 1];
    return "$day $monthName $year";
}

function faDatetime($date, $type = 'full')
{
    $data = explode(' ', $date);
    $date = trDateConvert($data[0]);
    $time = substr($data[1], 0, 5);
    if ($type == 'date') {
        return $date;
    } elseif ($type == 'date') {
        return $time;
    } else {
        return "<i class=\"fa fa-cs fa-calendar\"></i> $date\n" .
            "<i class=\"fa fa-cs fa-clock-o\"></i> $time";
    }
}

function userRanks($rankId = null, $type = 'data')
{
    $ranks = [
        1 => ['name' => 'Teknik Destek', 'color' => 'danger'],
        2 => ['name' => 'Yönetici', 'color' => 'success'],
        3 => ['name' => 'Demo', 'color' => 'info']
    ];
    if ($type == 'list') {
        for ($i = 1; $i <= 3; $i++) {
            $list[$i] = $ranks[$i]['name'];
        }
        return $list;
    } elseif ($type == 'user') {
        return '<span class="rank">' . $ranks[$rankId]['name'] . '</span>';
    }
    return '<span class="badge badge-' . $ranks[$rankId]['color'] . '">' . $ranks[$rankId]['name'] . '</span>';
}

function tdStatus($num, $type = 'status')
{
    $status = [
        0 => [
            'name' => ($type == 'read' ? 'Okunmadı' : ($type == 'confirm' ? 'Onay Bekliyor' : ($type == 'post' ? 'Taslak' : 'Pasif'))),
            'color' => 'danger'
        ],
        1 => [
            'name' => ($type == 'read' ? 'Okundu' : ($type == 'confirm' ? 'Onaylandı' : ($type == 'post' ? 'Yayında' : 'Aktif'))),
            'color' => 'success'
        ],
    ];
    return '<span class="badge badge-' . $status[$num]['color'] . '">' . $status[$num]['name'] . '</span>';
}

// görüntüleme izinlerini kontrol ettirme
function permission($url, $action)
{
    $permissions = json_decode(session('user_permissions'), true);
    if (isset($permissions[$url][$action]) || isset($permissions[$url]['sub'][$action]))
        return true;
    return false;
}

// izin yokksa işlemi sonlandırma fonksiyonu
function permissionPage()
{
    // TODO: daha sonradan düzeltilecektir
    die('Bu alan için yetkiniz kısıtlanmıştır!');
    // header('Location: ' . adminUrl('404'));
    // exit;
}

// route'u dinamik olarak çekme işlemi
function route($index)
{
    global $route;
    return $route[$index] ?? false;
}

// hangi url'de olduğunu bulma
function howRoute($index = 1)
{
    if ($_SERVER['REQUEST_URI'] != '/') {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        return $uri[count($uri) - $index];
    }
    return 'index';
}

function demoUser($redirect = 'index', $type = 'reload')
{
    global $json;
    if (session('user_rank') == 3) {
        $error = "Şu an <b>demo yetkisine sahip</b> bir hesap ile giriş yaptığınız için işlem yapamıyorsunuz!";
        if ($type == 'ajax') {
            $json['error'] = $error;
        } elseif ($type == 'view') {
            return true;
        } else {
            $_SESSION['log_error'] = $error ?? null;
            header('Location: ' . adminUrl($redirect));
            exit;
        }
    }
}

// ayarları çağırma işlemi için
function setting($name, $subname = null)
{
    global $settings;
    if ($subname) {
        return $settings[$name][$subname] ?? false;
    }
    return $settings[$name] ?? false;
}

// whatsapp seo numara formatlama işlemi
function wpFormat($str, $options = [])
{
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
    $defaults = [
        'delimiter' => '',
        'limit' => null,
        'lowercase' => true,
        'replacements' => [],
        'transliterate' => true
    ];
    $options = array_merge($defaults, $options);
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    $str = trim($str, $options['delimiter']);
    $str = $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    return $str[0] != '9' ? '9' . $str : $str;
}

// oturum işlemlerini yönetme
function session($name)
{
    return $_SESSION[$name] ?? false;
}

// sayı sıfırdan küçükse
function countRow($num)
{
    global $pageLimit;
    if (get('page')) {
        $num += ($pageLimit * get('page')) - $pageLimit;
    }
    return $num < 10 ? '0' . $num : $num;
}

// bir tarihin yazısal kaşılığını gösterme
function timeConvert($time)
{
    $time = strtotime($time);
    $timeDiff = time() - $time;
    $second = $timeDiff;
    $minute = round($timeDiff / 60);
    $hour = round($timeDiff / 3600);
    $day = round($timeDiff / 86400);
    $week = round($timeDiff / 604800);
    $month = round($timeDiff / 2419200);
    $year = round($timeDiff / 29030400);
    if ($second < 60) {
        if ($second == 0) {
            return "az önce";
        } else {
            return $second . ' saniye önce';
        }
    } else if ($minute < 60) {
        return $minute . ' dakika önce';
    } else if ($hour < 24) {
        return $hour . ' saat önce';
    } else if ($day < 7) {
        return $day . ' gün önce';
    } else if ($week < 4) {
        return $week . ' hafta önce';
    } else if ($month < 12) {
        return $month . ' ay önce';
    } else {
        return $year . ' yıl önce';
    }
}

// iki tarih arasındaki zamanın farkını yazılsal olarak alma
function timeAgo($date, $full = true)
{
    $arr = [
        '%y' => 'yıl', '%m' => 'ay', '%d' => 'gün',
        '%h' => 'saat', '%i' => 'dakika', '%s' => 'saniye'
    ];
    $result = '';
    $timestamp = strtotime($date);
    $lastDate = new DateTime('@' . $timestamp);
    $nowDate = new DateTime('@' . time());
    foreach ($arr as $key => $val) {
        if (!$full && $key == '%h') break;
        $exist = $lastDate->diff($nowDate)->format($key);
        // $exist = $exist < 10 ? '0' . $exist : $exist;
        $result .= $exist ? "$exist $val " : null;
    }
    return $result . ' önce';
}

function isInternet()
{
    $host = 'www.google.com';
    $port = '80';
    $status = (bool)@fsockopen($host, $port, $errNo, $errStr, 10);
    if ($status) {
        return true;
    }
    return false;
}

function getGravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array())
{
    if (isInternet()) {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    } else {
        if (route(0) == 'admin') {
            return adminPublicUrl('images/demo/user.png');
        } else {
            return publicUrl('images/demo/user.png');
        }
    }
}

// seo link yapısını oluşturma
function seoLink($str, $options = array())
{ // todo: hatali calisiyor
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => true
    );
    $options = array_merge($defaults, $options);
    $charMap = array(
        // Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',
        // Latin symbols
        '©' => '(c)',
        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z',
        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',
        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    if ($options['transliterate']) {
        $str = str_replace(array_keys($charMap), $charMap, $str);
    }
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    $str = trim($str, $options['delimiter']);
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}

// seo link 2
function sefLink($text)
{
    $find = ['Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#'];
    $replace = ['c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp'];
    $text = strtolower(str_replace($find, $replace, $text));
    $text = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $text);
    $text = trim(preg_replace('/\s+/', ' ', $text));
    return str_replace(' ', '-', $text);
}

function removeEmpty($val)
{
    return ($val !== NULL && $val !== FALSE && $val !== "");
}

function isLogin($session)
{
    if (isset($_SESSION[$session])) {
        if (route(1) == 'login') {
            $error = 'Zaten giriş yapmış durumdasınız!';
        } elseif (route(1) == 'forgot-pass') {
            $error = 'Oturumunuz mevcut olduğundan şifre sıfırlama işlemini yapamazsınız!';
        }
        $_SESSION['log_error'] = $error ?? null;
        header('Location: ' . adminUrl());
        exit;
    }
}

function haveData($data)
{
    return (!empty($data) ? $data : '<i class="txt-silver">Veri Yok!</i>');
}

function selected($data, $val)
{
    return ($data == $val ? 'selected' : '');
}

function checked($data, $val)
{
    return ($data == $val ? 'checked' : '');
}