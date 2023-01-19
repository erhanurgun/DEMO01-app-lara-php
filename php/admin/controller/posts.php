<?php

// izin kontrol işlemi
if (!permission('posts', 'show')) {
    permissionPage();
}

// verileri çekme ve sayfalama
$totalRecord = $db->from('posts')
    ->select('count(post_id) as total')
    ->total();

// sayfalama ayarlarını yapılandırma
$pageLimit = setting('admin_table_pagination');
$pageParam = 'page';
$pagination = $db->pagination($totalRecord, $pageLimit, $pageParam);
$maxPageNum = ceil($totalRecord / $pageLimit);

if (
    get('page') &&
    (get('page') > $maxPageNum || !is_numeric(get('page'))) ||
    (is_numeric(get('page')) && get('page') < 2)
) {
    header('Location: ' . route(1) . ($maxPageNum > 1 ? '?page=' . $maxPageNum : ''));
    exit;
}

// sayfalama işlmemini yapma
$query = $db->from('posts')
    ->orderby('post_id', 'DESC')
    ->limit($pagination['start'], $pagination['limit'])
    ->all();

// kullanıcılar bu alanda listelensin
require adminView('posts');