<?php
// izin kontrol işlemi
if (!permission('categories', 'edit')) {
    permissionPage();
}

// id değeri yoksa kategorilere yönlendir
$id = get('id');
if (!$id) {
    header('Location: ' . adminUrl('categories'));
    exit;
}
// eğer kategorilerde gelen id'ye ait veri var mı
$row = $db->from('categories')
    ->where('category_id', $id)
    ->first();
// veri yoksa kategorilere yönlendir
if (!$row) {
    header('Location: ' . adminUrl('categories'));
    exit;
}

// form gönderildiyse
if (post('submit')) {
    // gönderilen değerleri al
    $categoryName = post('category_name');
    $categoryUrl = sefLink(post('category_url'));
    // kategori url değeri yoksa kategori adına göre al
    if (!post('category_url')) {
        $categoryUrl = sefLink($categoryName);
    }
    // kategori SEO'dan gelen verileri JSON formatına çevir
    $categorySeo = json_encode(post('category_seo'));
    // kategori adı veya kategori URL'si yoksa
    if (!$categoryName || !$categoryUrl) {
        $error = 'Lütfen kategori adını belirtiniz!';
    } else {
        // kategori var mı komtrol et
        $query = $db->from('categories')
            ->where('category_url', $categoryUrl)
            ->where('category_id', $id, '!=')
            ->first();
        // kategori varsa
        if ($query) {
            $error = '<strong>' . $categoryName . '</strong> adında bir kategori zaten mevcut, lütfen başka bir isim deneyiniz!';
        } else {
            demoUser('categories');
            // kategori yoksa güncelle
            $query = $db->update('categories')
                ->where('category_id', $id)
                ->set([
                    'category_name' => $categoryName,
                    'category_url' => $categoryUrl,
                    'category_seo' => $categorySeo
                ]);
            // güncelleme işlemi başarılıysa
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

// json formatındaki seo verilerini diziye çevir
$categorySeo = json_decode($row['category_seo'], true);

// menü ekleme html alanının gösterilmesi
require adminView('edit-category');