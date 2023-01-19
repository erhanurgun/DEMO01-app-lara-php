<?php

if (!get('q')) {
    header('Location: ' . siteUrl('blog'));
    exit;
}

$meta = [
    'title' => sprintf(setting('blog_search_title'), get('q')),
    'description' => sprintf(setting('blog_search_description'), get('q'))
];

// verileri çekme ve sayfalama
$totalRecord = $db->from('posts')
    ->select('count(DISTINCT post_id) as total')
    ->join('categories', 'FIND_IN_SET(categories.category_id, posts.post_categories)')
    ->where('post_status', 1)
    ->group(function ($db) {
        $db->where('post_title', get('q'), 'LIKE')
            ->orWhere('post_content', get('q'), 'LIKE');
    })->total();

// sayfalama ayarlarını yapılandırma
$pageLimit = setting('blog_search_pagination');
$pageParam = 'page';
$pagination = $db->pagination($totalRecord, $pageLimit, $pageParam);

// sayfalama işlmemini yapma
$posts = $db->from('posts')
    ->select('posts.*, GROUP_CONCAT(category_name SEPARATOR ", ") AS category_name, GROUP_CONCAT(category_url SEPARATOR ",") AS category_url')
    ->join('categories', 'FIND_IN_SET(categories.category_id, posts.post_categories)')
    ->where('post_status', 1)
    ->group(function ($db) {
        $db->where('post_title', get('q'), 'LIKE')
            ->orWhere('post_content', get('q'), 'LIKE');
    })->groupBy('posts.post_id')
    ->orderby('post_id', 'DESC')
    ->limit($pagination['start'], $pagination['limit'])
    ->all();

$lastPosts = $db->from('posts')
    ->where('post_status', 1)
    ->orderby('post_id', 'DESC')
    ->limit(0, 3)
    ->all();

require view('blog-search');