<?php

// izin kontrol işlemi
if (!permission('categories', 'add')) {
    permissionPage();
}

// form gönderildiyse
if (post('submit')) {
    // eğer yönetici demo yetkisindeyse
    // kategoriye ait verileri al
    $categoryName = post('category_name');
    $categoryUrl = sefLink(post('category_url'));
    // kategori URL boşsa kategori adını URL olarak al
    if (!post('category_url')) {
        $categoryUrl = sefLink($categoryName);
    }
    // kategoriye ait başlık ve açıklamaları json formatına çevir
    $categorySeo = json_encode(post('category_seo'));
    // kategori adı veya kategori url'si boşsa hata ver
    if (!$categoryName || !$categoryUrl) {
        $error = 'Lütfen kategori adını belirtiniz!';
    } else {
        // kategori var mı komtrol et
        $query = $db->from('categories')
            ->where('category_url', $categoryUrl)
            ->first();
        // sorgulanan kategori varsa
        if ($query) {
            $error = '<strong>' . $categoryName . '</strong> adında bir kategori zaten mevcut, lütfen başka bir isim deneyiniz!';
        } else {
            demoUser('categories');
            // yoksa kategoriyi ekleme işlemini yap
            $query = $db->insert('categories')
                ->set([
                    'category_name' => $categoryName,
                    'category_url' => $categoryUrl,
                    'category_seo' => $categorySeo
                ]);
            // ekleme işlemi başarılıysa kategoriler alanına yönlendir
            if ($query) {
                $success = "İşlem başarıyla tamamlandı.";
                $_SESSION['log_success'] = $success ?? null;
                header('Location: ' . adminUrl('categories'));
                exit;
            } else {
                $error = 'Bir sorun oluştu!';
            }
        }
    }
}
$_SESSION['log_error'] = $error ?? null;

// menü ekleme html alanının gösterilmesi
require adminView('add-category');