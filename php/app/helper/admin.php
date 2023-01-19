<?php
// controller'ları fonksiyon kullanarak göster
function adminController($controllerName)
{
    $controllerName = strtolower($controllerName);
    return PATH . '/admin/controller/' . $controllerName . '.php';
}

// view'leri fonksiyon kullanarak göster
function adminView($viewName)
{
    return PATH . '/admin/view/' . $viewName . '.php';
}

// admin url'lerini göstermek için
function adminUrl($url = false)
{
    $link = explode('://', $url);
    if ($link[0] == 'http' || $link[0] == 'https') {
        return $url;
    }
    return URL . '/admin/' . $url;
}

// admin dosya url'lerini göstermek için
function adminPublicUrl($url = false)
{
    $path = '/admin/assets/' . $url;
    // return SUBFOLDER_NAME . $path;
    return $path;
}

function settingPermission($auth)
{
    global $menus;
    foreach ($menus as $menu) {
        if ($menu['url'] == 'settings') {
            $arr = $menu['permissions']['sub'] ?? null;
            if (is_array($arr)) {
                foreach ($arr as $key => $val) {
                    if ($key == $auth) return true;
                }
            }
        }
    }
    return false;
}

function settingPermArr($url = 'settings', $data = true)
{
    global $menus;
    foreach ($menus as $menu) {
        if ($menu['url'] == $url) {
            if (!$data) {
                return true;
            }
            $arr = $menu['permissions']['sub'] ?? null;
            if (is_array($arr)) return $arr;
        }
    }
    return false;
}
