<?php

// izin kontrol işlemi
if (!permission('posts', 'edit')) {
    permissionPage();
}

// id değeri var mı kontrol et
$id = get('id');
if (!$id) {
    header('Location: ' . adminUrl());
    exit;
}

// değer  var mı kontrol et
$row = $db->from('posts')
    ->where('post_id', $id)
    ->first();
if (!$row) {
    header('Location' . adminUrl('posts'));
    exit;
}

// verileri çekme
$categories = $db->from('categories')
    ->orderBy('category_name', 'ASC')
    ->all();

// tüm etiketleri JS için alma
$allTags = $db->from('tags')
    ->orderBy('tag_id', 'DESC')
    ->all();
$tagsArr = [];
foreach ($allTags as $allTag) {
    $tagsArr[] = trim($allTag['tag_name']);
}

// etiket verilerini çek
$tags = $db->from('post_tags')
    ->join('tags', '%s.tag_id = %s.tag_id')
    ->where('tag_post_id', $id)
    ->all();
$postTags = [];
foreach ($tags as $tag) {
    $postTags[] = trim($tag['tag_name']);
}

// form gönderildiyse
if (post('submit')) {
    // sayfaya ait verileri al
    $postTitle = post('post_title');
    $postUrl = sefLink(post('post_url'));
    // sayfa URL boşsa sayfa adını URL olarak al
    if (!post('post_url')) {
        $postUrl = sefLink($postTitle);
    }
    // konu veilerini çekme
    $postContent = post('post_content');
    $postCategories = post('post_categories');
    $postStatus = post('post_status');
    $postTags = post('post_tags');
    $postSeo = json_encode(post('post_seo'));
    // sayfa adı veya sayfa url'si boşsa hata ver
    if (!$postUrl || !$postContent || !$postCategories || !$postStatus) {
        $error = 'Lütfen tüm alanları doldurunuz!';
    } else {
        $postCategories = implode(',', $postCategories);
        // konu var mı komtrol et
        $query = $db->from('posts')
            ->where('post_url', $postUrl)
            ->where('post_id', $id, '!=')
            ->first();
        // sorgulanan sayfa varsa
        if ($query) {
            $error = '<strong>' . $postTitle . '</strong> adında bir konu zaten mevcut, lütfen başka bir isim deneyiniz!';
        } else {
            demoUser('posts');
            // resim ekleme
            $fillFile = $_FILES['post_img']['error'] == 0;
            if ($fillFile) {
                $file_path = PATH . '/upload/posts/';
                $handle = new upload($_FILES['post_img']);
                if ($handle->uploaded) {
                    $handle->file_new_name_body = $postUrl . '_' . rand(100000, 999999);
                    $handle->image_ratio_crop = true;
                    // $handle->image_ratio_fill = true;
                    $handle->image_resize = true;
                    // $handle->image_x = 525;
                    // $handle->image_y = 350;
                    $handle->allowed = ['image/*'];
                    $handle->process($file_path);
                    if ($handle->processed) {
                        $postImg = $handle->file_dst_name_body . '.' . $handle->file_dst_name_ext;
                    } else {
                        $error = $handle->error;
                    }
                }
            }
            if (!isset($error)) {
                // yoksa sayfayi ekleme işlemini yap
                $data = [
                    'post_title' => $postTitle,
                    'post_url' => $postUrl,
                    'post_content' => $postContent,
                    'post_categories' => $postCategories,
                    'post_seo' => $postSeo,
                    'post_status' => $postStatus
                ];
                if ($fillFile) {
                    $data['post_img'] = $postImg;
                }
                $query = $db->update('posts')
                    ->where('post_id', $id)
                    ->set($data);
                // ekleme işlemi başarılıysa sayfaler alanına yönlendir
                if ($query) {
                    $postId = $id;
                    // etiketleri kontrol et ve ekle
                    $postTags = array_map('trim', explode(",", $postTags));
                    $postTags = array_filter($postTags);
                    if (count($postTags) > 0) {
                        foreach ($postTags as $tag) {
                            // etiket var mı kontrol et
                            // TODO: etiketler olduğu halde yeniden ekleme yapıyor!
                            $row = $db->from('tags')
                                ->where('tag_url', sefLink($tag))
                                ->first();
                            if (!$row) {
                                $tagInsert = $db->insert('tags')
                                    ->set([
                                        'tag_name' => $tag,
                                        'tag_url' => sefLink($tag)
                                    ]);
                                $tagId = $db->lastId();
                            } else {
                                $tagId = $row['tag_id'];
                            }
                            // konuya ait etiket var mı?
                            $row = $db->from('post_tags')
                                ->where('tag_post_id', $postId)
                                ->where('tag_id', $tagId)
                                ->first();
                            if (!$row) {
                                $db->insert('post_tags')
                                    ->set([
                                        'tag_post_id' => $postId,
                                        'tag_id' => $tagId,
                                    ]);
                            }
                        }
                    }
                    // silinen etiketleri kontrol et!
                    $diffs = array_diff($postTags, $postTags);
                    if ($diffs > 0) {
                        foreach ($diffs as $diff) {
                            foreach ($allTags as $allTag) {
                                if (trim($allTag['tag_name']) == $diff) {
                                    $db->delete('post_tags')
                                        ->where('tag_id', $allTag['tag_id'])
                                        ->where('tag_post_id', $id)
                                        ->done();
                                }
                            }
                        }
                    }
                    // işlem tamamsa yönlendir
                    $success = "İşlem başarıyla tamamlandı.";
                    $_SESSION['log_success'] = $success ?? null;
                    header('Location: ' . adminUrl('posts'));
                    exit;
                } else {
                    $error = 'Bir sorun oluştu ve veri güncellenemedi!';
                }
            } else {
                $error = 'Beklenmedik bir sorun oluştu, lütfen tekrar deneyiniz!';
            }
        }
    }
}
$_SESSION['log_error'] = $error ?? null;

// seo verilerini çek
$seo = json_decode($row['post_seo'], true);

// menü ekleme html alanının gösterilmesi
require adminView('edit-post');