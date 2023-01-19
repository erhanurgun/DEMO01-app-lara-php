<?php

// izin kontrol işlemi
if (!permission('menus', 'add')){
    permissionPage();
}

// eğer post işlemi yapıldıysa
if (post('submit')){
    // menüye ait elemanları al
    $menu = [];
    $menuTitle = post('menu_title');
    // eğer menü başlığı boşsa
    if (!$menuTitle){
        $error = 'Menü başlığını belirtin';
    }
    // eğer hiç menü elemanı yoksa
    elseif (count(array_filter(post('title'))) == 0) {
        $error = 'En az bir menü içeriği girmeniz gerekiyor';
    }
    else {
        // menü mimarisini kurma
        $urls = post('url');
        // menü başlıklarına göre döngüye al
        foreach (post('title') as $key => $title) {
            $arr = [
                'title' => $title,
                'url' => $urls[$key]
            ];
            // eğer alt başlık varsa
            if (post('sub_title_' . $key)){
                $subMenu = [];
                $subUrls = post('sub_url_' . $key);
                // alt başlıklara göre yeniden döngüye al
                foreach (post('sub_title_' . $key) as $k => $subTitle) {
                    $subMenu[] = [
                        'title' => $subTitle,
                        'url' => $subUrls[$k]
                    ];
                }
                // alt başlıkları diziye aktar
                $arr['submenu'] = $subMenu;
            }
            // diziyi menüye aktar
            $menu[] = $arr;
        }
        demoUser('menus');
        // menüyü veritabanına ekle
        $query = $db->prepare('INSERT INTO menus SET menu_title = :title, menu_content = :content');
        $result = $query->execute([
            'title' => $menuTitle,
            'content' => json_encode($menu)
        ]);
        // ekleme işlemi başarılıysa menüler alanına gönder
        if ($result){
            $success = "İşlem başarıyla tamamlandı.";
            $_SESSION['log_success'] = $success ?? null;
            header('Location: ' . adminUrl('menus'));
            exit;
        } else {
            $error = 'Bir sorun oluştu ve menü eklenemedi!';
        }
    }
}
$_SESSION['log_error'] = $error ?? null;

// menü ekleme html alanının gösterilmesi
require adminView('add-menu');