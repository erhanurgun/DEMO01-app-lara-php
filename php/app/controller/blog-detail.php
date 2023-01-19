<?php

$row = Blog::findPost($postUrl);

if (!$row) {
    header('Location: ' . siteUrl('404'));
    exit;
}

$seo = json_decode($row['post_seo'], true);

$meta = [
    'title' => $seo['title'] ? $seo['title'] : $row['post_title'],
    'desctiption' => $seo['description'] ? $seo['description'] : setting('description')
];

// yorumları listele
$comments = $db->from('comments')
    ->where('post_id', $row['post_id'])
    ->where('comment_status', 1)
    ->orderBy('comment_id')
    ->all();

$totalComment = $db->from('comments')
    ->select('COUNT(post_id) AS total')
    ->where('post_id', $row['post_id'])
    ->where('comment_status', 1)
    ->total();

$lastPosts = $db->from('posts')
    ->where('post_status', 1)
    ->orderby('post_id', 'DESC')
    ->limit(0, 3)
    ->all();

$tagNames = explode(',', $row['category_name']);
$tagUrls = explode(',', $row['category_url']);
$tags = array_combine($tagUrls, $tagNames);

require view('blog-detail');
