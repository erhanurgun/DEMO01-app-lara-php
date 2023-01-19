<?php

$breadcumb = [
    [
        'title' => 'Anasayfa',
        'href' => 'index'
    ],
    [
        'title' => 'Blog',
    ]
];

if (route(1) == 'category') {
    require controller('blog-category');
} elseif (route(1) == 'search') {
    require controller('blog-search');
} elseif (route(1) == 'tag') {
    require controller('blog-tag');
} else {
    if ($postUrl = route(1)) {
        require controller('blog-detail');
    } else {
        // meta ayarları
        $meta = [
            'title' => setting('blog_title'),
            'description' => setting('blog_description')
        ];

        // verileri çekme ve sayfalama
        $totalRecord = $db->from('posts')
            ->select('count(post_id) as total')
            ->where('post_status', 1)
            ->total();

        // sayfalama ayarlarını yapılandırma
        $pageLimit = setting('blog_pagination');
        $pageParam = 'page';
        $pagination = $db->pagination($totalRecord, $pageLimit, $pageParam);

        // sayfalama işlmemini yapma
        $posts = $db->from('posts')
            ->select('posts.*, GROUP_CONCAT(category_name SEPARATOR ", ") AS category_name, GROUP_CONCAT(category_url SEPARATOR ",") AS category_url')
            ->join('categories', 'FIND_IN_SET(categories.category_id, posts.post_categories)')
            ->where('post_status', 1)
            ->groupBy('posts.post_id')
            ->orderby('post_id', 'DESC')
            ->limit($pagination['start'], $pagination['limit'])
            ->all();

        $lastPosts = $db->from('posts')
            ->where('post_status', 1)
            ->orderby('post_id', 'DESC')
            ->limit(0, 3)
            ->all();

        // gösterilercek sayfaları ayarla
        require view('blog');
    }
}