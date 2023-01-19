<?php

// izin kontrol işlemi
if (!permission('contact', 'show')){
    permissionPage();
}

// verileri çekme ve sayfalama
$totalRecord = $db->from('contact')
    ->select('COUNT(contact_id) AS total')
    ->total();

// sayfalama ayarlarını yapılandırma
$pageLimit = setting('admin_table_pagination');
$pageParam = 'page';
$pagination = $db->pagination($totalRecord, $pageLimit, $pageParam);
$maxPageNum = ceil($totalRecord / $pageLimit);

if (get('page') && (get('page') > $maxPageNum || !is_numeric(get('page')))) {
    header('Location: ' . route(1) . '?page=' . $maxPageNum);
    exit;
}
// sayfalama işlmemini yapma
$query = $db->from('contact')
    ->join('users', '%s.user_id = %s.contact_read_user', 'left')
    ->orderby('contact_id', 'DESC')
    ->limit($pagination['start'], $pagination['limit'])
    ->all();

// kullanıcılar bu alanda listelensin
require adminView('contact');