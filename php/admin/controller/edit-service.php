<?php
// izin kontrol işlemi
if (!permission('services', 'edit')) {
    permissionPage();
}

$id = get('id');
// eğer id değeri yolsa sayfayı yönlendir
if (!$id) {
    header('Location: ' . adminUrl('services'));
    exit();
}

// verileri çekme
$row = $db->from('services')
    ->where('service_id', $id)
    ->first();

// istenen veri bulunamadıysa yönlendir
if (!$row) {
    header('Location: ' . adminUrl('service'));
    exit();
}

// form gönderildiyse
if (post('submit')) {
    // sayfaya ait verileri al
    $serviceTitle = post('service_title');
    $serviceUrl = post('service_url');
    $serviceIcon = post('service_icon');
    $serviceStatus = post('service_status');
    // sayfa URL boşsa sayfa adını URL olarak al
    if (!post('service_url')) {
        $serviceUrl = sefLink($serviceTitle);
    }
    // sayfa içeriğini çekme
    $serviceContent = post('service_content');
    // sayfaya ait başlık ve açıklamaları json formatına çevir
    $serviceSeo = json_encode(post('service_seo'));
    // sayfa adı veya sayfa url'si boşsa hata ver
    if (!$serviceUrl || !$serviceContent || !$serviceIcon) {
        $error = 'Lütfen tüm alanları doldurunuz!';
    } else {
        // sayfa var mı komtrol et
        $query = $db->from('services')
            ->where('service_url', $serviceUrl)
            ->where('service_id', $id, '!=')
            ->first();
        // sorgulanan sayfa varsa
        if ($query) {
            $error = '<strong>' . $serviceTitle . '</strong> adında bir hizmet zaten mevcut, lütfen başka bir isim deneyiniz!';
        } else {
            demoUser('services');
            // yoksa sayfayi ekleme işlemini yap
            $query = $db->update('services')
                ->where('service_id', $id)
                ->set([
                    'service_title' => $serviceTitle,
                    'service_url' => $serviceUrl,
                    'service_icon' => $serviceIcon,
                    'service_content' => $serviceContent,
                    'service_seo' => $serviceSeo,
                    'service_status' => $serviceStatus
                ]);
            // ekleme işlemi başarılıysa sayfaler alanına yönlendir
            if ($query) {
                $success = "İşlem başarıyla tamamlandı.";
                $_SESSION['log_success'] = $success ?? null;
                header('Location: ' . adminUrl('services'));
                exit;
            } else {
                $error = 'Bir sorun oluştu!';
            }
        }
    }
}
$_SESSION['log_error'] = $error ?? null;

$seo = json_decode($row['service_seo'], true);

// menü ekleme html alanının gösterilmesi
require adminView('edit-service');