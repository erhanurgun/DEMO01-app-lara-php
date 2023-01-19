<?php

class Blog
{
    public static function categories()
    {
        global $db;
        $query = $db->from('categories')
            ->select('categories.*, COUNT(category_id) AS total')
            ->join('posts', 'FIND_IN_SET(category_id, post_categories)')
            ->orderBy('category_order', 'ASC')
            ->groupBy('category_id')
            ->all();
        return $query;
    }

    public static function findPost($postUrl)
    {
        global $db;
        return $db->from('posts')
            ->select('posts.*, GROUP_CONCAT(category_name SEPARATOR ", ") AS category_name, GROUP_CONCAT(category_url SEPARATOR ",") AS category_url')
            ->join('categories', 'FIND_IN_SET(category_id, post_categories)')
            ->where('post_url', $postUrl)
            ->where('post_status', 1)
            ->groupBy('post_id')
            ->first();
    }

    public static function findPostById($postId)
    {
        global $db;
        return $db->from('posts')
            ->where('post_id', $postId)
            ->where('post_status', 1)
            ->first();
    }

    public static function getRandomTags($limit = 10)
    {
        global $db;
        return $db->from('tags')
            ->orderBy('', 'rand()')
            ->limit(0, $limit)
            ->all();
    }
}