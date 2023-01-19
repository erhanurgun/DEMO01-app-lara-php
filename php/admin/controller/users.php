<?php

// izin kontrol işlemi
if (!permission('users', 'show')) {
    permissionPage();
}

// kullanıcıları çekme ve sayfalama
$totalRecord = $db->from('users')
    ->select('COUNT(user_id) as total')
    ->total();

// sayfalama ayarlarını yapılandır
$pageLimit = setting('admin_table_pagination');
$pageParam = 'page';
$pagination = $db->pagination($totalRecord, $pageLimit, $pageParam);
$maxPageNum = ceil($totalRecord / $pageLimit);

if (get('page') && (get('page') > $maxPageNum || !is_numeric(get('page')))) {
    header('Location: ' . route(1) . '?page=' . $maxPageNum);
    exit;
}

// sayfalama işlemini yap
$query = $db->from('users')
    ->orderby('user_rank')
    ->limit($pagination['start'], $pagination['limit'])
    ->all();

// kullanıcılar bu alanda listelensin
require adminView('users');