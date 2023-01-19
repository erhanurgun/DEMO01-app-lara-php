<?php

// izin kontrol işlemi
if (!permission('settings', 'show')) {
    permissionPage();
}

$mods = [
    1 => "Aktif",
    0 => "Pasif"
];

// tüm tema klasörlerini getirme
$themes = [];
foreach (glob(PATH . '/app/view/*/') as $folder) {
    $folder = explode('/', rtrim($folder, '/'));
    $themes[] = end($folder);
}

// eğer ayar post işlemi yapıldıysa
if (post('submit')) {
    // düzenleme yekisi yoksa
    if (!permission('settings', 'edit')) {
        $error = 'Ayarları düzenleme yetkiniz bulunmuyor!';
    } else {
        demoUser('settings');
        // yetki varsa ayarları dizi yardımıyla oluştur
        $html = '<?php' . PHP_EOL . PHP_EOL;
        echo '<pre>';
        foreach (array_filter(post('settings'), 'removeEmpty') as $key => $val) {
            $html .= '$settings["' . $key . '"] = "' . $val . '";' . PHP_EOL;
        }
        // ayarları kaydet
        file_put_contents(PATH . '/app/settings.php', $html);
        // sayfayı yönlendir
        $success = "İşlem başarıyla tamamlandı.";
        $_SESSION['log_success'] = $success ?? null;
        header('Location: ' . adminUrl('settings'));
        exit;
    }
}

// ayarlar bu alanda listelensin
require adminView('settings');
