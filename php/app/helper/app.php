<?php
// controller'ları fonksiyon kullanarak göster
function controller($controllerName)
{
    $controllerName = strtolower($controllerName);
    return PATH . '/app/controller/' . $controllerName . '.php';
}

// view'leri fonksiyon kullanarak göster
function view($viewName)
{
    return PATH . '/app/view/' . setting('theme') . '/' . $viewName . '.php';
}

// website url'lerini göstermek için
function siteUrl($url = false)
{
    $link = explode('://', $url);
    if ($link[0] == 'http' || $link[0] == 'https') {
        return $url;
    }
    return URL . '/' . $url;
}

// website dosya url'lerini göstermek için
function publicUrl($url = false)
{
    $path = '/app/assets/' . setting('theme') . '/' . $url;
    // return SUBFOLDER_NAME . $path;
    return $path;
}

function uploadUrl($url = false)
{
    $path = '/upload/' . $url;
    // return SUBFOLDER_NAME . $path;
    return $path;
}

function getPrevPost($id)
{
    global $db;
    do {
        $query = $db->from('posts')
            ->select('post_url')
            ->where('post_id', --$id)
            ->first();
    } while (!$query && $id > 0);
    if ($id <= 0) {
        return 'javascript:void(0)';
    }
    return siteUrl('blog/' . $query['post_url']);
}

function getNextPost($id)
{
    global $db;
    $lastId = $db->from('posts')
        ->select('post_id')
        ->where('post_status', 1)
        ->orderBy('post_id', 'DESC')
        ->first();
    do {
        $query = $db->from('posts')
            ->select('post_url')
            ->where('post_id', ++$id)
            ->first();
    } while (!$query && $id < $lastId['post_id']);
    if ($id > $lastId['post_id']) {
        return 'javascript:void(0)';
    }
    return siteUrl('blog/' . $query['post_url']);
}