<?php

// izin kontrol işlemi
if (!permission('comments', 'show')) {
    permissionPage();
}

// verileri çekme ve sayfalama
$totalRecord = $db->from('comments')
    ->select('count(comment_id) as total');
if ($status = get('status')) {
    $totalRecord = $db->where('comment_status', ($status == 2 ? 0 : $status));
}
$totalRecord = $db->total();

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
$query = $db->from('comments')
    ->join('posts', '%s.post_id = %s.post_id');
if ($status = get('status')) {
    $query = $db->where('comment_status', ($status == 2 ? 0 : $status));
}
$query = $db->orderby('comment_id', 'DESC')
    ->limit($pagination['start'], $pagination['limit'])
    ->all();

// kullanıcılar bu alanda listelensin
require adminView('comments');