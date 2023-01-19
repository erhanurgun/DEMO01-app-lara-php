<?php
// izin kontrol işlemi
if (!permission('tags', 'add')) {
    permissionPage();
}

// form gönderildiyse
if (post('submit')) {
    // sayfaya ait verileri al
    $tagName = post('tag_name');
    $tagUrl = sefLink(post('tag_url'));
    // sayfa URL boşsa sayfa adını URL olarak al
    if (!post('tag_url')) {
        $tagUrl = sefLink($tagName);
    }
    // etikete ait başlık ve açıklamaları json formatına çevir
    $tagSeo = json_encode(post('tag_seo'));
    // sayfa adı veya sayfa url'si boşsa hata ver
    if (!$tagUrl) {
        $error = 'Lütfen tüm alanları doldurunuz!';
    } else {
        // etiket var mı kontrol et
        $query = $db->from('tags')
            ->where('tag_url', $tagUrl)
            ->first();
        // sorgulanan sayfa varsa
        if ($query) {
            $error = '<strong>' . $tagName . '</strong> adında bir etiket zaten mevcut, lütfen başka bir isim deneyiniz!';
        } else {
            demoUser('tags');
            // yoksa sayfayi ekleme işlemini yap
            $query = $db->insert('tags')
                ->set([
                    'tag_name' => $tagName,
                    'tag_url' => $tagUrl,
                    'tag_seo' => $tagSeo
                ]);
            // ekleme işlemi başarılıysa sayfaler alanına yönlendir
            if ($query) {
                $success = "İşlem başarıyla tamamlandı.";
                $_SESSION['log_success'] = $success ?? null;
                header('Location: ' . adminUrl('tags'));
                exit;
            } else {
                $error = 'Bir sorun oluştu!';
            }
        }
    }
}
$_SESSION['log_error'] = $error ?? null;

// menü ekleme html alanının gösterilmesi
require adminView('add-tag');