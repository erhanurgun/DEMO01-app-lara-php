<?php

$tagUrl = route(2);
if (!$tagUrl) {
    header('Location: ' . siteUrl('404'));
    exit;
}

$tag = $db->from('tags')
    ->where('tag_url', $tagUrl)
    ->first();
if (!$tag) {
    header('Location: ' . siteUrl('404'));
    exit;
}

if ($tag['tag_seo']) {
    $seo = json_decode($tag['tag_seo'], true);
    $meta = [
        'title' => $seo['title'] ? $seo['title'] : $tag['tag_name'],
        'description' => $seo['description'] ? $seo['description'] : null
    ];
}

// verileri çekme ve sayfalama
$totalRecord = $db->from('post_tags')
    ->select('count(id) as total')
    ->where('tag_id', $tag['tag_id'])
    ->total();

// sayfalama ayarlarını yapılandırma
$pageLimit = setting('blog_tag_pagination');
$pageParam = 'page';
$pagination = $db->pagination($totalRecord, $pageLimit, $pageParam);

// sayfalama işlmemini yapma
$postTags = $db->from('post_tags')
    ->select('posts.*, GROUP_CONCAT(category_name SEPARATOR ", ") AS category_name, GROUP_CONCAT(category_url SEPARATOR ",") AS category_url')
    ->join('posts', '%s.post_id = %s.tag_post_id')
    ->join('categories', 'FIND_IN_SET(categories.category_id, posts.post_categories)')
    ->where('tag_id', $tag['tag_id'])
    ->groupBy('posts.post_id')
    ->orderBy('post_id', 'DESC')
    ->limit($pagination['start'], $pagination['limit'])
    ->all();

$lastPosts = $db->from('posts')
    ->where('post_status', 1)
    ->orderby('post_id', 'DESC')
    ->limit(0, 3)
    ->all();

require view('blog-tag');