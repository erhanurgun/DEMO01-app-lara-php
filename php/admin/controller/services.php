<?php

// izin kontrol işlemi
if (!permission('services', 'show')){
    permissionPage();
}

// verileri çekme ve sayfalama
$totalRecord = $db->from('services')
    ->select('COUNT(service_id) as total')
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
$query = $db->from('services')
    ->orderby('service_order')
    ->limit($pagination['start'], $pagination['limit'])
    ->all();

// kullanıcılar bu alanda listelensin
require adminView('services');