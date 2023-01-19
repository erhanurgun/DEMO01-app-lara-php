<?php

// izin kontrol işlemi
if (!permission('comments', 'edit')) {
    permissionPage();
}

// id parametresi yoksa yönlendir
$id = get('id');
if (!$id) {
    header('Location: ' . adminUrl('comments'));
    exit();
}
// kullanıcıyı çekme
$row = $db->from('comments')
    ->join('posts', '%s.post_id = %s.post_id')
    ->where('comment_id', $id)
    ->first();

// kullanıcı bulunamadıysa yönlendir
if (!$row) {
    header('Location: ' . adminUrl('comments'));
    exit();
}

// düzenleme isteği yapıldı mı
if (post('submit')) {
    // izinler dışındaki verileri al
    if ($data = formControl('comment_status')) {
        $data['comment_status'] = post('comment_status');
        // verileri güncelle
        demoUser('comments');
        $query = $db->update('comments')
            ->where('comment_id', $id)
            ->set($data);
        // veriler güncellendiyse yönlendir
        if ($query) {
            $success = "İşlem başarıyla tamamlandı.";
            $_SESSION['log_success'] = $success ?? null;
            header('Location: ' . adminUrl('comments'));
            exit();
        } else {
            $error = 'Beklenmedik bir sorun oluştu!';
        }
    } else {
        $error = 'Eksik alanlar var, lütfen kontrol ediniz!';
    }
}
$_SESSION['log_error'] = $error ?? null;

// sayfaya dahil et
require adminView('edit-comment');