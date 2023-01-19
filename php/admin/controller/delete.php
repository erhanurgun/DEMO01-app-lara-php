<?php

// genel silme işlemine tabi tutma
$selectAll = get('select_all');
$imgColmn = get('img_colmn');
$stColmn = get('st_column');
$status = get('status');
$column = get('column');
$table = get('table');
$type = get('type');
$id = get('id');
$query = '';
$redirectUser = get('table');

if ($table == 'sliders') {
    $redirectUser = 'others';
} elseif ($table == 'teams') {
    $redirectUser = 'others';
    $_SESSION['click_id'] = '#teams';
} else {
    $redirectUser = $table;
}
demoUser($redirectUser);

// izin kontrol işlemi
if (!permission($redirectUser, 'delete')) {
    permissionPage();
}

if ($type && $type == 'multiple') {
    if ($selectAll && $selectAll == 'yes') {
        if ($status && is_numeric($status)) {
            $db->delete($table)->where($stColmn, $status)->done();
        } else {
            $db->delete($table)->done();
        }
        if ($imgColmn && $imgColmn != 'no') {
            unlink(PATH . '/upload/' . $table . '/*');
        }
    } else {
        foreach (get('ids') as $itemId) {
            $data = $db->from($table)
                ->where($column, $itemId)
                ->first();
            $db->delete($table)
                ->where($column, $itemId)
                ->done();
            if ($imgColmn && $imgColmn != 'no') {
                unlink(PATH . '/upload/' . $table . '/' . $data[$imgColmn]);
            }
        }
    }
    $success = "Silme işlemi başarıyla tamamlandı.";
    $_SESSION['log_success'] = $success ?? null;
} else {
    if ($table == 'medias') {
        foreach (get('ids') as $media) {
            $data = $db->from('medias')
                ->where('media_id', $media)
                ->first();
            $db->delete('medias')
                ->where('media_id', $media)
                ->done();
            unlink(PATH . '/upload/medias/' . $data['media_url']);
        }
        $success = "İşlem başarıyla tamamlandı.";
        $_SESSION['log_success'] = $success ?? null;
    } elseif ($table == 'sliders') {
        $data = $db->from($table)
            ->where($column, $id)
            ->first();
        $query = $db->delete($table)
            ->where($column, $id)
            ->done();
        unlink(PATH . '/upload/sliders/' . $data['slid_image']);
    } elseif ($table == 'teams') {
        $data = $db->from($table)
            ->where($column, $id)
            ->first();
        $query = $db->delete($table)
            ->where($column, $id)
            ->done();
        unlink(PATH . '/upload/teams/' . $data['team_img']);
    } else {
        // silme işlemini gerçekleştirme
        $query = $db->delete($table)
            ->where($column, $id)
            ->done();
        // eğer silme işlemi posts tablosuna aitse
        if ($table == 'posts') {
            if ($query) {
                // konuya ait etiketleri sil
                $db->delete('post_tags')
                    ->where('tag_post_id', $id)
                    ->done();
                // konuya ait yorumları sil
                $db->delete('comments')
                    ->where('post_id', $id)
                    ->done();
            }
        }
        // etikete ait konu etiketlerini silme
        if ($table == 'tags') {
            if ($query) {
                $db->delete('post_tags')
                    ->where('tag_id', $id)
                    ->done();
            }
        }
    }

    if ($query) {
        $success = "İşlem başarıyla tamamlandı.";
        $_SESSION['log_success'] = $success ?? null;
    } else {
        $error = 'Bir sorun oluştu!';
        $_SESSION['log_error'] = $error ?? null;
    }
}

if ($_SERVER['HTTP_REFERER']) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location:' . adminUrl($redirectUser));
}
exit;
