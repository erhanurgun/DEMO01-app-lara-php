<?php

// izin kontrol işlemi
if (!permission('tags', 'show')) {
    permissionPage();
}

// eğer sayfa değeri yoksa sayfayı yönlendir


// verileri çekme ve sayfalama
$totalRecord = $db->from('tags')
    ->select('COUNT(tags.tag_id) AS total')
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
$query = $db->from('tags')
    ->select('tags.*, COUNT(post_tags.id) AS total')
    ->join('post_tags', '%s.tag_id = %s.tag_id', 'left')
    ->groupBy('tags.tag_id')
    ->orderby('tag_id', 'DESC')
    ->limit($pagination['start'], $pagination['limit'])
    ->all();

// kullanıcılar bu alanda listelensin
require adminView('tags');