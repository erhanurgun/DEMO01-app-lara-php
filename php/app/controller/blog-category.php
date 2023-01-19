<?php

$categoryUrl = route(2);
if (!$categoryUrl) {
    header('Location: ' . siteUrl('404'));
    exit;
}

$category = $db->from('categories')
    ->where('category_url', $categoryUrl)
    ->first();
if (!$category) {
    header('Location: ' . siteUrl('404'));
    exit;
}

$seo = json_decode($category['category_seo'], true);

$meta = [
    'title' => $seo['title'] ? $seo['title'] : $category['category_name'],
    'description' => $seo['description'] ? $seo['description'] : null
];

// verileri çekme ve sayfalama
$totalRecord = $db->from('posts')
    ->select('count(DISTINCT post_id) as total')
    ->join('categories', 'FIND_IN_SET(categories.category_id, posts.post_categories)')
    ->where('post_status', 1)
    ->findInSetReverse('post_categories', $category['category_id'])
    ->total();

// sayfalama ayarlarını yapılandırma
$pageLimit = setting('blog_category_pagination');
$pageParam = 'page';
$pagination = $db->pagination($totalRecord, $pageLimit, $pageParam);

// sayfalama işlmemini yapma
$posts = $db->from('posts')
    ->select('posts.*, GROUP_CONCAT(category_name SEPARATOR ", ") AS category_name, GROUP_CONCAT(category_url SEPARATOR ",") AS category_url')
    ->join('categories', 'FIND_IN_SET(categories.category_id, posts.post_categories)')
    ->where('post_status', 1)
    ->findInSetReverse('post_categories', $category['category_id'])
    ->groupBy('posts.post_id')
    ->orderby('post_id', 'DESC')
    ->limit($pagination['start'], $pagination['limit'])
    ->all();

$lastPosts = $db->from('posts')
    ->where('post_status', 1)
    ->orderby('post_id', 'DESC')
    ->limit(0, 3)
    ->all();

require view('blog-category');