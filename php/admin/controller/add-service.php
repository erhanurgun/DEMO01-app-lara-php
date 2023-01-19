<?php
// izin kontrol işlemi
if (!permission('services', 'add')) {
    permissionPage();
}

// form gönderildiyse
if (post('submit')) {
    // sayfaya ait verileri al
    $serviceTitle = post('service_title');
    $serviceUrl = sefLink(post('service_url'));
    $serviceIcon = post('service_icon');
    // sayfa URL boşsa sayfa adını URL olarak al
    if (!post('service_url')) {
        $serviceUrl = sefLink($serviceTitle);
    }
    // sayfa içeriğini çekme
    $serviceContent = post('service_content');
    // sayfaya ait başlık ve açıklamaları json formatına çevir
    $serviceSeo = json_encode(post('service_seo'));
    // sayfa adı veya sayfa url'si boşsa hata ver
    if (!$serviceUrl || !$serviceContent) {
        $error = 'Lütfen tüm alanları doldurunuz!';
    } else {
        // sayfa var mı komtrol et
        $query = $db->from('services')
            ->where('service_url', $serviceUrl)
            ->first();
        // sorgulanan sayfa varsa
        if ($query) {
            $error = '<strong>' . $serviceTitle . '</strong> adında bir hizmet zaten mevcut, lütfen başka bir isim deneyiniz!';
        } else {
            demoUser('services');
            // yoksa sayfayi ekleme işlemini yap
            $query = $db->insert('services')
                ->set([
                    'service_title' => $serviceTitle,
                    'service_url' => $serviceUrl,
                    'service_icon' => $serviceIcon,
                    'service_content' => $serviceContent,
                    'service_seo' => $serviceSeo
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

// menü ekleme html alanının gösterilmesi
require adminView('add-service');